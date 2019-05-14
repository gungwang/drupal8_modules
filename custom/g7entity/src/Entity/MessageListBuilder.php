<?php

namespace Drupal\g7entity\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

class MessageListBuilder extends EntityListBuilder {
  public function buildHeader(){
    $header['title'] = t('Title');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {
    $row['title'] = $entity->label();
    // $row['content'] = $entity->getMessage();
    return $row + parent::buildRow($entity);
  }
}
