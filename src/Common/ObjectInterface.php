<?php
/**
 * @file
 * Contains DataInterface.php.
 */

namespace Acquia\Platform\Cloud\Common;


interface ObjectInterface {

  /**
   * @return array
   */
  public function getData();

  /**
   * @return array
   */
  public static function getKeys();

} 