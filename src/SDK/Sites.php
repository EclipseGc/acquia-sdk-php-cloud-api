<?php
/**
 * @file
 * Contains Sites.php.
 */

namespace Acquia\Cloud\Api\SDK;


use GuzzleHttp\Client;

class Sites implements \ArrayAccess {

  use RequestTrait;

  /**
   * The array of sites for this subscription.
   *
   * @var array
   */
  protected $sites;

  /**
   * The class to instantiate for your sites.
   * @var string
   */
  protected $siteClass;

  /**
   * @param Client $client
   * @param string $site_class
   * @throws \Exception
   */
  public function __construct(Client $client, $site_class = '\Acquia\Cloud\Api\SDK\Site') {
    if (!in_array("Acquia\\Cloud\\Api\\SDK\\SiteInterface", class_implements($site_class))) {
      // @todo throw custom exception and make the string better.
      throw new \Exception('The $site_class must implement \Acquia\Cloud\Api\SDK\SiteInterface');
    }
    $this->client($client);
    $this->sites = $this->request('sites.json')->json();
    $this->siteClass = $site_class;
  }

  /**
   * Implements \ArrayAccess::offsetExists().
   */
  public function offsetExists($offset) {
    return isset($this->sites[$offset]);
  }

  /**
   * Implements \ArrayAccess::offsetGet().
   *
   * @param mixed $offset
   * @return null|\Acquia\Cloud\Api\SDK\SiteInterface
   */
  public function offsetGet($offset) {
    if (isset($this->sites[$offset])) {
      if (!$this->sites[$offset] instanceof $this->siteClass) {
        $this->sites[$offset] = new $this->siteClass($this->sites[$offset], $this->client());
      }
      return $this->sites[$offset];
    }
    return null;
  }

  /**
   * Implements \ArrayAccess::offsetSet().
   */
  public function offsetSet($offset, $value) {
    // @todo throw a custom exception
    throw new \Exception('You cannot manually add or change sites.');
  }

  /**
   * Implements \ArrayAccess::offsetUnset().
   */
  public function offsetUnset($offset) {
    // @todo throw a custom exception
    throw new \Exception('You can not unset any sites.');
  }

}
