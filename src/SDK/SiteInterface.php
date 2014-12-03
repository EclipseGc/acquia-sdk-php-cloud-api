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

  /**
   * @return string
   */
  public function getName();

  /**
   * @return int
   */
  public function getProductionMode();

  /**
   * @return string
   */
  public function getTitle();

  /**
   * @return string
   */
  public function getUnixUsername();

  /**
   * @return string
   */
  public function getVcsType();

  /**
   * @return string
   */
  public function getVcsUrl();

  /**
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface[]
   */
  public function getTasks();

} 