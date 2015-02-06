<?php
/**
 * @file
 * Contains GuzzleTestClient.php.
 */

namespace Acquia\Cloud\Tests;


use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class GuzzleTestClient extends Client {

  protected $task1 = [
    'id' => '0000001',
    'completed' => '1382380098',
    'created' => '1382380094',
    'description' => 'Create database test0 in Dev.',
    'logs' => '',
    'queue' => 'ah-callback',
    'result' => '',
    'sender' => 'DatabaseFactory::save',
    'started' => '1382380094',
    'state' => 'done',
  ];

  protected $task2 = [
    'id' => '0000002',
    'completed' => '1382380098',
    'created' => '1382380094',
    'description' => 'Create database test0 in Stage.',
    'logs' => '',
    'queue' => 'ah-callback',
    'result' => '',
    'sender' => 'DatabaseFactory::save',
    'started' => '1382380096',
    'state' => 'done',
  ];

  protected $env1 = [
    'name' => 'dev',
    'vcs_path' => 'master',
    'ssh_host' => 'free-3201.devcloud.hosting.acquia.com',
    'db_clusters' =>
      array (
        0 => '3097',
      ),
    'default_domain' => 'lightningfreedev.devcloud.acquia-sites.com',
    'livedev' => 'disabled'
  ];

  protected $env2 = [
    'name' => 'test',
    'vcs_path' => 'tags/WELCOME',
    'ssh_host' => 'free-3201.devcloud.hosting.acquia.com',
    'db_clusters' =>
      array (
        0 => '3097',
      ),
    'default_domain' => 'lightningfreetest.devcloud.acquia-sites.com',
    'livedev' => 'disabled'
  ];

  public function get($url = null, $options = []) {
    if (is_array($url)) {
      $test = $url[0];
    }
    else {
      $test = $url;
    }
    switch($test) {
      case 'sites.json':
        return $this->getResponse($this->getSites());
      case 'sites/{site}.json':
        return $this->getResponse($this->getSite());
      case 'sites/{site}/tasks.json':
        return $this->getResponse($this->getTasks());
      case 'sites/{site}/tasks/{task}.json':
        return $this->getResponse($this->getTask());
      case 'sites/{site}/envs.json':
        return $this->getResponse($this->getEnvs());
      case 'sites/{site}/envs/{env}.json':
        return $this->getResponse($this->getEnv());
    }
  }

  protected function getResponse($body) {
    $stream = Stream::factory($body);
    $response = new Response(200);
    $response->setBody($stream);
    return $response;
  }

  protected function getSites() {
    $json = json_encode([
      0 => 'devcloud:test0',
      1 => 'devcloud:test1',
    ]);
    return $json;
  }

  protected function getSite() {
    $json = json_encode([
      'title' => 'test0',
      'name' => 'devcloud:test0',
      'production_mode' => '0',
      'unix_username' => 'test0',
      'vcs_type' => 'git',
      'vcs_url' => 'test0@svn-test.devcloud.hosting.acquia.com:test0.git',
    ]);
    return $json;
  }

  protected function getTasks() {
    $tasks = [
      '0000001' => $this->task1,
      '0000002' => $this->task2
    ];
    return json_encode($tasks);
  }

  protected function getTask() {
    return json_encode($this->task1);
  }

  protected function getEnvs() {
    $envs = [
      $this->env1,
      $this->env2
    ];
    return json_encode($envs);
  }

  protected function getEnv() {
    return json_encode($this->env1);
  }

} 