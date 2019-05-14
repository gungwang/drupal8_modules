<?php

namespace Drupal\test_navigation\Twig;

/**
 * Class testNavigationExtension extends \Twig_Extension.
 */
class TestSocialExtension extends \Twig_Extension {

    /**
     * Function getName()
     */
    public function getName() {
        return 'socialLinks.twig_extension';
    }

    /**
     * Function getFunctions.
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('getSocialLinks', array($this, 'getSocialLinks'), array(
                'is_safe' => array('html'),
            )),
        );
    }

    /**
     * Function getSocialLinks gets links from test global nav social links and outputs as linked lists.
     */
    public function getSocialLinks() {
        $config = \Drupal::configFactory()->getEditable('test_navigation.settings');
        $social_build = $config->get('test_navigation.socialmedia');

        $final_build = NULL;
        foreach($social_build as $k => $v) {
            if($v != '' && $v != NULL) {
                $final_build .= "<li><a class=\"imgico_".$k."\" href=\"" . $v . "\">" . strtoupper($k) . "</a></li>";
            }
        }
        return $final_build;
    }

}
