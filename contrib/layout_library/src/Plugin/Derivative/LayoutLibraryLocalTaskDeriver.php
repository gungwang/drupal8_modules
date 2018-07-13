<?php

namespace Drupal\layout_library\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides local task definitions for the layout builder user interface.
 *
 * @todo Remove this in https://www.drupal.org/project/drupal/issues/2936655.
 *
 * @internal
 */
class LayoutLibraryLocalTaskDeriver extends DeriverBase implements ContainerDeriverInterface {

  use StringTranslationTrait;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new LayoutBuilderLocalTaskDeriver.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach ($this->getEntityTypes() as $entity_type_id => $entity_type) {
      // Defaults.
      $this->derivatives["layout_builder.layout_library.$entity_type_id.view"] = $base_plugin_definition + [
        'route_name' => "layout_builder.layout_library.$entity_type_id.view",
        'title' => $this->t('Manage layout'),
        'base_route' => "layout_builder.layout_library.$entity_type_id.view",
      ];
      $this->derivatives["layout_builder.layout_library.$entity_type_id.save"] = $base_plugin_definition + [
        'route_name' => "layout_builder.layout_library.$entity_type_id.save",
        'title' => $this->t('Save Layout'),
        'parent_id' => "layout_library:layout_builder.layout_library.$entity_type_id.view",
      ];
      $this->derivatives["layout_builder.layout_library.$entity_type_id.cancel"] = $base_plugin_definition + [
        'route_name' => "layout_builder.layout_library.$entity_type_id.cancel",
        'title' => $this->t('Cancel Layout'),
        'weight' => 5,
        'parent_id' => "layout_library:layout_builder.layout_library.$entity_type_id.view",
      ];
    }

    return $this->derivatives;
  }

  /**
   * Returns an array of relevant entity types.
   *
   * @return \Drupal\Core\Entity\EntityTypeInterface[]
   *   An array of entity types.
   */
  protected function getEntityTypes() {
    return array_filter($this->entityTypeManager->getDefinitions(), function (EntityTypeInterface $entity_type) {
      return $entity_type->entityClassImplements(FieldableEntityInterface::class) && $entity_type->hasViewBuilderClass();
    });
  }

}
