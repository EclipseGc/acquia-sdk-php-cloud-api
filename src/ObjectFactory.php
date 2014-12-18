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

  public function getObjectTypeClass($type) {
    if (isset($this->objectTypes[$type])) {
      return $this->objectTypes[$type];
    }
    throw new \Exception(sprintf('No object type %s', $type));
  }

  public function createObjectType($type, array $data = array()) {
    $objectClass = $this->getObjectTypeClass($type);
    $reflector = new \ReflectionClass($objectClass);
    if (!isset($data['factory'])) {
      $data['factory'] = $this;
    }
    $arguments = [];
    foreach ($reflector->getMethod('__construct')->getParameters() as $param) {
      $param_name = $param->getName();
      if (array_key_exists($param_name, $data)) {
        $arguments[] = $data[$param_name];
      }
    }
    return $reflector->newInstanceArgs($arguments);
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
    $data = [
      'sites' => $this->request('sites.json')->json(),
    ];
    return $this->createObjectType('sites', $data);
  }

  /**
   * {@inheritdoc}
   */
  public function getSite($site_id) {
    $data = $this->request(['sites/{site}.json', ['site' => $site_id]])->json();
    return $this->createObjectType('site', $data);
  }

  /**
   * {@inheritdoc}
   */
  public function getTasks($site_id) {
    $tasks = [];
    foreach ($this->request(['sites/{site}/tasks.json', ['site' => $site_id]])->json() as $data) {
      $data['site_id'] = $site_id;
      $tasks[$data['id']] = $this->createObjectType('task', $data);
    }
    return $tasks;
  }

  /**
   * {@inheritdoc}
   */
  public function getTask($site_id, $task_id) {
    $data = $this->request(['sites/{site}/tasks/{task}.json', ['site' => $site_id, 'task' => $task_id]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

  /**
   * {@inheritdoc}
   */
  public function getEnvs($site_id) {
    $envs = [];
    foreach ($this->request(['sites/{site}/envs.json', ['site' => $site_id]])->json() as $id => $data) {
      $data['site_id'] = $site_id;
      $envs[$id] = $this->createObjectType('envs', $data);
    }
    return $envs;
  }

  /**
   * {@inheritdoc}
   */
  public function getEnv($site_id, $name) {
    $data = $this->request(['sites/{site}/envs/{env}.json',['site' => $site_id, 'env' => $name]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('envs', $data);
  }

  public function getLogStream($site_id, $name) {
    return $this->request(['sites/{site}/envs/{env}/logstream.json', ['site' => $site_id, 'env' => $name]])->json();
  }

  public function enableLiveDev($site_id, $name) {
    // @todo the livedev param appears to always be disabled. Need to figure
    // out why so we can appropriately check before just firing a new task.
    $data = $this->client()->post(['sites/{site}/envs/{env}/livedev/enable.json', ['site' => $site_id, 'env' => $name]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

  public function disableLiveDev($site_id, $name) {
    // @todo the livedev param appears to always be disabled. Need to figure
    // out why so we can appropriately check before just firing a new task.
    $data = $this->client()->post(['sites/{site}/envs/{env}/livedev/disable.json', ['site' => $site_id, 'env' => $name]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

  public function getServers($site_id, $env) {
    $servers = [];
    foreach ($this->request(['sites/{site}/envs/{env}/servers.json', ['site' => $site_id, 'env' => $env]])->json() as $data) {
      $data['site_id'] = $site_id;
      $data['env'] = $env;
      $servers[$data['name']] = $this->createObjectType('server', $data);
    }
    return $servers;
  }

  public function getServer($site_id, $env, $server) {
    $data = $this->request(['sites/{site}/envs/{env}/servers/{server}.json', ['site' => $site_id, 'env' => $env, 'server' => $server]])->json();
    $data['site_id'] = $site_id;
    $data['env'] = $env;
    return $this->createObjectType('server', $data);
  }

}
