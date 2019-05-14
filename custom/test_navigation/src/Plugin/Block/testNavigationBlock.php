<?php

namespace Drupal\test_navigation\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Global Navigation' Block.
 *
 * @Block(
 *   id = "test_navigation_block",
 *   admin_label = @Translation("Test Global Navigation Block"),
 * )
 */
class testNavigationBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {

        return array(
            '#theme' => 'test_navigation_header_block'
        );
    }
}
