<?php
namespace Drupal\gungtwo\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
// use Drupal\Core\Config\ConfigFactoryInterface;

class ExampleForm extends ConfigFormBase {

  public function getFormId() {
    return "gungtwo_example_form";
  }

  protected function getEditableConfigNames() {
    return ['gungtwo.company'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['company_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company Name'),
      '#default_value' => $this->config('gungtwo.company')->get('name'),
      '#required' => TRUE,
    ];
    // echo $this->config('gungtwo.company')->get('name');
    // echo "gungwang test condfig form";
    $form['text1'] = [
      '#type' => 'textfield',
      '#value' => \Drupal::config('gungtwo.company')->get('mycompany'),
      // '#disable' => TRUE,
    ];
    /*
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('SAVE'),
    ];

    $form_state->setValidateHandlers([
      '::validateForm',
      '::validateG1',
      [$this, 'validateG2'],
    ]);

    return $form;
    */
    return parent::buildForm($form, $form_state);

  }
  /**
   * {@inheritdoc}
   */

  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!$form_state->isValueEmpty('company_name')){
      if(strlen($form_state->getValue('company_name')) <= 5){
        $form_state->setErrorByName('company_name', t('Company Name must be more than 5 characters!'));

      }
    }
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    // $this->config('gungtwo.company')->set('name', $form_state->getValue('company_name'));
    $config = \Drupal::configFactory()->getEditable('gungtwo.company');
    $config
    ->set('mycompany', $form_state->getValue('company_name'))
    ->save();
  }


  public function validateG1(array &$form, FormStateInterface $form_state) {
    if (!$form_state->isValueEmpty('company_name')){
      if(strlen($form_state->getValue('company_name')) >= 14){
        $form_state->setErrorByName('company_name', t('Company Name must be less than 15 characters!'));

      }
    }
  }

  public function validateG2(array &$form, FormStateInterface $form_state) {
    if (!$form_state->isValueEmpty('company_name')){

    }
  }

  /**
  *
  */

}


 ?>
