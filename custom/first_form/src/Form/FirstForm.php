<?php

namespace Drupal\first_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class FirstForm.
 */
class FirstForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'first_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#description' => $this->t('Your username with characters and numbers only'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
      '#attributes' => array('class' => array('username'), 'autocomplete' => 'username'),
    ];
    $form['phone_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#description' => $this->t('Phone number like 5856661234'),
      '#maxlength' => 12,
      '#size' => 64,
      '#weight' => '0',
      '#attributes' => array('class' => array('phone'), 'autocomplete' => 'tel-national'),
    ];
    $form['your_pass'] = [
      '#type' => 'password_confirm',
      '#description' => $this->t('At least 8 characters containing at least one Upper case and one Number'),
      '#maxlength' => 16,
      '#size' => 64,
      '#weight' => '0',
      '#attributes' => array('class' => array('password'), 'autocomplete' => 'new-password'),
      // '#value' => $this->value,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#title' => $this->t('Submit'),
      '#value' => t('Sumbit Form'),
      '#weight' => '0',
      '#attributes' => array('class' => 'btn-primary'),
    ];


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->hasValue('your_pass')) {
      $pass = $form_state->getValue('your_pass');

      if (strlen($pass) < 8 ) {
        $form_state->setErrorByName('your_pass', t('Password length must be at least 8 characters.'));
      }
      if( !preg_match('/[A-Z]/', $pass)){
        $form_state->setErrorByName('your_pass', t('Password must contains at least one Capital Letter.'));
      }
      if( !preg_match('/\d/', $pass) ){
        $form_state->setErrorByName('your_pass', t('Password must contains at least one Digital Number.'));
      }
    }
    // parent::validateForm($form, $form_state);

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      if($key == 'your_pass'){
        $value = "************";
      }
      drupal_set_message($key . ' : ' . $value);
    }

    $pass = $form_state->getValues('your_pass');
    $user = $form_state->getValues('username');
    $phone = $form_state->getValues('phone_number');

    \Drupal::state()->set('your_pass', $pass);
    \Drupal::state()->set('username', $user);
    if( isset($phone) ){
      \Drupal::state()->set('phone_number', $phone);
    }

  }

}
