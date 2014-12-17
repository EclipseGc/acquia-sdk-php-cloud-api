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
    $this->objectFactory();
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
   * @param ObjectFactoryInterface $factory
   * @return ObjectFactory
   */
  protected function objectFactory(ObjectFactoryInterface $factory = NULL) {
    if (!isset($this->objectFactory)) {
      $this->objectFactory = new ObjectFactory($this->client());
    }
    return $this->objectFactory;
  }

  public function getAliases() {
    return $this->request('me/drushrc.json')->json();
  }

  /**
   * @return \Acquia\Cloud\Api\SDK\SiteInterface[]
   */
  public function getSites() {
    return $this->objectFactory()->getSites();
  }

}
