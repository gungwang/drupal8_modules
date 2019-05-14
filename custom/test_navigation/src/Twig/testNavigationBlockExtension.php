<?php


namespace Drupal\test_navigation\Twig;
use Drupal\Core\Link;

/**
 * Class testNavigationBlockExtension extends \Twig_Extension.
 */
class testNavigationBlockExtension extends \Twig_Extension {

    /**
     * Function getName()
     */
    public function getName() {
        return 'globalNavBlock.twig_extension';
    }

    /**
     * Function getFunctions.
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('globalNavBlock', array($this, 'globalNavBlock'), array(
                'is_safe' => array('html'),
            )),
        );
    }

    /**
     * Function renderBlockMenu.
     */
    public function globalNavBlock($menu_name) {
        $menu_tree = \Drupal::menuTree();
        $parameters = $menu_tree->getCurrentRouteMenuTreeParameters($menu_name)->onlyEnabledLinks()->setMaxDepth(2);

        // Load the tree based on this set of parameters.
        $tree = $menu_tree->load($menu_name, $parameters);

        // Transform the tree using the manipulators you want.
        $manipulators = array(
            array('callable' => 'menu.default_tree_manipulators:checkAccess'),
            array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
        );

        // GET MENU TREE
        $tree = $menu_tree->transform($tree, $manipulators);

        // ASSIGN HTML CONST
        $ultop = '<ul class="gnav-ul">';
        $litop = '<li class="gnav-mitems gnav-topli" aria-expanded="false">';
        $ulsub = '<ul class="gnav-items-ul" aria-hidden="true">';
        $lisub = '<li>';
        $litopsolo = '<li class="gnav-mitems gnav-topli solotop" aria-expanded="false">';
        $litopalt = '<li class="gnav-toplink">';
        $ulc = '</ul>';
        $lic = '</li>';

        // CREATE TOP LEVEL UL
        $newmenu = $ultop;

        // CREATE ELEMENTS
        foreach ($tree as $item) {

            // CHECK TYPE. IF STRING, PASS
            if(gettype($item->link->getTitle()) == 'string') {

                // TOP LEVEL LINK PARMS
                $title = $item->link->getTitle();
                $url = $item->link->getUrlObject();
                $link = Link::fromTextAndUrl(t($title), $url)->toString();

                // PREASSIGN COUNT TO 1
                $subcount = 1;
                $lastChild = sizeof($item->subtree);
                $firstSubChild = TRUE;

                if ($lastChild > 0) {

                    // ===================================================================================
                    // ADD THE FIRST LEVEL LINK
                    $newmenu .= $litop . $link;

                    foreach ($item->subtree as $subitem) {

                        // CHECK TYPE. IF STRING, PASS
                        if (gettype($subitem->link->getTitle()) == 'string') {

                            // SUBITEM META
                            $subtitle = $subitem->link->getTitle();
                            $suburl = $subitem->link->getUrlObject();
                            $sublink = Link::fromTextAndUrl(t($subtitle), $suburl)->toString();

                            // RUN THIS FIRST AND THATS ALL
                            if ($firstSubChild == TRUE) {

                                // ===================================================================================
                                $newmenu .= $ulsub;

                                // BUILD LIST ITEM AND UL SUB ITEM
                                if (!empty($url->toString())) {

                                    // ===================================================================================
                                    $newmenu .= $litopalt . $link . $lic;
                                }

                                $firstSubChild = FALSE;

                            }

                            // ===================================================================================
                            // CONSTRUCT SUBURL
                            $newmenu .= $lisub . $sublink . $lic;


                        } // END IF SUBITEM IS STRING


                        if ($lastChild == $subcount) {

                            // CLOSE THE UL AND TOP LEVEL LI ELEMENT
                            $newmenu .= $ulc;

                        }

                        // INCREMENT SUBCOUNT
                        $subcount++;

                    } // END INNER FOR


                    // ===================================================================================
                    // CLOSE TOP LEVEL LI ELEMENT
                    $newmenu .= $lic;


                } else {

                    // CREATE A STAND ALONE LINK
                    $newmenu .= $litopsolo . $link . $lic;


                } // END IF/ELSE

            } // END CHECK TYPE

        } // END FOR OUTTER

        // CLOSE MAIN CONTAINER
        $newmenu .= $ulc;



        return array('#markup' => $newmenu);
    }


}
