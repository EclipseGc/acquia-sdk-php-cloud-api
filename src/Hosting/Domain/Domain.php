<?php
/**
 * @file
 * Contains Domain.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Domain;


use Acquia\Platform\Cloud\Api\ClientInterface;

class Domain implements DomainInterface {

  /**
   * @var \Acquia\Platform\Cloud\Api\ClientInterface
   */
  protected $client;

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

  public function __construct(ClientInterface $client, $site_id, $env, $name) {
    $this->client = $client;
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
    return $this->client->deleteDomain($this->getSiteId(), $this->getEnv(), $this->getName());
  }

  public function purgeCache() {
    return $this->client->purgeDomainCache($this->getSiteId(), $this->getEnv(), $this->getName());
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