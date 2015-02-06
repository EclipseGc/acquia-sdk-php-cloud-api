<?php
/**
 * @file
 * Contains SiteInterface.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Site;


use Acquia\Platform\Cloud\Api\DataInterface;

interface SiteInterface extends DataInterface {

  /**
   * @return string
   */
  public function getName();

  /**
   * @return int
   */
  public function getProductionMode();

  /**
   * @return string
   */
  public function getTitle();

  /**
   * @return string
   */
  public function getUnixUsername();

  /**
   * @return string
   */
  public function getVcsType();

  /**
   * @return string
   */
  public function getVcsUrl();

  /**
   * Get all tasks for this site.
   *
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface[]
   */
  public function getTasks();

  /**
   * Retrieve an individual task for this site.
   *
   * @param int $id
   *   The task id you wish to retrieve.
   *
   * @return \Acquia\Platform\Cloud\Hosting\Task\TaskInterface
   */
  public function getTask($id);

  /**
   * Get all available environments for this site.
   *
   * @return \Acquia\Platform\Cloud\Hosting\Environment\EnvironmentInterface[]
   */
  public function getEnvs();

  /**
   * Retrieve an individual environment for this site.
   *
   * @param string $name
   *   The name of the environment you wish to load.
   *
   * @return \Acquia\Platform\Cloud\Hosting\Environment\EnvironmentInterface
   */
  public function getEnv($name);

}
