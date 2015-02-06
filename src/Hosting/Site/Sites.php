<?php
/**
 * @file
 * Contains Sites.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Site;

use Acquia\Platform\Cloud\Common\ObjectInterface;
use Acquia\Platform\Cloud\Hosting\DataSourceInterface;

class Sites implements \ArrayAccess, ObjectInterface {

  /**
   * The array of sites for this subscription.
   *
   * @var array
   */
  protected $sites;

  /**
   * @var \Acquia\Platform\Cloud\Hosting\DataSourceInterface
   */
  protected $dataSource;

  /**
   * @param \Acquia\Platform\Cloud\Hosting\DataSourceInterface $dataSource
   * @param array $sites
   */
  public function __construct(DataSourceInterface $dataSource, array $sites) {
    $this->dataSource = $dataSource;
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
   * @return NULL|\Acquia\Platform\Cloud\Hosting\Site\SiteInterface
   */
  public function offsetGet($offset) {
    if (isset($this->sites[$offset])) {
      if (!is_object($this->sites[$offset])) {
        $this->sites[$offset] = $this->dataSource->getSite($this->sites[$offset]);
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
      if ($value instanceof \Acquia\Platform\Cloud\Hosting\Site\SiteInterface) {
        $this->sites[$offset] = $value;
      }
      throw new \Exception('Setting site values is only allowed using a instance of a \Acquia\Platform\Cloud\Hosting\SiteInterface object.');
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

  public function getData() {
    return $this->sites;
  }

  public static function getKeys() {
    return [
      'sites',
    ];
  }

}
