<?php
/**
 * @file
 * Contains \Acquia\Platform\Cloud\Hosting\Api\Client.
 */

namespace Acquia\Platform\Cloud\Hosting\Api;

use Acquia\Platform\Cloud\Common\FactoryInterface;
use Acquia\Platform\Cloud\Hosting\DataSourceInterface;
use GuzzleHttp\Client as GuzzleClient;

class Client implements DataSourceInterface {

  /**
   * @var FactoryInterface
   */
  protected $factory;

  function __construct(GuzzleClient $client, FactoryInterface $factory) {
    $this->client($client);
    $this->factory = $factory;
  }

  /**
   * @param $url
   * @param array $options
   * @throws \Exception
   * @return \GuzzleHttp\Message\ResponseInterface
   */
  protected function request($url, array $options = []) {
    $request = $this->client()->get($url, $options);
    if (!is_object($request)) {
      var_export($request);
    }
    if ($request->getStatusCode() != 200) {
      throw new \Exception(sprintf('Status code was not OK. %d returned instead.', $request->getStatusCode()));
    }
    return $request;
  }

  /**
   * Statically stores and returns a guzzle client.
   *
   * The Guzzle client is quite large and we really don't want to deal with it
   * during debugging, so we store it statically in a method to hide it away.
   *
   * @param \GuzzleHttp\Client $new_client
   *
   * @return \GuzzleHttp\Client
   */
  protected function client(GuzzleClient $new_client = NULL) {
    static $client;
    if (!is_null($new_client)) {
      $client = $new_client;
    }
    return $client;
  }

  /**
   * @param $type
   * @param array $data
   * @return object
   */
  protected function createObjectType($type, array $data = []) {
    if (empty($data['dataSource'])) {
      $data['dataSource'] = $this;
    }
    return $this->factory->createObjectType($type, $data);
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

  /**
   * {@inheritdoc}
   */
  public function getPhpProcs($site_id, $env, $server, array $options = []) {
    $options = [
      'query' => [
        'memory_limits' => [
          '32M',
          '64M',
          '128M',
        ],
        'apc_shm' => [
          '64M',
          '128M',
          '256M'
        ],
      ],
    ];
    $data = $this->request(['sites/{site}/envs/{env}/servers/{server}/php-procs.json', ['site' => $site_id, 'env' => $env, 'server' => $server]], $options)->json();
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function getDomains($site_id, $env) {
    $data = $this->request(['sites/{site}/envs/{env}/domains.json', ['site' => $site_id, 'env' => $env]])->json();
    return $data;
  }

  public function getDomain($site_id, $env, $domain) {
    $data = $this->request(['sites/{site}/envs/{env}/domains/{domain}.json', ['site' => $site_id, 'env' => $env, 'domain' => $domain]])->json();
    $data['site_id'] = $site_id;
    $data['env'] = $env;
    return $this->createObjectType('domain', $data);
  }

  public function createDomain($site_id, $env, $domain) {
    $data = $this->client()->post(['sites/{site}/envs/{env}/domains/{domain}.json', ['site' => $site_id, 'env' => $env, 'domain' => $domain]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

  public function deleteDomain($site_id, $env, $domain) {
    $data = $this->client()->delete(['sites/{site}/envs/{env}/domains/{domain}.json', ['site' => $site_id, 'env' => $env, 'domain' => $domain]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

  public function purgeDomainCache($site_id, $env, $domain) {
    $data = $this->client()->delete(['sites/{site}/envs/{env}/domains/{domain}/cache.json', ['site' => $site_id, 'env' => $env, 'domain' => $domain]])->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

  /**
   * {@inheritdoc}
   */
  public function install($site_id, $env, $type, $source) {
    $options = [
      'query' => [
        'source' => $source,
      ],
    ];
    $data = $this->client()->post(['sites/{site}/envs/{env}/install/{type}.json', ['site' => $site_id, 'env' => $env, 'type' => $type]], $options)->json();
    $data['site_id'] = $site_id;
    return $this->createObjectType('task', $data);
  }

}
