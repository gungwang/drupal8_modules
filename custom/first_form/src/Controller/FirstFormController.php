<?php

namespace Drupal\first_form\Controller;
use Drupal\Core\Controller\ControllerBase;

class FirstFormController  extends ControllerBase {


  public function getFormResults(){
    $val = \Drupal::state()->get('username');

    // print_r($val); exit;
    return array(
      '#theme' => 'form_results',
      '#items' => $this->getList($val),
      '#title' => 'My first form results'
    );
  }



    protected function getList(&$arr){
      return array(
        array("label"=> "Username" , "name" => $arr['username']),
        array("label"=> "Phone Number" , "name" => $arr['phone_number']),
        array("label"=> "Password" , "name" => "************"),
      );

    }

}




?>
