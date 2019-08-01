<?php
namespace Drupal\gungtwo\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class E2Form extends FormBase {

  public function getFormId() {
    return "gungtwo_e2_form";
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['company_name'] = [
      '#type' => 'textfield',
      '#title' => t('Test Name'),

    ];
    $form['telephone'] = [
      '#type' => 'tel',
      '#title' => t('Telephone Number'),
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => t('Your Email'),
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => t('Your Age'),
      '#step' => 1,
      '#min' => 18,
      '#max' => 50,
    ];

    $form['date'] = [
      '#type' => 'date',
      '#title' => t('Your Birthday'),
      '#date_date_format' => 'Y-m-d',
    ];

    $form['website'] = [
      '#type' => 'url',
      '#type' => $this->t('Your personal website URL'),

    ];

    $form['search'] = [
      '#type' => 'search',
      '#title' => $this->t('Search'),
      '#autocomplete_route_name' => FALSE,
    ];

    $form['start_end'] = [
      '#type' => 'range',
      '#title' => 'Start number and End nunber',
      '#step' => 1,
      '#min' => 1,
      '#max' => 200
    ];
    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('SAVE'),
    ];

    return $form;
  }
  /**
   * {@inheritdoc}
   */

  public function validateForm(array &$form, FormStateInterface $form_state) {

  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
}


 ?>
