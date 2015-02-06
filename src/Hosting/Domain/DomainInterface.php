<?php
/**
 * @file
 * Contains DomainInterface.php.
 */
namespace Acquia\Platform\Cloud\Hosting\Domain;

use Acquia\Platform\Cloud\Common\ObjectInterface;

interface DomainInterface extends ObjectInterface {
  public function getName();

  public function delete();

  public function purgeCache();

  public function getSiteId();

  public function getEnv();
}