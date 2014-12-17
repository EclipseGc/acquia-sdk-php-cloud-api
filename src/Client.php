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

  protected $objectFactory;

  protected $sites;

  public function __construct($user, $pass) {
    $this->createGuzzleClient($user, $pass);
  }

  protected function createGuzzleClient($user, $pass) {
    $config = [
      'base_url' => [$this::BASE_URL, ['version' => $this::BASE_PATH]],
      'defaults' => [
        'auth'    => [$user, $pass],
      ],
    ];
    $this->client(new GuzzleClient($config));
  }

  /**
   * Instantiates an ObjectFactory if one doesn't exist and returns the object.
   *
   * @return ObjectFactoryInterface
   */
  protected function objectFactory() {
    if (!isset($this->objectFactory)) {
      $this->objectFactory = new ObjectFactory($this->client());
    }
    return $this->objectFactory;
  }

  /**
   * Returns the current ObjectFactory.
   *
   * @return ObjectFactoryInterface
   */
  public function getObjectFactory() {
    return $this->objectFactory();
  }

  /**
   * Sets a new ObjectFactory.
   *
   * @param ObjectFactoryInterface $factory
   *
   * @return $this
   */
  public function setObjectFactory(ObjectFactoryInterface $factory) {
    $this->objectFactory = $factory;
    return $this;
  }

  /**
   * @return array|mixed
   */
  public function getAliases() {
    return $this->objectFactory()->getAliases();
  }

  /**
   * @return \Acquia\Cloud\Api\SDK\SiteInterface[]
   */
  public function getSites() {
    return $this->objectFactory()->getSites();
  }

}
