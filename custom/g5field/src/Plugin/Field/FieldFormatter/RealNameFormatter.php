<?php
namespace Drupal\g5field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;


/**
 * @FieldFormatter(
 *   id = "realname_one_line",
 *   label = @Translation("Real name in one line"),
 *   field_types = {
 *     "realname"
 *   }
 * )
 */

class RealNameFormatter extends FormatterBase {
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $language) {
    $element = [];
    foreach ($items as $delta => $item) {
      $element[$delta] = [
        '#markup' => $this->t('@first @last', [
          '@first' => $item->first_name,
          '@last' => $item->last_name  ] ),
      ];


    }


  }
}
