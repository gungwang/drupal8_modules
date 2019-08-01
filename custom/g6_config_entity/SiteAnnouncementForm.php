<?php

namespace Drupal\g6_config_entity;

use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageInterface;

class SiteAnnouncementForm extends EntityForm {

  public function form(array $form, FormStateInterface $form_state) {
    $form = parrent::form($form, $form_state);
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => t('Label'),
      '#required' => TRUE,
      '#default_value' => $entity->label(),

    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
      '#default_value' => $entity->getMessage(),

    ];

    return $form;
  }

  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $is_new = !$entity->getOriginalId();

    if($is_new) {
      $machine_name = \Drupal::transliteration()
        ->transliterate($entity->label(), LanguageInteface::LANGCODE_DEFAULT, '_');
      $entity->set('id', Unicode::strtolower($machine_name));

      drupal_set_message(t('The %label announcement has been created.', array('%label' => $entity-label())));

    }
    else {
      drupal_set_message(t('Updated the %label announcement.', array('%label' => $entity->label() )) ) ;
    }

    $entity->save();

    $form_state->setRedirectUrl($this->entityu->toUrl('collection'));
  }

  public function getFullName() {
    return "Gung Wang" ; 
  }

}
