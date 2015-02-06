<?php
/**
 * @file
 * Contains DataInterface.php.
 */

namespace Acquia\Platform\Cloud\Api;


interface DataInterface {

  /**
   * @return array
   */
  public function getData();

  /**
   * @return array
   */
  public static function getKeys();

} 