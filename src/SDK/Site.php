<?php
/**
 * @file
 * Contains Site.php.
 */

namespace Acquia\Cloud\Api\SDK;

use Acquia\Cloud\Api\ObjectFactoryInterface;

class Site implements SiteInterface {

  /**
   * @var \Acquia\Cloud\Api\ObjectFactoryInterface
   */
  protected $factory;

  /**
   * @var string
   */
  protected $title;

  /**
   * @var string
   */
  protected $name;

  /**
   * @var int
   */
  protected $productionMode;

  /**
   * @var string
   */
  protected $unixUsername;

  /**
   * @var string
   */
  protected $vcsType;

  /**
   * @var string
   */
  protected $vcsUrl;

  function __construct(ObjectFactoryInterface $factory, $title, $name, $production_mode, $unix_username, $vcs_type, $vcs_url) {
    $this->factory = $factory;
    $this->title = $title;
    $this->name = $name;
    $this->productionMode = $production_mode;
    $this->unixUsername = $unix_username;
    $this->vcsType = $vcs_type;
    $this->vcsUrl = $vcs_url;
  }

  public static function getDefaults() {
    return [
      'title',
      'name',
      'production_mode',
      'unix_username',
      'vcs_type',
      'vcs_url',
    ];
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return int
   */
  public function getProductionMode() {
    return $this->productionMode;
  }

  /**
   * @return string
   */
  public function getTitle() {
    return $this->title;
  }

  /**
   * @return string
   */
  public function getUnixUsername() {
    return $this->unixUsername;
  }

  /**
   * @return string
   */
  public function getVcsType() {
    return $this->vcsType;
  }

  /**
   * @return string
   */
  public function getVcsUrl() {
    return $this->vcsUrl;
  }

  /**
   * {@inheritdoc}
   */
  public function getTasks() {
    return $this->factory->getTasks($this->getName());
  }

  public function getTask($id) {
    return $this->factory->getTask($this->getName(), $id);
  }

  public function getEnvs() {
    return $this->factory->getEnvs($this->getName());
  }

  public function getEnv($env) {
    return $this->factory->getEnv($this->getName(), $env);
  }

}
