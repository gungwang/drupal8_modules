<?php

namespace Drupal\first_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'AdageBlock' block.
 *
 * @Block(
 *  id = "adage_block",
 *  admin_label = @Translation("As They Say"),
 * )
 */
class AdageBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
          ] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['adage'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Adage'),
      '#default_value' => $this->configuration['adage'],
      '#maxlength' => 128,
      '#size' => 64,
      '#weight' => '0',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['adage'] = $form_state->getValue('adage');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['adage_block_adage']['#markup'] = '<p>' . $this->configuration['adage'] . '</p>';

    return $build;
  }

}
