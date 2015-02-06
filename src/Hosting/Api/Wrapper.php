<?php
/**
 * @file
 * Contains \Acquia\Platform\Cloud\Hosting\Api\Wrapper.
 */

namespace Acquia\Platform\Cloud\Hosting\Api;

use Acquia\Platform\Cloud\Hosting\Factory;
use GuzzleHttp\Client as GuzzleClient;

class Wrapper {

  const BASE_URL         = 'https://cloudapi.acquia.com/{version}/';
  const BASE_PATH        = 'v1';

  /**
   * @param $user
   * @param $pass
   * @return \Acquia\Platform\Cloud\Hosting\DataSourceInterface
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
