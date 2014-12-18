<?php
/**
 * @file
 * Contains Sites.php.
 */

namespace Acquia\Cloud\Api\SDK;

use Acquia\Cloud\Api\ObjectFactoryInterface;

class Sites implements \ArrayAccess {

  /**
   * The array of sites for this subscription.
   *
   * @var array
   */
  protected $sites;

  /**
   * @var \Acquia\Cloud\Api\ObjectFactoryInterface
   */
  protected $factory;

  /**
   * @param \Acquia\Cloud\Api\ObjectFactoryInterface $factory
   * @param array $sites
   */
  public function __construct(ObjectFactoryInterface $factory, array $sites) {
    $this->factory = $factory;
    $this->sites = $sites;
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
   * @return NULL|\Acquia\Cloud\Api\SDK\SiteInterface
   */
  public function offsetGet($offset) {
    if (isset($this->sites[$offset])) {
      if (!is_object($this->sites[$offset])) {
        $this->sites[$offset] = $this->factory->getSite($this->sites[$offset]);
      }
      return $this->sites[$offset];
    }
    return NULL;
  }

  /**
   * Implements \ArrayAccess::offsetSet().
   */
  public function offsetSet($offset, $value) {
    if (isset($this->sites[$offset])) {
      if ($value instanceof \Acquia\Cloud\Api\SDK\SiteInterface) {
        $this->sites[$offset] = $value;
      }
      throw new \Exception('Setting site values is only allowed using a instance of a \Acquia\Cloud\Api\SDK\SiteInterface object.');
    }
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
