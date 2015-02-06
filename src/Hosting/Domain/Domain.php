<?php
/**
 * @file
 * Contains Domain.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Domain;


use Acquia\Platform\Cloud\Hosting\DataInterface;

class Domain implements DomainInterface {

  /**
   * @var \Acquia\Platform\Cloud\Hosting\DataInterface
   */
  protected $dataSource;

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

  public function __construct(DataInterface $dataSource, $site_id, $env, $name) {
    $this->dataSource = $dataSource;
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
    return $this->dataSource->deleteDomain($this->getSiteId(), $this->getEnv(), $this->getName());
  }

  public function purgeCache() {
    return $this->dataSource->purgeDomainCache($this->getSiteId(), $this->getEnv(), $this->getName());
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