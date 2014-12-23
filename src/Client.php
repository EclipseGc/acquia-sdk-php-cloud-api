<?php
/**
 * @file
 * Contains \Acquia\Cloud\API\Client.
 */

namespace Acquia\Cloud\Api;

use Acquia\Cloud\Api\SDK\RequestTrait;
use GuzzleHttp\Client as GuzzleClient;

class Client {

  const BASE_URL         = 'https://cloudapi.acquia.com/{version}/';
  const BASE_PATH        = 'v1';

  /**
   * @var ObjectFactoryInterface
   */
  protected $factory;

  /**
   * @param ObjectFactoryInterface $factory
   */
  public function __construct(ObjectFactoryInterface $factory) {
    $this->factory = $factory;
  }

  /**
   * @param $user
   * @param $pass
   * @return static
   */
  public static function create($user, $pass) {
    $factory = static::createFactory($user, $pass);
    return new static($factory);
  }

  /**
   * @param $user
   * @param $pass
   * @return ObjectFactory
   */
  public static function createFactory($user, $pass) {
    $config = [
      'base_url' => [static::BASE_URL, ['version' => static::BASE_PATH]],
      'defaults' => [
        'auth'    => [$user, $pass],
      ],
    ];
    return new ObjectFactory(new GuzzleClient($config));
  }

  /**
   * @return array|mixed
   */
  public function getAliases() {
    return $this->factory->getAliases();
  }

  /**
   * @return \Acquia\Cloud\Api\SDK\Sites|\Acquia\Cloud\Api\SDK\SiteInterface[]
   */
  public function getSites() {
    return $this->factory->getSites();
  }

}
