<?php

namespace Drupal\g6_config_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

Interface SiteAnnouncementInterface extends ConfigEntityInterface {
  public function getMessage();
}
