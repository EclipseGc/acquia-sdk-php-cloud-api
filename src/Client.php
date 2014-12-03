<?php
/**
 * @file
 * Contains \Acquia\Cloud\API\Client.
 */

namespace Acquia\Cloud\Api;

use Acquia\Cloud\Api\SDK\Sites;
use GuzzleHttp\Client as GuzzleClient;

class Client {

  const BASE_URL         = 'https://cloudapi.acquia.com/{version}/';
  const BASE_PATH        = 'v1';

  /**
   * The Guzzle Client through which we will proxy our calls.
   *
   * @var \GuzzleHttp\Client
   */
  protected $client;

  public function __construct($user, $pass) {
    $config = [
      'base_url' => [$this::BASE_URL, ['version' => $this::BASE_PATH]],
      'defaults' => [
        'auth'    => [$user, $pass],
      ],
    ];
    $this->client = new GuzzleClient($config);
  }

  public function getAliases() {
    return $this->get('me/drushrc.json')->json();
  }

  public function getSites() {
    return new Sites($this->client);
  }

  public function getSiteTasks($site) {
    return $this->get(['sites/{site}/tasks.json', ['site' => $site]])->json();
  }
}
