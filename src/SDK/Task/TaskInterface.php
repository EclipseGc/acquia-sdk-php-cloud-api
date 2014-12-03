<?php
/**
 * @file
 * Contains \Acquia\Cloud\Api\SDK\Task\TaskInterface.
 */

namespace Acquia\Cloud\Api\SDK\Task;


interface TaskInterface {

  /**
   * @return int
   */
  public function getCompleted();

  /**
   * @return int
   */
  public function getCreated();

  /**
   * @return string
   */
  public function getDescription();

  /**
   * @return int
   */
  public function getId();

  /**
   * @return string
   */
  public function getLogs();

  /**
   * @return string
   */
  public function getQueue();

  /**
   * @return mixed
   */
  public function getResult();

  /**
   * @return string
   */
  public function getSender();

  /**
   * @return int
   */
  public function getStarted();

  /**
   * @return string
   */
  public function getState();

  /**
   * @return int
   */
  public function getTaskId();

  /**
   * @return string
   */
  public function getSiteId();
} 