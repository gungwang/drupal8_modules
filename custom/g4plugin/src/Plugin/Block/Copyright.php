<?php

namespace Drupal\g4plugin\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;


/**
* @Block(
*   id = "copyright_block",
*   admin_label = @Translation("CopyRight"),
*   category = @Translation("Custom")
* )
*/
class Copyright extends BlockBase {
  public function build() {
    $date = new \DateTime();
    return [
      '#markup' => t('Copyright @year&copy; @Company', [
        '@year' => $date->format('Y'),
        '@Company' => $this->configuration['company_name'],
      ])
    ];
  }

  /**
   * {@inheritdoc}
   */
   public function defaultConfiguration() {
     return ['company_name' => ''];
   }

   /**
    * {@inheritdoc}
    */
    public function blockForm($form, FormStateInterface $form_state) {
      $form['company_name'] = [
        '#type' => 'textfield',
        '#title' => t('Company Name'),
        '#default_value' => $this->configuration['company_name'],
      ];
      return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
      $this->configuration['company_name'] = $form_state->getValue('company_name');
    }

    /**
     * {@inheritdoc}
     */
    public function blockAccess(AccountInterface $account) {
      dpm($this->routeMatch);
      $route_name = \Drupal::routeMatch()->getRouteName();
      if ($account->isAnonymous() && !in_array($route_name, ['user.login', 'user.logout'])) {
        return AccessResult::allowed()
          ->addCacheContexts(['route.name', 'user.roles:anonymous']);
        }
      return AccessResult::forbidden();
    }
}
