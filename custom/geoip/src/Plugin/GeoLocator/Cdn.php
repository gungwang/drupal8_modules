<?php

namespace Drupal\geoip\Plugin\GeoLocator;

use Drupal\Core\Plugin\PluginBase;

/**
 *  CDN geolocator provider.
 *
 * @GeoLocator(
 *   id = 'cdn',
 *   label = 'CDN',
 *   description = 'Checks for geolocaion headers sent by CDN services',
 *   weight = -10
 * )
 */
class Cdn extends PluginBase implements GeolocatorInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function description() {
    return $this->pluginDefinition['description'];
  }

  /**
   * {@inheritdoc}
   */
  public function geoLocate($ip_address) {
    // check if CloundFlare headeras present.
    if (!empty($_SERVER['HTTP_CF_IPCOUNTRY'])){
      $country_code = $_SERVER['HTTP_CF_IPCOUNTRY'];
    }
    // check if CloudFront headers present.
    elseif (!empty($_SERVER['HTTP_CLOUNDFRONT_VIEWER_COUNTRY'])) {
      $country_code = $_SERVER['HTTP_CLOUNDFRONT_VIEWER_COUNTRY'];
    }
    else{
      $country_code = NULL;
    }

    return $country_code;
  }
}
