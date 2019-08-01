<?php
namespace Drupal\g7entity\Entity;

use Drupal\Core\Entity\ContentEntityInterface;

Interface MessageInterface extends ContentEntityInterface {

  public function getMessage();
}
