<?php

namespace Drupal\test_navigation\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\system\Entity\Menu;
use Drupal\file\Entity\File;
use Drupal\image\Entity\ImageStyle;

/**
 * Class testNavigationForm.
 */
class testNavigationForm extends ConfigFormBase {

  /**
   * Fucntion getFormid.
   */
  public function getFormId() {
    return 'test_navigation_form';
  }

  /**
   * Function buildForm.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor.
    $form = parent::buildForm($form, $form_state);
    // Default settings.
    $config = $this->config('test_navigation.settings');

    $form['test_navigation_header_fieldset'] = $this->testNavigationHeaderFieldsetField();
    $form['test_navigation_header_fieldset']['test_navigation_header_auto'] = $this->testNavigationHeaderAutoField();
    $form['test_navigation_header_fieldset']['test_navigation_header_name'] = $this->testNavigationAgencyNameField();
    $form['test_navigation_header_fieldset']['test_navigation_header_logo_fieldset'] = $this->testNavigationAgencyLogoFieldsetField();
    $form['test_navigation_header_fieldset']['test_navigation_header_logo_fieldset']['test_navigation_header_logo_container'] = $this->testNavigationAgencyLogoContainer();
    $form['test_navigation_header_fieldset']['test_navigation_header_logo_fieldset']['test_navigation_header_logo_removal_container'] = $this->testNavigationAgencyLogoRemovalContainer();
    if ($config->get('test_navigation.agencylogo') != '') {
      $form['test_navigation_header_fieldset']['test_navigation_header_logo_fieldset']['test_navigation_header_logo_removal_container']['test_navigation_header_logo_render'] = $this->testNavigationAgencyLogoRender();
      $form['test_navigation_header_fieldset']['test_navigation_header_logo_fieldset']['test_navigation_header_logo_removal_container']['test_navigation_header_logo_removal'] = $this->testNavigationAgencyLogoRemoval();
    }
    $form['test_navigation_header_fieldset']['test_navigation_header_logo_fieldset']['test_navigation_header_logo_container']['test_navigation_header_logo'] = $this->testNavigationAgencyLogo();
    $form['test_navigation_header_fieldset']['test_navigation_header_format'] = $this->testNavigationheaderFormatField();
    $form['test_navigation_header_fieldset']['test_navigation_header_menu'] = $this->testNavigationHeaderMenuField();

    $form['test_navigation_footer_fieldset'] = $this->testNavigationFooterFieldsetField();
    $form['test_navigation_footer_fieldset']['test_navigation_footer_auto'] = $this->testNavigationFooterAutoField();
    $form['test_navigation_footer_fieldset']['test_navigation_footer_format'] = $this->testNavigationFooterFormatField();
    $form['test_navigation_footer_fieldset']['test_navigation_footer_menu'] = $this->testNavigationFooterMenuField();

    $form['test_navigation_social_media_fieldset'] = $this->testNavigationsocialMediaFieldsetField();
    $form['test_navigation_social_media_fieldset']['test_navigation_social_description'] = $this->testNavigationSocialMediaDescriptionField();
    $form['test_navigation_social_media_fieldset']['test_navigation_social_media'] = $this->testNavigationSocialMediaField();

    return $form;
  }

  /**
   * Function validate Form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * Function submitForm.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = \Drupal::configFactory()->getEditable('test_navigation.settings');
    $config->set('test_navigation.agencyname',   $form_state->getValue('test_navigation_header_name'));
    $config->set('test_navigation.headerformat', $form_state->getValue('test_navigation_header_format'));
    $config->set('test_navigation.headermenu',   $form_state->getValue('test_navigation_header_menu'));
    $config->set('test_navigation.headerauto',   $form_state->getValue('test_navigation_header_auto'));

    $config->set('test_navigation.footerauto',              $form_state->getValue('test_navigation_footer_auto'));
    $config->set('test_navigation.footerformat',            $form_state->getValue('test_navigation_footer_format'));
    $config->set('test_navigation.footermenu',              $form_state->getValue('test_navigation_footer_menu'));
    $config->set('test_navigation.socialmedia.blogger',     $form_state->getValue('socialmedia_blogger'));
    $config->set('test_navigation.socialmedia.delicious',   $form_state->getValue('socialmedia_delicious'));
    $config->set('test_navigation.socialmedia.facebook',    $form_state->getValue('socialmedia_facebook'));
    $config->set('test_navigation.socialmedia.feed',        $form_state->getValue('socialmedia_feed'));
    $config->set('test_navigation.socialmedia.flickr',      $form_state->getValue('socialmedia_flickr'));
    $config->set('test_navigation.socialmedia.foursquare',  $form_state->getValue('socialmedia_foursquare'));
    $config->set('test_navigation.socialmedia.github',      $form_state->getValue('socialmedia_github'));
    $config->set('test_navigation.socialmedia.google-plus', $form_state->getValue('socialmedia_google-plus'));
    $config->set('test_navigation.socialmedia.instagram',   $form_state->getValue('socialmedia_instagram'));
    $config->set('test_navigation.socialmedia.linkedin',    $form_state->getValue('socialmedia_linkedin'));
    $config->set('test_navigation.socialmedia.mail',        $form_state->getValue('socialmedia_mail'));
    $config->set('test_navigation.socialmedia.pinterest',   $form_state->getValue('socialmedia_pinterest'));
    $config->set('test_navigation.socialmedia.reddit',      $form_state->getValue('socialmedia_reddit'));
    $config->set('test_navigation.socialmedia.share',       $form_state->getValue('socialmedia_share'));
    $config->set('test_navigation.socialmedia.tumblr',      $form_state->getValue('socialmedia_tumblr'));
    $config->set('test_navigation.socialmedia.twitter',     $form_state->getValue('socialmedia_twitter'));
    $config->set('test_navigation.socialmedia.vimeo',       $form_state->getValue('socialmedia_vimeo'));
    $config->set('test_navigation.socialmedia.yelp',        $form_state->getValue('socialmedia_yelp'));
    $config->set('test_navigation.socialmedia.youtube',     $form_state->getValue('socialmedia_youtube'));

    // check if image is uploaded
    $fids = $form_state->getValue(['test_navigation_header_fieldset' => 'test_navigation_header_logo']);
    if (!empty($fids)) {
      $fid = $fids[0];
      $file = File::load($fid);
      // verify file is set as permanent and saved to database
      $file->setPermanent();
      $file->save();
      // register the file with the test_unav module so it is not deleted via cron
      $file_usage = \Drupal::service('file.usage');
      $file_usage->add($file, 'test_navigation', 'test_navigation', \Drupal::currentUser()->id());

      $file_uri = $file->getFileUri();
      $style = ImageStyle::load('global_navigation_logo');
      $destination = $style->buildUri($file_uri);
      // create image style applied image and if successful add destination to config
      if ($style->createDerivative($file_uri, $destination)) {
        // pass url created by file_create_url to parse_url to pull path to save
        $parsed_url = parse_url(file_create_url($destination));
        $config->set('test_navigation.agencylogo', $parsed_url['path']);
        // set fid into config for later usage
        $config->set('test_navigation.agencylogofid', $fid);
      }
    }

    $config->save();

    // CLEAR CACHE
    drupal_flush_all_caches();

    return parent::submitForm($form, $form_state);
  }

  /**
   * Function getEditableConfigNames.
   */
  protected function getEditableConfigNames() {

    return [
      'test_navigation.settings',
    ];
  }

  /**
   * Test Global Navigation header fieldset field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationHeaderFieldsetField() {
    return array(
      '#type' => 'fieldset',
      '#title' => t('Global header navigation options'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    );
  }

  /**
   * Test Global Navigation footer fieldset field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationFooterFieldsetField() {
    return array(
      '#type' => 'fieldset',
      '#title' => t('Global footer navigation options'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    );
  }

  /**
   * Test Global Navigation social media fieldset field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationSocialMediaFieldsetField() {
    return array(
      '#type' => 'fieldset',
      '#title' => t('Social media options'),
      '#collapsible' => FALSE,
      '#collapsed' => FALSE,
    );
  }

  /**
   * Test Global Navigation social media label field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationSocialMediaDescriptionField() {
    return array(
        '#type' => 'label',
        '#title' => t('When entering a URL for the social fields, please use a fully qualified domain name with the protocol prefix, for example: http://thesocialnetwork.com/suffix.<br/> If left blank, the social media icon and link will not display.<br />NOTE: The Global Footer MUST be enabled above for social media links to display.'),
    );
  }


  /**
   * Test Global Navigation agency name field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationAgencyNameField() {
    $config = $this->config('test_navigation.settings');
    return array(
      '#type' => 'textfield',
      '#title' => t('Agency name'),
      '#default_value' => $config->get('test_navigation.agencyname'),
      '#maxlength' => 128,
      '#size' => '60',
      '#description' => t('Enter the agency name for the global navigation.  You can use &#60;br&#47;&#62; to cause the name to split.'),
    );
  }

  /**
   * Test Global Navigation agency logo details field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationAgencyLogoFieldsetField() {
    return array(
      '#type' => 'details',
      '#title' => t('Agency Logo Options'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    );
  }

  /**
   * Test Global Navigation logo containter
   *
   * @return array
   *   Form API element for field
   */
  public function testNavigationAgencyLogoContainer() {
    return array(
      '#type' => 'container',
      '#attributes' => ['id' => 'agency_logo_container'],
    );
  }

  /**
   * Test Global Navigation logo removal container
   *
   * @return array
   *   Form API element for field
   */
  public function testNavigationAgencyLogoRemovalContainer() {
    return array(
      '#type' => 'container',
      '#attributes' => ['id' => 'agency_logo_removal_container'],
    );
  }

  /**
   * Test Global Navigation agency logo
   *
   * @return array
   *   Form API element for field
   */
  public function testNavigationAgencyLogo() {
    return array(
      // uncomment to incorporate media entity browser
      /*'#type' => 'entity_browser',
      '#entity_browser' => 'media_browser',
      '#title' => $this->t('Agency Logo'),
      '#description' => t('Select the Agency Logo.'),*/
      '#type' => 'managed_file',
      '#title' => t('Upload Logo'),
      '#multiple' => FALSE,
      '#description' => t('The uploaded image will be displayed on the Global Navigation. (all images uploaded will be scaled down to a height of 45px).'),
      '#upload_location' => 'public://global_navigation_logo/',
    );
  }

  /**
   * Test Global Navigation agency logo render field
   *
   * @return array
   *   Form API element for field
   */
  public function testNavigationAgencyLogoRender() {
    $config = $this->config('test_navigation.settings');
    return array(
      '#type' => 'markup',
      //'#prefix' => '<div id="agency_logo_container">',
      '#markup' => '<p><strong>Uploaded Logo</strong><br /><img src="'. $config->get('test_navigation.agencylogo') .'" /></p>',
    );
  }

  /** Test Global Navigation agency logo removal button
   *
   * @return array
   *  Form API element for field
   */
  public function testNavigationAgencyLogoRemoval() {
    return array(
      '#type' => 'button',
      '#value' => t('Remove Logo'),
      //'#suffix' => '</div>',
      '#ajax' => array(
        'callback' => [$this, 'testNavigationAgencyLogoRemoveFile'],
        'wrapper' => 'agency_logo_removal_container',
      ),
    );
  }

  /** Test Global Navigation agency logo removal callback
   *
   * @return array
   *   Ajax Form Callback
   */
  public function testNavigationAgencyLogoRemoveFile(array $form, FormStateInterface $form_state) {
    $config = $this->config('test_navigation.settings');
    $configEdit = \Drupal::configFactory()->getEditable('test_navigation.settings');
    $fid = $config->get('test_navigation.agencylogofid');

    file_delete($fid);
    $configEdit->set('test_navigation.agencylogo', '');
    $configEdit->set('test_navigation.agencylogofid', '');
    $configEdit->save();

    // CLEAR CACHE
    drupal_flush_all_caches();

    return array('#type' => 'markup', '#markup' => '<p><strong>Logo Removed.</strong></p>',);
  }

  /**
   * Test Global Navigation agency grouping color field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationHeaderFormatField() {
    $config = $this->config('test_navigation.settings');
    $format_options = array(
      'horizontal stacked' => 'Horizontal - stacked',
      'horizontal unstacked' => 'Horizontal - unstacked',
    );
    return array(
      '#type' => 'select',
      '#title' => t('Header format options'),
      '#options' => $format_options,
      '#default_value' => $config->get('test_navigation.headerformat'),
      '#multiple' => FALSE,
      '#description' => t('Select which header format to use.'),
    );
  }

  /**
   * Test Global Navigation header menu selection field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationHeaderMenuField() {
    $config = $this->config('test_navigation.settings');
    $menu_list = $this->testNavigationGetMenus();
    $default_menu = $config->get('test_navigation.headermenu');

    return array(
      '#type' => 'select',
      '#title' => t('Header menu'),
      '#options' => $menu_list,
      '#default_value' => $default_menu,
      '#multiple' => FALSE,
      '#description' => t('Select which menu to use in the global header.  If the menu has more than 7 first level item, all are output which might cause formatting issues.'),
    );
  }

  /**
   * Test Global Navigation header automatic insertion field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationHeaderAutoField() {
    $config = $this->config('test_navigation.settings');
    return array(
      '#type' => 'checkbox',
      '#title' => t('Enable the Global Navigation Header'),
      '#default_value' => $config->get('test_navigation.headerauto'),
      '#multiple' => FALSE,
      '#description' => t('Check this box to enable the Global Navigation Header into this website.'),
    );
  }

  /**
   * Test Global Navigation footer automatic insertion field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationFooterAutoField() {
    $config = $this->config('test_navigation.settings');
    return array(
      '#type' => 'checkbox',
      '#title' => t('Enable the Global Navigation Footer'),
      '#default_value' => $config->get('test_navigation.footerauto'),
      '#multiple' => FALSE,
        '#description' => t('Check this box to enable the Global Navigation Footer into this website.'),
    );
  }

  /**
   * Test Global Navigation agency footer style.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationFooterFormatField() {
    $config = $this->config('test_navigation.settings');
    $format_footer_options = array(
        'footer-vertical' => 'Columned Menu - Vertical List (Default)',
        'footer-horizontal' => 'Inline list of links - Horizontal List',
    );
    return array(
        '#type' => 'select',
        '#title' => t('Footer format options'),
        '#options' => $format_footer_options,
        '#default_value' => $config->get('test_navigation.footerformat'),
        '#multiple' => FALSE,

        '#description' => t('Select which footer format to use. The Columned Menu option will align links vertically 
        with the top level menu item as the column name and the menu\'s sublinks as general links below. The Inline 
        list of links takes the top level menu links and lists them horizontally. No sub menu links will display for 
        the Inline list of links option.'),
    );
  }

  /**
   * Test Global Navigation footer menu selection field.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationFooterMenuField() {
    $config = $this->config('test_navigation.settings');
    $menu_list = $this->testNavigationGetMenus();
    $default_menu = $config->get('test_navigation.footermenu');

    return array(
      '#type' => 'select',
      '#title' => t('Footer menu'),
      '#options' => $menu_list,
      '#default_value' => $default_menu,
      '#multiple' => FALSE,
      '#description' => t('Select which menu to use in the global footer.  The first level menu items will be the column headers.  If the menu has more than 5 first level item, all are output which might cause formatting issues.'),
    );
  }

  /**
   * Test Global Navigation social media fields.
   *
   * @return array
   *   Form API element for field.
   */
  public function testNavigationSocialMediaField() {
    $config = $this->config('test_navigation.settings');
    $social_media_list = $this->testNavigationSetupSocialNames();
    $social_media_names = array();

    foreach ($social_media_list as $key => $social_media_name) {
      $social_media_index_name = 'test_navigation.socialmedia.' . htmlspecialchars($key);
      $inputname = 'socialmedia_'.$key;
      $social_media_names[$inputname] = array(
        '#type' => 'textfield',
        '#title' => t('@social URL', array('@social' => $social_media_name)),
        '#default_value' => $config->get($social_media_index_name),
        '#maxlength' => 128,
        '#size' => 60,
        '#description' => t('Enter the URL for @social.', array('@social' => $social_media_name)),
        '#required' => FALSE,
        '#tree' => TRUE,
      );
    }

    $social_media_names['socialmedia_mail']['#description'] .= ' Sample email format is "mailto:someone@example.com?Subject=Hello%20world".';

    return $social_media_names;
  }

  /**
   * Helper function to set up social media names.
   *
   * @return array $social_media_names
   *   - array indexed by internal name of social media names.
   */
  public function testNavigationSetupSocialNames() {
    return array(
      'blogger' => 'Blogger',
      'delicious' => 'Delicious',
      'facebook' => 'Facebook',
      'rss' => 'RSS Feed',
      'flickr' => 'Flickr',
      'foursquare' => 'Foursquare',
      'github' => 'GitHub',
      'google-plus' => 'Google+',
      'instagram' => 'Instagram',
      'linkedin' => 'Linkedin',
      'mail' => 'Mail',
      'pinterest' => 'Pinterest',
      'reddit' => 'Reddit',
      'share' => 'Share',
      'tumblr' => 'Tumblr',
      'twitter' => 'Twitter',
      'vimeo' => 'Vimeo',
      'yelp' => 'Yelp',
      'youtube' => 'YouTube',
    );
  }

  /**
   * Function _test_navigation_get_menus.
   */
  public function testNavigationGetMenus($all = TRUE) {
    if ($custom_menus = Menu::loadMultiple()) {
      if (!$all) {
        $custom_menus = array_diff_key($custom_menus, menu_list_system_menus());
      }
      foreach ($custom_menus as $menu_name => $menu) {
        $custom_menus[$menu_name] = $menu->label();
      }
      asort($custom_menus);
    }
    return $custom_menus;
  }

}
