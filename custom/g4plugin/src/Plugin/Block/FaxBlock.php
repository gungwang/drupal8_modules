<?php
namespace Drupal\g4plugin\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Form\FormStateInterface;

/**
* @Block(
*   id = "fax_number",
*   admin_label = @Translation("Fax block"),
* )
*/
 class FaxBlock extends BlockBase {

   // Access  method here ...

   public function build() {

   $config = $this->getConfiguration();
     $fax_number = isset($config['fax_number']) ? $config['fax_number'] : '';
     return array(
       '#markup' => $this->t('The fax number is @number!', array('@number' => $fax_number)),
     );
   }

   public function blockForm($form, FormStateInterface $form_state) {
     $form = parent::blockForm($form, $form_state);

     // Retrieve existing configuration for this block.
     $config = $this->getConfiguration();

     // Add a form field to the existing block configuration form.
     $form['fax_number'] = array(
       '#type' => 'textfield',
       '#title' => t('Fax number'),
       '#default_value' => isset($config['fax_number']) ? $config['fax_number'] : '',
     );

     return $form;
   }


   public function blockSubmit($form, FormStateInterface $form_state) {
     // Save our custom settings when the form is submitted.
     $this->setConfigurationValue('fax_number', $form_state->getValue('fax_number'));
   }


   public function blockValidate($form, FormStateInterface $form_state) {
     $fax_number = $form_state->getValue('fax_number');

     if (!is_numeric($fax_number)) {
       $form_state->setErrorByName('fax_block_settings', t('Needs to be an integer'));
     }
   }
 }
