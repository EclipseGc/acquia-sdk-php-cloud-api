<?php
/**
 * @file
 * Contains ServerInterface.php.
 */
namespace Acquia\Platform\Cloud\Hosting\Server;

use Acquia\Platform\Cloud\Common\ObjectInterface;

interface ServerInterface extends ObjectInterface {
  /**
   * @return string
   */
  public function getFqdn();

  /**
   * @return string
   */
  public function getStatus();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getAmiType();

  /**
   * @return string
   */
  public function getSiteId();

  /**
   * @return string
   */
  public function getEc2Region();

  /**
   * @return string
   */
  public function getEc2AvailabilityZone();

  /**
   * @return string
   */
  public function getEnv();

  /**
   * @return array
   */
  public function getServices();

  /**
   * @return array
   */
  public function getPhpProcs();
}