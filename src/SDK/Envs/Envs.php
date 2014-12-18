<?php
/**
 * @file
 * Contains Envs.php.
 */

namespace Acquia\Cloud\Api\SDK\Envs;


use Acquia\Cloud\Api\ObjectFactoryInterface;
use Acquia\Cloud\Api\SDK\Server\Server;
use Acquia\Cloud\Api\SDK\Task\Task;

class Envs implements EnvsInterface {

  /**
   * @var \Acquia\Cloud\Api\ObjectFactoryInterface
   */
  protected $factory;

  /**
   * The site identifier.
   *
   * @var string
   */
  protected $siteId;

  /**
   * The environment name.
   *
   * @var string
   */
  protected  $name;

  /**
   * The active vcs branch or tag.
   *
   * @var string
   */
  protected $vcsPath;

  /**
   * The ssh host url.
   *
   * @var string
   */
  protected $sshHost;

  /**
   * The database cluster ids.
   *
   * @var array
   */
  protected $dbClusters;

  /**
   * The url to reach this environment.
   *
   * @var string
   */
  protected $defaultDomain;

  /**
   * Indicates whether livedev is enable in this environment.
   *
   * @var string
   */
  protected $livedev;

  public function __construct(ObjectFactoryInterface $factory, $site_id, $name, $vcs_path, $ssh_host, $db_clusters, $default_domain, $livedev) {
    $this->factory = $factory;
    $this->siteId = $site_id;
    $this->name = $name;
    $this->vcsPath = $vcs_path;
    $this->sshHost = $ssh_host;
    $this->dbClusters = $db_clusters;
    $this->defaultDomain = $default_domain;
    $this->livedev = $livedev;
  }

  /**
   * @return array
   */
  public function getDbClusters() {
    return $this->dbClusters;
  }

  /**
   * @return string
   */
  public function getDefaultDomain() {
    return $this->defaultDomain;
  }

  /**
   * @return string
   */
  public function getLivedev() {
    return $this->livedev;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return string
   */
  public function getSiteId() {
    return $this->siteId;
  }

  /**
   * @return string
   */
  public function getSshHost() {
    return $this->sshHost;
  }

  /**
   * @return string
   */
  public function getVcsPath() {
    return $this->vcsPath;
  }

  public function getLogStream() {
    return $this->factory->getLogStream($this->getSiteId(), $this->getName());
  }

  public function enableLiveDev() {
    return $this->factory->enableLiveDev($this->getSiteId(), $this->getName());
  }

  public function disableLiveDev() {
    return $this->factory->disableLiveDev($this->getSiteId(), $this->getName());
  }

  public function getServers() {
    return $this->factory->getServers($this->getSiteId(), $this->getName());
  }

  public function getServer($name) {
    return $this->factory->getServer($this->getSiteId(), $this->getName(), $name);
  }

  public function getData() {
    return [
      'name' => $this->getName(),
      'vcs_path' => $this->getVcsPath(),
      'ssh_host' => $this->getSshHost(),
      'db_clusters' => $this->getDbClusters(),
      'default_domain' => $this->getDefaultDomain(),
      'livedev' => $this->getLivedev(),
    ];
  }

}
