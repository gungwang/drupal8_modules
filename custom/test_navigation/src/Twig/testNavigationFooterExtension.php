<?php

namespace Drupal\test_navigation\Twig;

/**
 * Class testNavigationExtension extends \Twig_Extension.
 */
class testNavigationFooterExtension extends \Twig_Extension {

  /**
   * Function getName()
   */
  public function getName() {
    return 'renderMenu';
  }

  /**
   * Function getFunctions.
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('renderMenu', array($this, 'renderMenu'), array(
        'is_safe' => array('html'),
      )),
    );
  }

  /**
   * Function renderMenu.
   */
  public function renderMenu($menu_name, $type, $format) {
    $menu_tree = \Drupal::menuTree();

    // Build the typical default set of menu tree parameters.

    if($type == 'footer') {
      if ($format == 'footer-horizontal') {
        $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name)->setTopLevelOnly()->onlyEnabledLinks();
      } else {
        $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name)->setMaxDepth(2);
      }
    } else {
      $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name)->onlyEnabledLinks();
    }

    // Load the tree based on this set of parameters.
    $tree = $menu_tree->load($menu_name, $parameters);

    // Transform the tree using the manipulators you want.
    $manipulators = array(
          // Only show links that are accessible for the current user.
          array('callable' => 'menu.default_tree_manipulators:checkAccess'),
          // Use the default sorting of menu links.
          array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
    );
    $tree = $menu_tree->transform($tree, $manipulators);

    // Finally, build a renderable array from the transformed tree.
    $menu = $menu_tree->build($tree);

    return array('#markup' => \Drupal::service('renderer')->render($menu, FALSE));
  }

}
