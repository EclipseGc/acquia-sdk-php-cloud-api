<?php
/**
 * @file
 * Contains \Acquia\Cloud\Api\SDK\Task\Task.
 */

namespace Acquia\Cloud\Api\SDK\Task;

class Task implements TaskInterface {

  /**
   * @var int
   */
  protected $id;

  /**
   * @var string
   */
  protected $siteId;

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
   * @param string $site_id
   * @param $completed
   * @param $created
   * @param $description
   * @param $id
   * @param $logs
   * @param $queue
   * @param $result
   * @param $sender
   * @param $started
   * @param $state
   * @internal param int $task_id
   */
  public function __construct($site_id, $completed, $created, $description, $id, $logs, $queue, $result, $sender, $started, $state) {
    $this->siteId = $site_id;
    $this->completed = $completed;
    $this->created = $created;
    $this->description = $description;
    $this->id = $id;
    $this->logs = $logs;
    $this->queue = $queue;
    $this->result = $result;
    $this->sender = $sender;
    $this->started = $started;
    $this->state = $state;
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
   * @return string
   */
  public function getSiteId() {
    return $this->siteId;
  }

  /**
   * @return array
   */
  public function getData() {
    return [
      'completed' => $this->getCompleted(),
      'created' => $this->getCreated(),
      'description' => $this->getDescription(),
      'id' => $this->getId(),
      'logs' => $this->getLogs(),
      'queue' => $this->getQueue(),
      'result' => $this->getResult(),
      'sender' => $this->getSender(),
      'started' => $this->getStarted(),
      'state' => $this->getState(),
    ];
  }

  public static function getKeys() {
    return [
      'completed',
      'created',
      'description',
      'id',
      'logs',
      'queue',
      'result',
      'sender',
      'started',
      'state',
    ];
  }

}

