<?php
/**
 * @file
 * Contains ClienttInterface.php.
 */
namespace Acquia\Cloud\Api;

interface ClientInterface {
  /**
   * @return array
   */
  public function getAliases();

  /**
   * @param $site_id
   * @param $env
   * @param $domain
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function createDomain($site_id, $env, $domain);

  /**
   * @return \Acquia\Cloud\Api\SDK\Sites|\Acquia\Cloud\Api\SDK\SiteInterface[]
   */
  public function getSites();

  /**
   * @param $site_id
   * @param $env
   * @param $domain
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function deleteDomain($site_id, $env, $domain);

  /**
   * @param $site_id
   * @param $name
   * @return array
   */
  public function getLogStream($site_id, $name);

  /**
   * @param $site_id
   * @param $name
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function disableLiveDev($site_id, $name);

  /**
   * @param $site_id
   * @param $env
   * @param $server
   * @return array
   *
   * @deprecated
   *   The API endpoint is deprecated, but the code remains to show it is still
   *   documented.
   */
  public function getPhpProcs($site_id, $env, $server);

  /**
   * @param $site_id
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface[]
   */
  public function getTasks($site_id);

  /**
   * @param $site_id
   * @param $env
   * @param $domain
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function purgeDomainCache($site_id, $env, $domain);

  /**
   * @param $site_id
   * @param $task_id
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function getTask($site_id, $task_id);

  /**
   * @param $site_id
   * @param $env
   * @param $domain
   * @return \Acquia\Cloud\Api\SDK\Domain\DomainInterface
   */
  public function getDomain($site_id, $env, $domain);

  /**
   * @param $site_id
   * @param $env
   * @return \Acquia\Cloud\Api\SDK\Server\ServerInterface[]
   */
  public function getServers($site_id, $env);

  /**
   * @param $site_id
   * @param $env
   * @return array
   */
  public function getDomains($site_id, $env);

  /**
   * @param $site_id
   * @param $name
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function enableLiveDev($site_id, $name);

  /**
   * @param $site_id
   * @param $env
   * @param $server
   * @return \Acquia\Cloud\Api\SDK\Server\ServerInterface
   */
  public function getServer($site_id, $env, $server);

  /**
   * @param $site_id
   * @return \Acquia\Cloud\Api\SDK\SiteInterface
   */
  public function getSite($site_id);

  /**
   * @param $site_id
   * @return \Acquia\Cloud\Api\SDK\Environment\EnvironmentInterface[]
   */
  public function getEnvs($site_id);

  /**
   * @param $site_id
   * @param $name
   * @return \Acquia\Cloud\Api\SDK\Environment\EnvironmentInterface
   */
  public function getEnv($site_id, $name);

  /**
   * @param string $site_id
   * @param string $env
   * @param string $type
   * @param string $source
   * @return \Acquia\Cloud\Api\SDK\Task\TaskInterface
   */
  public function install($site_id, $env, $type, $source);
}