<?php

namespace Drupal\products\Access;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityHandlerInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\webprofiler\Entity\EntityManagerWrapper; // I added this as the error of construct
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\products\Entity\ProductInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Access controller for the Product entity type.
 */
class ProductAccessControlHandler extends EntityAccessControlHandler implements EntityHandlerInterface {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * ProductAccessControlHandler constructor.
   *
   * @param EntityTypeInterface $entity_type
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   * I changed to EntityManagerWrapper as the error below
   * @param \Drupal\Core\Entity\EntityManagerWrapper $entityTypeManager
   * TypeError: Argument 2 passed to Drupal\products\Access\ProductAccessControlHandler::__construct() must be an instance of Drupal\Core\Entity\EntityTypeManager, instance of Drupal\webprofiler\Entity\EntityManagerWrapper given, called in /var/www/www.gungwang.com/html/modules/custom/products/src/Access/ProductAccessControlHandler.php on line 44 in Drupal\products\Access\ProductAccessControlHandler->__construct() 
   */
  public function __construct(EntityTypeInterface $entity_type, EntityTypeManager $entityTypeManager) {
    parent::__construct($entity_type);
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {

    return new static(
      $entity_type,
      // Injecting this service just for demonstration purposes. It is not used
      // anywhere and should not be injected if not used.
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var ProductInterface $entity */
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view product entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit product entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete product entities');
    }

    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add product entities');
  }
}
