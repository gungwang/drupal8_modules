<?php

namespace Drupal\geoip;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Copre\Extension\ModuleHandlerInterface;

class GeoLocatorManager extends DefaultPluginManager {
  /**
   * Default values for each plugin.
   * @var array
   */
  protected $default = [
    'label' => '',
    'description' => '',
    'weight' => 0,
  ];

  /**
   * Constructs a new GeoLocationManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the orresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backed instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The moduel handler
   *
   */
   public function construct(\Traversable $namespaces,
   CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
     parent::__construct(
       'Plugin/GeoLocator',
       $namespaces,
       $module_handler,
       'Drupal\geoip\Plugin\GeoLocator\GeoLocatorInterface',
       'Drupal\geoip\Annotation\GeoLocator'
     );
     $this->alterInfo('geolocator_info');
     $this->setCacheBacked($cache_backend, 'geolocator_plugin');
   }



}
