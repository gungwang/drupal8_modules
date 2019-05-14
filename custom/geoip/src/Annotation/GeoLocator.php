<?php

namespace Drupal\geoip\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a GeoLocator annotation object;
 *
 * @Annotation
 *
 */
class GeoLocator extends Plugin {
  /**
   * The humam-readable name.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   *
   */
  public $label;

  /**
   * A description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Tranlation
   *
   * @ingroup plugin_translatable
   */
  public $description;
}
