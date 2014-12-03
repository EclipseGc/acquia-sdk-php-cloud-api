<?php
/**
 * @file
 * Contains Envs.php.
 */

namespace Acquia\Cloud\Api\SDK\Envs;


use GuzzleHttp\Client;

class Envs implements EnvsInterface {

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

  protected $defaults = array(
    'name' => NULL,
    'vcs_path' => NULL,
    'ssh_host' => NULL,
    'db_clusters' => NULL,
    'default_domain' => NULL,
    'livedev' => NULL,
  );

  public function __construct($name, $site_id, Client $client, array $data = []) {
    $this->name = $name;
    $this->siteId = $site_id;
    $this->client = $client;
    // If we're missing any of the expected data, get the data manually.
    if (array_diff_key($this->defaults, $data)) {
      $data = $this->client->get(['sites/{site}/envs/{env}.json', ['site' => $site_id, 'env' => $name]])->json();
    }

    $this->name = $data['name'];
    $this->vcsPath = $data['vcs_path'];
    $this->sshHost = $data['ssh_host'];
    $this->dbClusters = $data['db_clusters'];
    $this->defaultDomain = $data['default_domain'];
    $this->livedev = $data['livedev'];
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
   * @return array
   */
  public function getDefaults() {
    return $this->defaults;
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

}
