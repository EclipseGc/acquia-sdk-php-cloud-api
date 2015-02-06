<?php
/**
 * @file
 * Contains DomainInterface.php.
 */
namespace Acquia\Platform\Cloud\Api\SDK\Domain;

use Acquia\Platform\Cloud\Api\DataInterface;

interface DomainInterface extends DataInterface {
  public function getName();

  public function delete();

  public function purgeCache();

  public function getSiteId();

  public function getEnv();
}