<?php
/**
 * @file
 * Contains SiteInterface.php.
 */

namespace Acquia\Cloud\Api\SDK;


interface SiteInterface {

  /**
   * @return string
   */
  public function getSiteId();

  public function getTasks();

} 