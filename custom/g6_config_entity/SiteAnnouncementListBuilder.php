<?php

namespace Drupal\g6_config_entity;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\g6_config_entity\Entity\SiteAnnouncementInterface;

class SiteAnnouncementListBuilder extends ConfigEntityListBuilder {

  public function buildHeader() {
    $header['label'] = t('Label');
    return $header + parent::buildHeader();
  }

  public function buildRow(SiteAnnouncementInterface $entity) {
    $row['label'] = $entity->lable();
    return $row + parent::buildRow($entity);
  }
}
