<?php

namespace Drupal\gungone\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
   public function alterRoutes (RouteCollection $colletion){
     // change path of gungone.mypage to use a hyphen
     if ($route = $colletion->get('gungone.mypage')) {
       $route->setPath('/page/my-page');
     }
   }

}
