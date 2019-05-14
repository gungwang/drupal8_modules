<?php
namespace Drupal\gungone\EventSubscriber;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountProxyInterface;

class RequestSubscriber implements EventSubscriberInterface {

/**
 * The route match
 * @var \Drupal\Core\Routing\RouteMatchInterface
 */
  protected $routeMatch;
  /**
   * Account Proxy.
   * @var \Drupal\Core\Session\AccountProxyInterface
   */

  protected $accountProxy;

  /**
   * Creates a new RequestSubscriber object.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   * The route match.
   * @param \Drupal\Core\Session\AccountProxyInterface $account_proxy
   * The current user.
   */
  public function __construct (RouteMatchInterface $route_match, AccountProxyInterface $account_proxy) {
    $this->routeMatch = $route_match;
    $this->accountProxy = $account_proxy;
  }

  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => ['doAnonymousRedirect', 28],
    ];
  }

  /**
   * Redirects all anonymous users to the login page.
   *
   * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
   *  The event.
   */
  public function doAnonymousRedirect(GetResponseEvent $event) {
    // make sue we are not on the user login route.
    $currentRoute = $this->routeMatch->getRouteName();
    // dpm($currentRoute); exit;
    if ( $currentRoute == 'user.login'
      || $currentRoute == 'user.register'
      || $currentRoute == 'user.pass.http'
      || stristr($currentRoute, 'gung')
    ) {
      return;
    }
    // check if the current user is logged in.
    if ($this->accountProxy->isAnonymous()) {
      // If they are not logged in, create a redirect response,
      $url = Url::fromRoute('user.login')->toString();
      $redirect = new RedirectResponse($url);

      // set the redirect response on the event, cancelling default response.
      $event->setResponse($redirect);

    }
  }
}
