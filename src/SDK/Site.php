<?php
/**
 * @file
 * Contains Site.php.
 */

namespace Acquia\Cloud\Api\SDK;

use Acquia\Cloud\Api\SDK\Envs\Envs;
use Acquia\Cloud\Api\SDK\Task\Task;
use GuzzleHttp\Client;

class Site implements SiteInterface {

  /**
   * The site identifier.
   *
   * @var string
   */
  protected $siteId;

  /**
   * A Guzzle Client through which to proxy further requests.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * @var string
   */
  protected $title;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var int
   */
  protected $productionMode;

  /**
   * @var string
   */
  protected $unixUsername;

  /**
   * @var string
   */
  protected $vcsType;

  /**
   * @var string
   */
  protected $vcsUrl;

  function __construct($site_id, Client $client) {
    $this->siteId = $site_id;
    $this->client = $client;
    $data = $this->client->get(['sites/{site}.json', ['site' => $this->getSiteId()]])->json();
    $this->title = $data['title'];
    $this->name = $data['name'];
    $this->productionMode = $data['production_mode'];
    $this->unixUsername = $data['unix_username'];
    $this->vcsType = $data['vcs_type'];
    $this->vcsUrl = $data['vcs_url'];
  }

  /**
   * {@inheritdoc}
   */
  public function getSiteId() {
    return $this->siteId;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return int
   */
  public function getProductionMode() {
    return $this->productionMode;
  }

  /**
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @return string
   */
  public function getUnixUsername() {
    return $this->unixUsername;
  }

  /**
   * @return string
   */
  public function getVcsType() {
    return $this->vcsType;
  }

  /**
   * @return string
   */
  public function getVcsUrl() {
    return $this->vcsUrl;
  }

  /**
   * {@inheritdoc}
   */
  public function getTasks() {
    $tasks = [];
    foreach ($this->client->get(['sites/{site}/tasks.json', ['site' => $this->getSiteId()]])->json() as $data) {
      $tasks[$data['id']] = new Task($data['id'], $this->getSiteId(), $this->client, $data);
    }
    return $tasks;
  }

  public function getTask($id) {
    return new Task($id, $this->getSiteId(), $this->client);
  }

  public function getEnvs() {
    $envs = [];
    foreach ($this->client->get(['sites/{site}/envs.json', ['site' => $this->getSiteId()]])->json() as $data) {
      $envs[$data['name']] = new Envs($data['name'], $this->getSiteId(), $this->client, $data);
    }
    return $envs;
  }

  public function getEnv($name) {
    return new Envs($name, $this->getSiteId(), $this->client);
  }

}
