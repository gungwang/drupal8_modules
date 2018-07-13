<?php

namespace Drupal\layout_library\Plugin\SectionStorage;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Drupal\field_ui\FieldUI;
use Drupal\layout_builder\Entity\LayoutBuilderSampleEntityGenerator;
use Drupal\layout_builder\Plugin\SectionStorage\SectionStorageBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouteCollection;
use Drupal\Core\Plugin\Context\Context;
use Drupal\Core\Plugin\Context\ContextDefinition;

/**
 * Defines a class for library based layout storage.
 *
 * @SectionStorage(
 *   id = "layout_library",
 * )
 */
class Library extends SectionStorageBase implements ContainerFactoryPluginInterface {

  /**
   * Entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Sample entity generation.
   *
   * @var \Drupal\layout_builder\Entity\LayoutBuilderSampleEntityGenerator
   */
  protected $sampleEntityGenerator;

  /**
   * Constructs a new Library object.
   *
   * @param array $configuration
   *   Configuration.
   * @param string $plugin_id
   *   ID.
   * @param mixed $plugin_definition
   *   Definition.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   Entity type manager.
   * @param \Drupal\layout_builder\Entity\LayoutBuilderSampleEntityGenerator $sampleEntityGenerator
   *   Sample entity generator.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entityTypeManager, LayoutBuilderSampleEntityGenerator $sampleEntityGenerator) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entityTypeManager;
    $this->sampleEntityGenerator = $sampleEntityGenerator;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('layout_builder.sample_entity_generator')
    );
  }

  /**
   * Gets the layout.
   *
   * @return \Drupal\layout_builder\SectionListInterface|\Drupal\layout_library\Entity\Layout
   *   Layout.
   */
  protected function getLayout() {
    return $this->getSectionList();
  }

  /**
   * {@inheritdoc}
   */
  public function getStorageId() {
    return $this->getLayout()->id();
  }

  /**
   * {@inheritdoc}
   */
  public function getSectionListFromId($id) {
    if ($layout = $this->entityTypeManager->getStorage('layout')->load($id)) {
      return $layout;
    }
    throw new \InvalidArgumentException(sprintf('The "%s" ID for the "%s" section storage type is invalid', $id, $this->getStorageType()));
  }

  /**
   * {@inheritdoc}
   */
  public function buildRoutes(RouteCollection $collection) {
    foreach ($this->getEntityTypes() as $entity_type_id => $entity_type) {
      // Try to get the route from the current collection.
      if (!$entity_route = $collection->get($entity_type->get('field_ui_base_route'))) {
        continue;
      }
      // Add a layout-library URL off the tail of each manage display.
      $path = $entity_route->getPath() . '/layout-library/{layout}';

      $defaults = [];
      $defaults['entity_type_id'] = $entity_type_id;
      // If the entity type has no bundles and it doesn't use {bundle} in its
      // admin path, use the entity type.
      if (strpos($path, '{bundle}') === FALSE) {
        if (!$entity_type->hasKey('bundle')) {
          $defaults['bundle'] = $entity_type_id;
        }
        else {
          $defaults['bundle_key'] = $entity_type->getBundleEntityType();
        }
      }

      $requirements = [];
      $requirements['_field_ui_view_mode_access'] = 'administer ' . $entity_type_id . ' display';

      $options = $entity_route->getOptions();
      $options['_admin_route'] = FALSE;
      $options['parameters']['layout']['type'] = 'entity:layout';

      $this->buildLayoutRoutes($collection, $this->getPluginDefinition(), $path, $defaults, $requirements, $options, $entity_type_id);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getRedirectUrl() {
    return Url::fromRoute('entity.layout.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getLayoutBuilderUrl() {
    return Url::fromRoute("layout_builder.{$this->getStorageType()}.{$this->getLayout()->getTargetEntityType()}.view", $this->getRouteParameters());
  }

  /**
   * {@inheritdoc}
   */
  protected function getRouteParameters() {
    $layout = $this->getLayout();
    $route_parameters = FieldUI::getRouteBundleParameter($this->entityTypeManager->getDefinition($layout->getEntityTypeId()), $layout->getTargetBundle());
    $route_parameters['layout'] = $this->getLayout()->id();
    return $route_parameters;
  }

  /**
   * Returns an array of relevant entity types.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface[]
   *   An array of entity types.
   */
  protected function getEntityTypes() {
    return array_filter($this->entityTypeManager->getDefinitions(), function (EntityTypeInterface $entity_type) {
      return $entity_type->entityClassImplements(FieldableEntityInterface::class) && $entity_type->hasViewBuilderClass() && $entity_type->get('field_ui_base_route');
    });
  }

  /**
   * {@inheritdoc}
   */
  public function extractIdFromRoute($value, $definition, $name, array $defaults) {
    return $value ?: $defaults['layout'];
  }

  /**
   * Provides any available contexts for the object using the sections.
   *
   * @return \Drupal\Core\Plugin\Context\ContextInterface[]
   *   The array of context objects.
   */
  public function getContexts() {
    $display = $this->getLayout();
    $entity = $this->sampleEntityGenerator->get($display->getTargetEntityType(), $display->getTargetBundle());
    $context_label = new TranslatableMarkup('@entity being viewed', ['@entity' => $entity->getEntityType()->getLabel()]);

    // @todo Use EntityContextDefinition after resolving
    //   https://www.drupal.org/node/2932462.
    $contexts = [];
    $contexts['layout_builder.entity'] = new Context(new ContextDefinition("entity:{$entity->getEntityTypeId()}", $context_label), $entity);
    return $contexts;
  }

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->getLayout()->label();
  }

  /**
   * {@inheritdoc}
   */
  public function save() {
    return $this->getLayout()->save();
  }

}
