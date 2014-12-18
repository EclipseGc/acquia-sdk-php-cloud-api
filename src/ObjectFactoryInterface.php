<?php
/**
 * @file
 * Contains ObjectFactoryInterface.php.
 */
namespace Acquia\Cloud\Api;

interface ObjectFactoryInterface {

  /**
   * @param $type
   * @return string
   */
  public function getObjectTypeClass($type);

  /**
   * @param $type
   * @param array $data
   * @return object
   */
  public function createObjectType($type, array $data = array());

  /**
   * @return array
   */
  public function getAliases();

  /**
   * @return \Acquia\Cloud\Api\SDK\Sites|\Acquia\Cloud\Api\SDK\SiteInterface[]
   */
  public function getSites();

  /**
   * @param $site_id
   * @return \Acquia\Cloud\Api\SDK\SiteInterface
   */
  public function getSite($site_id);

  /**
   * @param $site_id
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface[]
   */
  public function getTasks($site_id);

  /**
   * @param $site_id
   * @param $task_id
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function getTask($site_id, $task_id);

  /**
   * @param $site_id
   * @return \Acquia\Cloud\Api\SDK\Envs\EnvsInterface[]
   */
  public function getEnvs($site_id);

  /**
   * @param $site_id
   * @param $name
   * @return \Acquia\Cloud\Api\SDK\Envs\EnvsInterface
   */
  public function getEnv($site_id, $name);

  /**
   * @param $site_id
   * @param $name
   * @return array
   */
  public function getLogStream($site_id, $name);

  /**
   * @param $site_id
   * @param $name
   * @return \Acquia\Cloud\Api\SDK\Task\Task
   */
  public function enableLiveDev($site_id, $name);

  /**
   * @param $site_id
   * @param $name
   * @return \Acquia\Cloud\Api\SDK\Task\Task
   */
  public function disableLiveDev($site_id, $name);

  /**
   * @param $site_id
   * @param $env
   * @return \Acquia\Cloud\Api\SDK\Server\Server[]
   */
  public function getServers($site_id, $env);

  /**
   * @param $site_id
   * @param $env
   * @param $server
   * @return \Acquia\Cloud\Api\SDK\Server\Server
   */
  public function getServer($site_id, $env, $server);

}