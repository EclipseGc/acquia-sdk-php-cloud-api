<?php
/**
 * @file
 * Contains \Acquia\Platform\Cloud\Hosting\Task\TaskInterface.
 */

namespace Acquia\Platform\Cloud\Hosting\Task;


use Acquia\Platform\Cloud\Common\ObjectInterface;

interface TaskInterface extends ObjectInterface {

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
   * @return string
   */
  public function getSiteId();
} 