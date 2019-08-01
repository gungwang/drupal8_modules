<?php

// namespace Drupal\g5field\Plugin\Field\FieldType;
namespace Drupal\g5field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
// use Drupal\Core\TypeData\ComplexDtatDefininationInterface;

/**
 * @FieldType(
 *   id = "realname",
 *   label = @Translation("Real Name"),
 *   description = @Translation("This field stores a first and last names."),
 *   category = @Translation("General"),
 *   default_widget = "realname_default",
 *   default_formatter = "realname_one_line"
 * )
 */

class RealName extends FieldItemBase {
  /**
   * {@inheritdoc}
   */

  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'colomn' => [
        'first_name' => [
          'description' => 'First Name',
          'type' => 'varchar',
          'length' => '255',
          'not null' => TRUE,
          'default' => '',
        ],
        'last_name' => [
          'description' => 'Last Name',
          'type' => 'varchar',
          'length' => '255',
          'not null' => TRUE,
          'default' => '',
        ],

      ],

      'index' => [
        'first_name' => ['first_name'],
        'last_name' => ['last_name'],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['first_name'] = DataDefinition::create('string')
      ->setLabel(t("First Name"));
    $properties['last_name'] = DataDefinition:: create('string')
      ->setLabel(t('Last Name'));

    return $properties;
  }
}
