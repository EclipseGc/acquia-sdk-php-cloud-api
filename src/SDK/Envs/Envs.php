<?php
/**
 * @file
 * Contains Envs.php.
 */

namespace Acquia\Cloud\Api\SDK\Envs;


use Acquia\Cloud\Api\SDK\Task\Task;
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

  public function getLogStream() {
    print var_export($this->client->get(['sites/{site}/envs/{env}/logstream.json', ['site' => $this->getSiteId(), 'env' => $this->getName()]])->json(), TRUE);
  }

  public function enableLiveDev() {
    // @todo the livedev param appears to always be disabled. Need to figure
    // out why so we can appropriately check before just firing a new task.
    //if ($this->livedev == 'disabled') {
      $data = $this->client->post(['sites/{site}/envs/{env}/livedev/enable.json', ['site' => $this->getSiteId(), 'env' => $this->getName()]])->json();
      return new Task($data['id'], $this->getSiteId(), $this->client, $data);
    //}
  }

  public function disableLiveDev() {
    // @todo the livedev param appears to always be disabled. Need to figure
    // out why so we can appropriately check before just firing a new task.
    //if ($this->livedev == 'enabled') {
    $data = $this->client->post(['sites/{site}/envs/{env}/livedev/disable.json', ['site' => $this->getSiteId(), 'env' => $this->getName()]])->json();
    return new Task($data['id'], $this->getSiteId(), $this->client, $data);
    //}
  }

  public function getServers() {
    return $this->client->get(['sites/{site}/envs/{env}/servers.json', ['site' => $this->getSiteId(), 'env' => $this->getName()]])->json();
  }

}
