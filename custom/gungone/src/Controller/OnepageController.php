<?php

namespace Drupal\gungone\Controller;
use Drupal\Core\Controller\ControllerBase;

/**
 * Return responses for Gung One module.
 */

class OnepageController extends ControllerBase {

  /**
   * Retun markup for the custom page
   */
   public function getOnePage() {
     return [
       '#markup' => t('Welcome my first custom page!'),
     ];

   }

   public function getCats($name) {
     // return "My Cat name is wwww";
     // $name = "Tom Cat";
     if(!isset($name)){
       return [
         '#markup' => t('custom page cat!'),
       ];
     }
     return [
       '#markup' => t('My cats name is: @name', [ '@name' => $name, ]),
     ];
   }

   public function customPage(){
     return [
       '#markup' => t('This is a page of route_callbacks from OnepageController class.')
     ];
   }

   public function getThirdPage(){
     $str = stristr('dasdf', 'aa');
     
   }
}
