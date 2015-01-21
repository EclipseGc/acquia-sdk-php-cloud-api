<?php
/**
 * @file
 * Contains FactoryInterfaceTest.php.
 */

namespace Acquia\Cloud\Api\Tests;

use Acquia\Cloud\Api\SDK\Environment\Environment;
use Acquia\Cloud\Api\SDK\Site;
use Acquia\Cloud\Api\SDK\Sites;

class FactoryInterfaceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \Acquia\Cloud\Api\Client::getSites
   * @covers \Acquia\Cloud\Api\Client::getAliases
   */
  public function testClient() {
    /** @var $client \Acquia\Cloud\Api\ClientInterface */
    $client = $this->getMockBuilder('\Acquia\Cloud\Api\ClientInterface')
      ->getMock();
    $client->expects($this->once())
      ->method('getSites');
    $client->expects($this->once())
      ->method('getAliases');
    $client->getSites();
    $client->getAliases();
  }

  /**
   * @covers \Acquia\Cloud\Api\SDK\Sites::offsetGet
   */
  public function testSites() {
    $client = $this->getMockBuilder('\Acquia\Cloud\Api\ClientInterface')
      ->getMock();
    $client->expects($this->exactly(2))
      ->method('getSite')
      ->withConsecutive(
        $this->equalTo('dev:test1'),
        $this->equalTo('dev:test2')
      );
    $sites = new Sites($client, ['dev:test1', 'dev:test2']);
    $sites[0];
    $sites[1];
  }

  /**
   * @covers \Acquia\Cloud\Api\SDK\Site::getEnvs
   * @covers \Acquia\Cloud\Api\SDK\Site::getEnv
   * @covers \Acquia\Cloud\Api\SDK\Site::getTasks
   * @covers \Acquia\Cloud\Api\SDK\Site::getTask
   */
  public function testSite() {
    // Setup Site value object requirements.
    $title = 'test0';
    $name = 'devcloud:test0';
    $production_mode = '0';
    $unix_username = 'test0';
    $vcs_type = 'git';
    $vcs_url = 'test0@svn-test.devcloud.hosting.acquia.com:test0.git';
    // Mock factory for Site object.
    $client = $this->getMockBuilder('\Acquia\Cloud\Api\ClientInterface')
      ->getMock();
    $client->expects($this->once())
      ->method('getEnvs')
      ->with($name);
    $client->expects($this->once())
      ->method('getEnv')
      ->with($name, 'dev');
    $client->expects($this->once())
      ->method('getTasks')
      ->with($name);
    $client->expects($this->once())
      ->method('getTask')
      ->with($name, 11201);
    // Invoke methods for expectations.
    $site = new Site($client, $title, $name, $production_mode, $unix_username, $vcs_type, $vcs_url);
    $site->getEnvs();
    $site->getEnv('dev');
    $site->getTasks();
    $site->getTask(11201);
  }

  /**
   * @covers \Acquia\Cloud\Api\SDK\Envs\Envs::getServers
   * @covers \Acquia\Cloud\Api\SDK\Envs\Envs::getServer
   * @covers \Acquia\Cloud\Api\SDK\Envs\Envs::getLogStream
   */
  public function testEnv() {
    // Setup Environment value object requirements.
    $site_id = 'devcloud:test0';
    $name = 'dev';
    $vcs_path = 'master';
    $ssh_host = 'myfakeunittestsite.devcloud.hosting.acquia.com';
    $db_clusters = [1111];
    $default_domain = 'myfakeunittestsite.devcloud.hosting.acquia.com';
    $livedev = 'disabled';
    $client = $this->getMockBuilder('\Acquia\Cloud\Api\ClientInterface')
      ->getMock();
    $client->expects($this->once())
      ->method('getServers')
      ->with($site_id, $name);
    $client->expects($this->once())
      ->method('getServer')
      ->with($site_id, $name, 'myfakeunittestserver');
    $client->expects($this->once())
      ->method('getLogStream')
      ->with($site_id, $name);
    $env = new Environment($client, $site_id, $name, $vcs_path, $ssh_host, $db_clusters, $default_domain, $livedev);
    $env->getServers();
    $env->getServer('myfakeunittestserver');
    $env->getLogStream();
  }

}
 