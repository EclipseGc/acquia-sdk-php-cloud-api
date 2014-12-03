<?php
/**
 * @file
 * Contains \Acquia\Cloud\Api\SDK\Task\Task.
 */

namespace Acquia\Cloud\Api\SDK\Task;


use GuzzleHttp\Client;

class Task implements TaskInterface {

  /**
   * @var int
   */
  protected $taskId;

  /**
   * @var string
   */
  protected $siteId;

  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * A unix timestamp of the completed date of this task.
   *
   * @var int
   */
  protected $completed;

  /**
   * A unix timestamp of the creation date of this task.
   *
   * @var int
   */
  protected $created;

  /**
   * The description of this task.
   *
   * @var string
   */
  protected $description;

  /**
   * The unique identifier for this task.
   *
   * @var int
   */
  protected $id;

  /**
   * The log message associated with this task.
   *
   * @var string
   */
  protected $logs;

  /**
   * The queue into which this task was placed.
   *
   * @var string
   */
  protected $queue;

  /**
   * An array of result related data for this task.
   *
   * @var mixed null|array
   */
  protected $result;

  /**
   * The user responsible for the task.
   *
   * @var string
   */
  protected $sender;

  /**
   * A unix timestamp of the started date of this task.
   *
   * @var int
   */
  protected $started;

  /**
   * The current state of the task.
   *
   * @var string
   */
  protected $state;

  /**
   * The expected default keys in the $data parameter in the constructor.
   *
   * @var array
   */
  protected $defaults = array(
    'completed' => NULL,
    'created' => NULL,
    'description' => NULL,
    'id' => NULL,
    'logs' => NULL,
    'queue' => NULL,
    'result' => NULL,
    'sender' => NULL,
    'started' => NULL,
    'state' => NULL,
  );

  /**
   * @param int $task_id
   * @param string $site_id
   * @param \GuzzleHttp\Client $client
   * @param array $data
   */
  public function __construct($task_id, $site_id, Client $client, array $data = array()) {
    $this->taskId = $task_id;
    $this->siteId = $site_id;
    $this->client = $client;
    // If we're missing any of the expected data, get the data manually.
    if (array_diff_key($this->defaults, $data)) {
      $data = $this->client->get(['sites/{site}/tasks/{task}.json', ['site' => $site_id, 'task' => $task_id]])->json();
    }

    $this->completed = $data['completed'];
    $this->created = $data['created'];
    $this->description = $data['description'];
    $this->id = $data['id'];
    $this->logs = $data['logs'];
    $this->queue = $data['queue'];
    $this->result = $data['result'];
    $this->sender = $data['sender'];
    $this->started = $data['started'];
    $this->state = $data['state'];
  }

  /**
   * @return int
   */
  public function getCompleted() {
    return $this->completed;
  }

  /**
   * @return int
   */
  public function getCreated() {
    return $this->created;
  }

  /**
   * @return string
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * @return int
   */
  public function getId() {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getLogs() {
    return $this->logs;
  }

  /**
   * @return string
   */
  public function getQueue() {
    return $this->queue;
  }

  /**
   * @return mixed
   */
  public function getResult() {
    return $this->result;
  }

  /**
   * @return string
   */
  public function getSender() {
    return $this->sender;
  }

  /**
   * @return int
   */
  public function getStarted() {
    return $this->started;
  }

  /**
   * @return string
   */
  public function getState() {
    return $this->state;
  }

  /**
   * @return int
   */
  public function getTaskId() {
    return $this->taskId;
  }

  /**
   * @return string
   */
  public function getSiteId() {
    return $this->siteId;
  }

}

