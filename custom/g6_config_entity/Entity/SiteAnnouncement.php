<?php
namespace Drupal\g6_config_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
/**
 * @ConfigEntityType(
 *   id = "announcement",
 *   label = @Translation("Site Announcement"),
 *   handlers = {
 *     "list_builder" = "Drupal\g6_config_entity\SiteAnnouncementListBuilder",
 *     "form" = {
 *       "default" = "Drupal\g6_config_entity\SiteAnnouncementForm",
 *       "add" = "Drupal\g6_config_entity\SiteAnnouncementForm",
 *       "edit" = "Drupal\g6_config_entity\SiteAnnouncementForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "announcement",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "delete-form" = "/admin/config/system/site-announcements/manage/{announcement}/delete",
 *     "edit-form" = "/admin/config/system/site-announcements/manage/{announcement}",
 *     "colletion" = "/admin/config/system/site-announcements",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "message",
 *   }
 * )
 */



class SiteAnnouncement extends ConfigEntityBase implements SiteAnnouncementInterface {

  protected $message;

  public function getMessage() {
    return $his->message;
  }
}
