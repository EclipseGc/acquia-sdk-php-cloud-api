<?php
/**
 * @file
 * Contains Domain.php.
 */

namespace Acquia\Cloud\Api\SDK\Domain;


use Acquia\Cloud\Api\ObjectFactoryInterface;

class Domain implements DomainInterface {

  /**
   * @var \Acquia\Cloud\Api\ObjectFactoryInterface
   */
  protected $factory;

  /**
   * @var string
   */
  protected $siteId;

  /**
   * @var string
   */
  protected $env;

  /**
   * @var string
   */
  protected $name;

  public function __construct(ObjectFactoryInterface $factory, $site_id, $env, $name) {
    $this->factory = $factory;
    $this->siteId = $site_id;
    $this->env = $env;
    $this->name = $name;
  }

  public function getSiteId() {
    return $this->siteId;
  }

  public function getEnv() {
    return $this->env;
  }

  public function getName() {
    return $this->name;
  }

  public function delete() {
    return $this->factory->deleteDomain($this->getSiteId(), $this->getEnv(), $this->getName());
  }

  public function purgeCache() {
    return $this->factory->purgeDomainCache($this->getSiteId(), $this->getEnv(), $this->getName());
  }

  public function getData() {
    return [
      'name' => $this->getName(),
    ];
  }

  public static function getKeys() {
    return [
      'name',
    ];
  }

} 