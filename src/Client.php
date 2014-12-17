<?php
/**
 * @file
 * Contains \Acquia\Cloud\API\Client.
 */

namespace Acquia\Cloud\Api;

use Acquia\Cloud\Api\SDK\RequestTrait;
use GuzzleHttp\Client as GuzzleClient;

class Client {

  use RequestTrait;

  const BASE_URL         = 'https://cloudapi.acquia.com/{version}/';
  const BASE_PATH        = 'v1';

  protected $sitesClass = 'Acquia\Cloud\Api\SDK\Sites';

  protected $sites;

  public function __construct($user, $pass) {
    $config = [
      'base_url' => [$this::BASE_URL, ['version' => $this::BASE_PATH]],
      'defaults' => [
        'auth'    => [$user, $pass],
      ],
    ];
    $this->client(new GuzzleClient($config));
  }

  public function getAliases() {
    return $this->request('me/drushrc.json')->json();
  }

  /**
   * @return \Acquia\Cloud\Api\SDK\SiteInterface[]
   */
  public function getSites() {
    if (!isset($this->sites)) {
      $this->sites = new $this->sitesClass($this->client());
    }
    return $this->sites;
  }

}
