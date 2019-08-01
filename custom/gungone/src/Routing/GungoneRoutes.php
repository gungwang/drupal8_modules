<?php

namespace Drupal\gungone\Routing;

use Symfony\Component\Routing\Route;

class GungoneRoutes {
  public function routes() {
    $routes = [];
    $routes['gungone.mypage'] = new Route(
      // path definiation
      'demo/mypage',
      // Route defaults
      [
        '_controller' => '\Drupal\gungone\Controller\OnepageController:customPage',
        '_title' => 'My customee page',
      ],
      [
        '_permission' => 'access content',
      ]
    );
    return $routes;
  }


}
