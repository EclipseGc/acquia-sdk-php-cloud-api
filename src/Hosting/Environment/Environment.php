<?php
/**
 * @file
 * Contains Environment.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Environment;

use Acquia\Platform\Cloud\Hosting\DataSourceInterface;

class Environment implements EnvironmentInterface {

  /**
   * @var \Acquia\Platform\Cloud\Hosting\DataSourceInterface
   */
  protected $dataSource;

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

  public function __construct(DataSourceInterface $dataSource, $site_id, $name, $vcs_path, $ssh_host, $db_clusters, $default_domain, $livedev) {
    $this->dataSource = $dataSource;
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
    return $this->dataSource->getLogStream($this->getSiteId(), $this->getName());
  }

  public function enableLiveDev() {
    return $this->dataSource->enableLiveDev($this->getSiteId(), $this->getName());
  }

  public function disableLiveDev() {
    return $this->dataSource->disableLiveDev($this->getSiteId(), $this->getName());
  }

  public function getServers() {
    return $this->dataSource->getServers($this->getSiteId(), $this->getName());
  }

  public function getServer($name) {
    return $this->dataSource->getServer($this->getSiteId(), $this->getName(), $name);
  }

  public function getDomains() {
    return $this->dataSource->getDomains($this->getSiteId(), $this->getName());
  }

  public function getDomain($domain) {
    return $this->dataSource->getDomain($this->getSiteId(), $this->getName(), $domain);
  }

  public function createDomain($domain) {
    return $this->dataSource->createDomain($this->getSiteId(), $this->getName(), $domain);
  }

  public function installFromSource($source_file) {
    return $this->dataSource->install($this->getSiteId(), $this->getName(), 'distro_url', $source_file);
  }

  public function installFromManifest($make_file) {
    return $this->dataSource->install($this->getSiteId(), $this->getName(), 'make_url', $make_file);
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

  /**
   * {@inheritdoc}
   */
  public static function getKeys() {
    return [
      'name',
      'vcs_path',
      'ssh_host',
      'db_clusters',
      'default_domain',
      'livedev',
    ];
  }

}
