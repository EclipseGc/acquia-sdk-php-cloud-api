<?php
/**
 * @file
 * Contains \Component5\CloudSDK\Client.
 */

namespace Acquia\Cloud\Api;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient {

  const BASE_URL         = 'https://cloudapi.acquia.com/{version}/';
  const BASE_PATH        = 'v1';

  public function __construct($user, $pass) {
    $config = [
      'base_url' => [$this::BASE_URL, ['version' => $this::BASE_PATH]],
      'defaults' => [
        'auth'    => [$user, $pass],
      ],
    ];
    parent::__construct($config);
  }

  public function getAliases() {
    return $this->get('me/drushrc.json')->json();
  }

  public function getSites() {
    return $this->get('sites.json')->json();
  }

  public function getSiteTasks($site) {
    return $this->get(['sites/{site}/tasks.json', ['site' => $site]])->json();
  }
}
