<?php

namespace Drupal\seo\Controller;
use Drupal\Core\Controller\ControllerBase;

class SeoController  extends ControllerBase {


  public function seoIntro(){

    return array (
      '#title' => "SEO",
      '#markup' => "SEO Project and Topics"
    );

  }

  public function seoList(){
    // return array (
    //   '#theme' => 'seolist',
    //   '#title' => "abc SEO",
    //   '#markup' => "abc Project and Topics",
    //   '#items' => "fsdafasdf Project and Topics"
    // );


    return array(
      '#theme' => 'seolist',
      '#items' => $this->getProjectList(),
      '#title' => 'Seo Project List'
    );

  }


  protected function getProjectList(){
    return array(
      array("name" => "SEO Poject 1"),
      array("name" => "SEO Poject 2"),
      array("name" => "SEO Poject 3"),
      array("name" => "SEO Poject 4"),
      array("name" => "SEO Poject 43"),
    );

  }

}




?>
