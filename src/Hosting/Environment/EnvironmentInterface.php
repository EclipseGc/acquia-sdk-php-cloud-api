<?php
/**
 * @file
 * Contains EnvironmentInterface.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Environment;

use Acquia\Platform\Cloud\Common\ObjectInterface;

interface EnvironmentInterface extends ObjectInterface {

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
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface
   */
  public function enableLiveDev();

  /**
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface
   */
  public function disableLiveDev();

  /**
   * @return \Acquia\Platform\Cloud\Hosting\Server\ServerInterface[]
   */
  public function getServers();

  /**
   * @param $name
   *   The name of the server you wish to retrieve.
   *
   * @return \Acquia\Platform\Cloud\Hosting\Server\ServerInterface
   */
  public function getServer($name);

  /**
   * @return array
   */
  public function getDomains();

  /**
   * @param $domain
   * @return \Acquia\Platform\Cloud\Hosting\Domain\DomainInterface
   */
  public function getDomain($domain);

  /**
   * @param $domain
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface
   */
  public function createDomain($domain);

  /**
   * @param $source
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface
   */
  public function installFromSource($source);

  /**
   * @param $make_file
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface
   */
  public function installFromManifest($make_file);

}
