<?php
/**
 * @file
 * Contains Site.php.
 */

namespace Acquia\Cloud\Api\SDK;

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
   * @return string
   */
  public function getSiteId() {
    return $this->siteId;
  }

  public function getTasks() {
    return $this->client->get(['sites/{site}/tasks.json', ['site' => $this->getSiteId()]])->json();
  }

}