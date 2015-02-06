<?php
/**
 * @file
 * Contains FactoryInterfaceTest.php.
 */

namespace Acquia\Platform\Cloud\Tests;

use Acquia\Platform\Cloud\Hosting\Environment\Environment;
use Acquia\Platform\Cloud\Hosting\Site\Site;
use Acquia\Platform\Cloud\Hosting\Site\Sites;

class FactoryInterfaceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @covers \Acquia\Platform\Cloud\Hosting\Api\Client::getSites
   * @covers \Acquia\Platform\Cloud\Hosting\Api\Client::getAliases
   */
  public function testClient() {
    /** @var $dataSource \Acquia\Platform\Cloud\Hosting\DataInterface */
    $dataSource = $this->getMockBuilder('\Acquia\Platform\Cloud\Hosting\DataInterface')
      ->getMock();
    $dataSource->expects($this->once())
      ->method('getSites');
    $dataSource->expects($this->once())
      ->method('getAliases');
    $dataSource->getSites();
    $dataSource->getAliases();
  }

  /**
   * @covers \Acquia\Platform\Cloud\Hosting\Sites\Sites::offsetGet
   */
  public function testSites() {
    $dataSource = $this->getMockBuilder('\Acquia\Platform\Cloud\Hosting\DataInterface')
      ->getMock();
    $dataSource->expects($this->exactly(2))
      ->method('getSite')
      ->withConsecutive(
        $this->equalTo('dev:test1'),
        $this->equalTo('dev:test2')
      );
    $sites = new Sites($dataSource, ['dev:test1', 'dev:test2']);
    $sites[0];
    $sites[1];
  }

  /**
   * @covers \Acquia\Platform\Cloud\Hosting\Site\Site::getEnvs
   * @covers \Acquia\Platform\Cloud\Hosting\Site\Site::getEnv
   * @covers \Acquia\Platform\Cloud\Hosting\Site\Site::getTasks
   * @covers \Acquia\Platform\Cloud\Hosting\Site\Site::getTask
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
    $dataSource = $this->getMockBuilder('\Acquia\Platform\Cloud\Hosting\DataInterface')
      ->getMock();
    $dataSource->expects($this->once())
      ->method('getEnvs')
      ->with($name);
    $dataSource->expects($this->once())
      ->method('getEnv')
      ->with($name, 'dev');
    $dataSource->expects($this->once())
      ->method('getTasks')
      ->with($name);
    $dataSource->expects($this->once())
      ->method('getTask')
      ->with($name, 11201);
    // Invoke methods for expectations.
    $site = new Site($dataSource, $title, $name, $production_mode, $unix_username, $vcs_type, $vcs_url);
    $site->getEnvs();
    $site->getEnv('dev');
    $site->getTasks();
    $site->getTask(11201);
  }

  /**
   * @covers \Acquia\Platform\Cloud\Hosting\Envs\Envs::getServers
   * @covers \Acquia\Platform\Cloud\Hosting\Envs\Envs::getServer
   * @covers \Acquia\Platform\Cloud\Hosting\Envs\Envs::getLogStream
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
    $dataSource = $this->getMockBuilder('\Acquia\Platform\Cloud\Hosting\DataInterface')
      ->getMock();
    $dataSource->expects($this->once())
      ->method('getServers')
      ->with($site_id, $name);
    $dataSource->expects($this->once())
      ->method('getServer')
      ->with($site_id, $name, 'myfakeunittestserver');
    $dataSource->expects($this->once())
      ->method('getLogStream')
      ->with($site_id, $name);
    $env = new Environment($dataSource, $site_id, $name, $vcs_path, $ssh_host, $db_clusters, $default_domain, $livedev);
    $env->getServers();
    $env->getServer('myfakeunittestserver');
    $env->getLogStream();
  }

}
 