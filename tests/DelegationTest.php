<?php
/**
 * @file
 * Contains Acquia\Platform\Cloud\Tests\DelegationTest
 */

namespace Acquia\Platform\Cloud\Tests;

use Acquia\Platform\Cloud\Hosting\Api\Client;
use Acquia\Platform\Cloud\Hosting\DataSourceDelegator;
use Acquia\Platform\Cloud\Hosting\Factory;


class DelegationTest extends \PHPUnit_Framework_TestCase
{
    protected function getFullDataSource($delegator, $fullDelegate = null)
    {
        if (!$fullDelegate) {
            $fullDelegate = new GuzzleTestClient();
        }
        return new Client($fullDelegate, new Factory(), $delegator);
    }

    protected function getPartialDataSource($delegator, $partialDelegate = null)
    {
        if (!$partialDelegate) {
            $partialDelegate = new PartialDataSourceClient();
        }
        return new Client($partialDelegate, new Factory(), $delegator);
    }

    public function testSites() {
        $guzzle = new GuzzleTestClient();
        $delegator = new DataSourceDelegator();
        $delegator->addDataSource($this->getPartialDataSource($delegator));
        $delegator->addDataSource($this->getFullDataSource($delegator, $guzzle));
        $return = $guzzle->get('sites.json')->json();
        $this->assertEquals($return, $delegator->getSites()->getData());
    }

    public function testSite() {
        $guzzle = new GuzzleTestClient();
        $delegator = new DataSourceDelegator();
        $delegator->addDataSource($this->getPartialDataSource($delegator));
        $delegator->addDataSource($this->getFullDataSource($delegator, $guzzle));
        $return = $guzzle->get('sites/{site}.json')->json();
        $site = $delegator->getSites()[0];
        $this->assertEquals($return, $site->getData());
        $this->assertEquals($return['title'], $site->getTitle());
        $this->assertEquals($return['name'], $site->getName());
        $this->assertEquals($return['production_mode'], $site->getProductionMode());
        $this->assertEquals($return['unix_username'], $site->getUnixUsername());
        $this->assertEquals($return['vcs_type'], $site->getVcsType());
        $this->assertEquals($return['vcs_url'], $site->getVcsUrl());
    }

    public function testTasks() {
        $guzzle = new GuzzleTestClient();
        $delegator = new DataSourceDelegator();
        $delegator->addDataSource($this->getPartialDataSource($delegator));
        $delegator->addDataSource($this->getFullDataSource($delegator, $guzzle));
        $return = $guzzle->get('sites/{site}/tasks.json')->json();
        $tasks = $delegator->getSites()[0]->getTasks();
        $tasks_data = [];
        foreach ($tasks as $id => $task) {
            $tasks_data[$id] = $task->getData();
        }
        $this->assertEquals($return, $tasks_data);
    }

    public function testTask() {
        $guzzle = new GuzzleTestClient();
        $delegator = new DataSourceDelegator();
        $delegator->addDataSource($this->getPartialDataSource($delegator));
        $delegator->addDataSource($this->getFullDataSource($delegator, $guzzle));
        $return = $guzzle->get('sites/{site}/tasks/{task}.json')->json();
        $task = $delegator->getSites()[0]->getTask(1);
        $this->assertEquals($return, $task->getData());
        $this->assertEquals($return['id'], $task->getId());
        $this->assertEquals($return['completed'], $task->getCompleted());
        $this->assertEquals($return['created'], $task->getCreated());
        $this->assertEquals($return['description'], $task->getDescription());
        $this->assertEquals($return['logs'], $task->getLogs());
        $this->assertEquals($return['queue'], $task->getQueue());
        $this->assertEquals($return['result'], $task->getResult());
        $this->assertEquals($return['sender'], $task->getSender());
        $this->assertEquals($return['started'], $task->getStarted());
        $this->assertEquals('devcloud:test0', $task->getSiteId());
    }

    public function testEnvs() {
        $guzzle = new GuzzleTestClient();
        $delegator = new DataSourceDelegator();
        $delegator->addDataSource($this->getPartialDataSource($delegator));
        $delegator->addDataSource($this->getFullDataSource($delegator, $guzzle));
        $return = $guzzle->get('sites/{site}/envs.json')->json();
        $envs = $delegator->getSites()[0]->getEnvs();
        $envs_data = [];
        foreach ($envs as $key => $env) {
            $envs_data[$key] = $env->getData();
        }
        $this->assertEquals($return, $envs_data);
    }

    public function testEnv() {
        $guzzle = new GuzzleTestClient();
        $delegator = new DataSourceDelegator();
        $delegator->addDataSource($this->getPartialDataSource($delegator));
        $delegator->addDataSource($this->getFullDataSource($delegator, $guzzle));
        $return = $guzzle->get('sites/{site}/envs/{env}.json')->json();
        $env = $delegator->getSites()[0]->getEnv('test');
        $this->assertEquals($return, $env->getData());
        $this->assertEquals($return['name'], $env->getName());
        $this->assertEquals($return['vcs_path'], $env->getVcsPath());
        $this->assertEquals($return['ssh_host'], $env->getSshHost());
        $this->assertEquals($return['db_clusters'], $env->getDbClusters());
        $this->assertEquals($return['default_domain'], $env->getDefaultDomain());
        $this->assertEquals($return['livedev'], $env->getLivedev());
        $this->assertEquals('devcloud:test0', $env->getSiteId());
        //$this->assertEquals($return, $env->getLogStream());
    }
}