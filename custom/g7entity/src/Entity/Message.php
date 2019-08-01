<?php

namespace Drupal\g7entity\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\g7entity\Entity\MessageInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
* Defines the profile entity class.
*
* @ContentEntityType(
*   id = "message",
*   label = @Translation("Message"),
*   handlers = {
*     "list_builder" = "Drupal\g7entity\Entity\MessageListBuilder",
*     "form" = {
*       "default" = "Drupal\Core\Entity\ContentEntityForm",
*       "add" = "Drupal\Core\Entity\ContentEntityForm",
*       "edit" = "Drupal\Core\Entity\ContentEntityForm",
*       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
*     },
*     "route_provider" = {
*       "html" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
*     },
*   },
*   admin_permission = "administer message",
*   base_table = "message",
*   fieldable = TRUE,
*   entity_keys = {
*     "id" = "message_id",
*     "label" = "title",
*     "langcode" = "langcode",
*     "uuid" = "uuid"
*   },
*   links = {
*    "canonical" = "/messages/{message}",
*    "edit-form" = "/messages/{message}/edit",
*    "delete-form" = "/messages/{message}/delete",
*    "collection" = "/admin/content/messages"
*   },
* )
*/

class Message extends ContentEntityBase implements MessageInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view',
        array(
          'label' => 'hidden',
          'type' => 'string',
          'weight' => -5,
        ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form',
        array(
          'type' => 'string_textfield',
          'weight' => -5,
        ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['content'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Content'))
      ->SetDescription(t('Content of the message'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view',
        array(
          'label' =>'hidden',
          'type' => 'text_default',
          'weight' => 0,
        ))
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form',
        array(
          'type' => 'text_textfield',
          'weight' => 0,
        ))
      ->setDisplayConfigurable('form', TRUE);

      return $fields;
  }

  public function getMessage() {
    return $this->get('content')->value;
  }

}
