<?php
/**
 * @file
 * Contains \Acquia\Platform\Cloud\API\Client.
 */

namespace Acquia\Platform\Cloud\Api;

use GuzzleHttp\Client as GuzzleClient;

class Wrapper {

  const BASE_URL         = 'https://cloudapi.acquia.com/{version}/';
  const BASE_PATH        = 'v1';

  /**
   * @param $user
   * @param $pass
   * @return \Acquia\Platform\Cloud\Api\ClientInterface
   */
  public static function create($user, $pass) {
    $config = [
      'base_url' => [static::BASE_URL, ['version' => static::BASE_PATH]],
      'defaults' => [
        'auth'    => [$user, $pass],
      ],
    ];
    return new Client(new GuzzleClient($config), new Factory());
  }

}
