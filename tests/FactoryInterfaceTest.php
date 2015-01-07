<?php
/**
 * @file
 * Contains FactoryInterfaceTest.php.
 */

namespace Acquia\Cloud\Api\Tests;


use Acquia\Cloud\Api\Client;
use Acquia\Cloud\Api\SDK\Envs\Envs;
use Acquia\Cloud\Api\SDK\Site;
use Acquia\Cloud\Api\SDK\Sites;

class FactoryInterfaceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \Acquia\Cloud\Api\Client::getSites
   * @covers \Acquia\Cloud\Api\Client::getAliases
   */
  public function testClient() {
    $factory = $this->getMockBuilder('\Acquia\Cloud\Api\ObjectFactoryInterface')
      ->getMock();
    $factory->expects($this->once())
      ->method('getSites');
    $factory->expects($this->once())
      ->method('getAliases');
    $client = new Client($factory);
    $client->getSites();
    $client->getAliases();
  }

  /**
   * @covers \Acquia\Cloud\Api\SDK\Sites::offsetGet
   */
  public function testSites() {
    $factory = $this->getMockBuilder('\Acquia\Cloud\Api\ObjectFactoryInterface')
      ->getMock();
    $factory->expects($this->exactly(2))
      ->method('getSite')
      ->withConsecutive(
        $this->equalTo('dev:test1'),
        $this->equalTo('dev:test2')
      );
    $sites = new Sites($factory, ['dev:test1', 'dev:test2']);
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
    $factory = $this->getMockBuilder('\Acquia\Cloud\Api\ObjectFactoryInterface')
      ->getMock();
    $factory->expects($this->once())
      ->method('getEnvs')
      ->with($name);
    $factory->expects($this->once())
      ->method('getEnv')
      ->with($name, 'dev');
    $factory->expects($this->once())
      ->method('getTasks')
      ->with($name);
    $factory->expects($this->once())
      ->method('getTask')
      ->with($name, 11201);
    // Invoke methods for expectations.
    $site = new Site($factory, $title, $name, $production_mode, $unix_username, $vcs_type, $vcs_url);
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
    // Setup Envs value object requirements.
    $site_id = 'devcloud:test0';
    $name = 'dev';
    $vcs_path = 'master';
    $ssh_host = 'myfakeunittestsite.devcloud.hosting.acquia.com';
    $db_clusters = [1111];
    $default_domain = 'myfakeunittestsite.devcloud.hosting.acquia.com';
    $livedev = 'disabled';
    $factory = $this->getMockBuilder('\Acquia\Cloud\Api\ObjectFactoryInterface')
      ->getMock();
    $factory->expects($this->once())
      ->method('getServers')
      ->with($site_id, $name);
    $factory->expects($this->once())
      ->method('getServer')
      ->with($site_id, $name, 'myfakeunittestserver');
    $factory->expects($this->once())
      ->method('getLogStream')
      ->with($site_id, $name);
    $env = new Envs($factory, $site_id, $name, $vcs_path, $ssh_host, $db_clusters, $default_domain, $livedev);
    $env->getServers();
    $env->getServer('myfakeunittestserver');
    $env->getLogStream();
  }

}
 