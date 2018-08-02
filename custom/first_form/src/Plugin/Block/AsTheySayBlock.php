<?php

namespace Drupal\first_form\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'AdageBlock' block.
 *
 * @Block(
 *  id = "as_they_say_block",
 *  admin_label = @Translation("As They Say Block"),
 * )
 */
class AsTheySayBlock extends BlockBase {

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
    $form['astheysay'] = [
      '#type' => 'textfield',
      '#title' => $this->t('As They Say'),
      '#default_value' => $this->configuration['astheysay'],
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
    $this->configuration['astheysay'] = $form_state->getValue('astheysay');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['astheysay_block_astheysay']['#markup'] = '<p>' . $this->configuration['astheysay'] . '</p>';

    return $build;
  }

}
