<?php
/**
 * @file
 * Contains DomainInterface.php.
 */
namespace Acquia\Cloud\Api\SDK\Domain;

use Acquia\Cloud\Api\DataInterface;

interface DomainInterface extends DataInterface {
  public function getName();

  public function delete();

  public function purgeCache();

  public function getSiteId();

  public function getEnv();
}