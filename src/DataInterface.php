<?php
/**
 * @file
 * Contains DataInterface.php.
 */

namespace Acquia\Cloud\Api;


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