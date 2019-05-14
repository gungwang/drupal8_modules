<?php

namespace Drupal\g5field\Plugin\Field\FieldWidget;
// namespace Drupal\g5field\Plugin\Field\FieldWidget\RealNameDefaultWidgetk;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

 /**
  * Plugin implementation of the 'realname_default' widget.
  *
  * @FieldWidget(
  *   id = "realname_default",
  *   label = @Translation("Real Name"),
  *   field_types = {
  *     "realname"
  *   },
  * )
  */
class RealNameDefaultWidget extends WidgetBase {
  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $item, $delta, array $element,
    array &$form, FormStateInterface $form_state) {
      // $element = parent::formElement($items, $delta, $element, $form, $form_state);
      $element['first_name'] = [
        '#type' => 'textfield',
        '#title' => t('First Name'),
        '#default_value' => "",
        '#size' => '25',
        '#required' => $element['#required'],
      ];
      $element['last_name'] = [
        '#type' => 'textfield',
        '#title' => t('Last Name'),
        '#default_value' => '',
        '#size' => '25',
        '#required' => $element['#required'],
      ];

      return $element;
    }

}
