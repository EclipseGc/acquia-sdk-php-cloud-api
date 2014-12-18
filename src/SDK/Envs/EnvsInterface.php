<?php
/**
 * @file
 * Contains EnvsInterface.php.
 */

namespace Acquia\Cloud\Api\SDK\Envs;


use Acquia\Cloud\Api\DataInterface;

interface EnvsInterface extends DataInterface {

  /**
   * @return array
   */
  public function getDbClusters();

  /**
   * @return string
   */
  public function getDefaultDomain();

  /**
   * @return string
   */
  public function getLivedev();

  /**
   * @return string
   */
  public function getName();

  /**
   * @return string
   */
  public function getSiteId();

  /**
   * @return string
   */
  public function getSshHost();

  /**
   * @return string
   */
  public function getVcsPath();

  /**
   * @return array()
   */
  public function getLogStream();

  /**
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function enableLiveDev();

  /**
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function disableLiveDev();

  /**
   * @return \Acquia\Cloud\Api\SDK\Server\ServerInterface[]
   */
  public function getServers();

  /**
   * @param $name
   *   The name of the server you wish to retrieve.
   *
   * @return \Acquia\Cloud\Api\SDK\Server\ServerInterface
   */
  public function getServer($name);

}
