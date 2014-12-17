<?php
/**
 * @file
 * Contains ObjectFactory.php.
 */

namespace Acquia\Cloud\Api;


use Acquia\Cloud\Api\SDK\RequestTrait;
use GuzzleHttp\Client as GuzzleClient;

class ObjectFactory implements ObjectFactoryInterface {

  use RequestTrait;

  protected $objectTypes = array(
    'sites' => '\Acquia\Cloud\Api\SDK\Sites',
    'site' => '\Acquia\Cloud\Api\SDK\Site',
    'task' => '\Acquia\Cloud\Api\SDK\Task\Task',
    'envs' => '\Acquia\Cloud\Api\SDK\Envs\Envs',
    'server' => '\Acquia\Cloud\Api\SDK\Server\Server',
  );

  function __construct(GuzzleClient $client) {
    $this->client($client);
  }

  /**
   * {@inheritdoc}
   */
  public function getAliases() {
    return $this->request('me/drushrc.json')->json();
  }

  /**
   * {@inheritdoc}
   */
  public function getSites() {
    return new $this->objectTypes['sites']($this, $this->request('sites.json')->json());
  }

  /**
   * {@inheritdoc}
   */
  public function getSite($site_id) {
    $data = $this->request(['sites/{site}.json', ['site' => $site_id]])->json();
    return new $this->objectTypes['site']($this, $data['title'], $data['name'], $data['production_mode'], $data['unix_username'], $data['vcs_type'], $data['vcs_url']);
  }

  /**
   * {@inheritdoc}
   */
  public function getTasks($site_id) {
    $tasks = [];
    foreach ($this->request(['sites/{site}/tasks.json', ['site' => $site_id]])->json() as $data) {
      $tasks[$data['id']] = $this->objectTypes['task']($data['id'], $site_id, $data['completed'], $data['created'], $data['description'], $data['logs'], $data['queue'], $data['result'], $data['sender'], $data['started'], $data['state']);
    }
    return $tasks;
  }

  /**
   * {@inheritdoc}
   */
  public function getTask($site_id, $task_id) {
    $data = $this->request(['sites/{site}/tasks/{task}.json', ['site' => $site_id, 'task' => $task_id]])->json();
    return new $this->objectTypes['task']($task_id, $site_id, $data['completed'], $data['created'], $data['description'], $data['logs'], $data['queue'], $data['result'], $data['sender'], $data['started'], $data['state']);
  }

  /**
   * {@inheritdoc}
   */
  public function getEnvs($site_id) {
    $envs = [];
    foreach ($this->request(['sites/{site}/envs.json', ['site' => $site_id]])->json() as $id => $data) {
      $envs[$id] =  new $this->objectTypes['envs']($this, $data['name'], $site_id, $data['vcs_path'], $data['ssh_host'], $data['db_clusters'], $data['default_domain'], $data['livedev']);
    }
    return $envs;
  }

  /**
   * {@inheritdoc}
   */
  public function getEnv($site_id, $name) {
    $data = $this->request(['sites/{site}/envs/{env}.json',['site' => $site_id, 'env' => $name]])->json();
    return new $this->objectTypes['envs']($this, $name, $site_id, $data['vcs_path'], $data['ssh_host'], $data['db_clusters'], $data['default_domain'], $data['livedev']);
  }

  public function getLogStream($site_id, $name) {
    return $this->request(['sites/{site}/envs/{env}/logstream.json', ['site' => $site_id, 'env' => $name]])->json();
  }

  public function enableLiveDev($site_id, $name) {
    // @todo the livedev param appears to always be disabled. Need to figure
    // out why so we can appropriately check before just firing a new task.
    $data = $this->client()->post(['sites/{site}/envs/{env}/livedev/enable.json', ['site' => $site_id, 'env' => $name]])->json();
    return new $this->objectTypes['task']($data['id'], $site_id, $data['completed'], $data['created'], $data['description'], $data['logs'], $data['queue'], $data['result'], $data['sender'], $data['started'], $data['state']);
  }

  public function disableLiveDev($site_id, $name) {
    // @todo the livedev param appears to always be disabled. Need to figure
    // out why so we can appropriately check before just firing a new task.
    $data = $this->client()->post(['sites/{site}/envs/{env}/livedev/disable.json', ['site' => $site_id, 'env' => $name]])->json();
    return new $this->objectTypes['task']($data['id'], $site_id, $data['completed'], $data['created'], $data['description'], $data['logs'], $data['queue'], $data['result'], $data['sender'], $data['started'], $data['state']);
  }

  public function getServers($site_id, $env) {
    $servers = [];
    foreach ($this->request(['sites/{site}/envs/{env}/servers.json', ['site' => $site_id, 'env' => $env]])->json() as $data) {
      $servers[$data['name']] = new $this->objectTypes['server']($data['name'], $env, $site_id, $data['fqdn'], $data['services'], $data['ami_type'], $data['ec2_region'], $data['ec2_availability_zone']);
    }
    return $servers;
  }

  public function getServer($site_id, $env, $server) {
    $data = $this->request(['sites/{site}/envs/{env}/servers/{server}.json', ['site' => $site_id, 'env' => $env, 'server' => $server]])->json();
    return new $this->objectTypes['server']($server, $env, $site_id, $data['fqdn'], $data['services'], $data['ami_type'], $data['ec2_region'], $data['ec2_availability_zone']);
  }

}
