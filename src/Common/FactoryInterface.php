<?php
/**
 * @file
 * Contains FactoryInterface.php.
 */
namespace Acquia\Platform\Cloud\Common;

interface FactoryInterface {

  /**
   * @param $type
   * @return string
   */
  public function getObjectTypeClass($type);

  /**
   * @param $type
   * @param array $data
   * @return object
   */
  public function createObjectType($type, array $data = []);

}

