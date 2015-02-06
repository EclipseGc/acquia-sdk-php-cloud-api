<?php
/**
 * @file
 * Contains Site.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Site;

use Acquia\Platform\Cloud\Hosting\DataSourceInterface;

class Site implements SiteInterface {

  /**
   * @var \Acquia\Platform\Cloud\Hosting\DataSourceInterface
   */
  protected $dataSource;

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

  function __construct(DataSourceInterface $dataSource, $title, $name, $production_mode, $unix_username, $vcs_type, $vcs_url) {
    $this->dataSource = $dataSource;
    $this->title = $title;
    $this->name = $name;
    $this->productionMode = $production_mode;
    $this->unixUsername = $unix_username;
    $this->vcsType = $vcs_type;
    $this->vcsUrl = $vcs_url;
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
    return $this->dataSource->getTasks($this->getName());
  }

  public function getTask($id) {
    return $this->dataSource->getTask($this->getName(), $id);
  }

  public function getEnvs() {
    return $this->dataSource->getEnvs($this->getName());
  }

  public function getEnv($env) {
    return $this->dataSource->getEnv($this->getName(), $env);
  }

  /**
   * {@inheritdoc}
   */
  public function getData() {
    return [
      'title' => $this->getTitle(),
      'name' => $this->getName(),
      'production_mode' => $this->getProductionMode(),
      'unix_username' => $this->getUnixUsername(),
      'vcs_type' => $this->getVcsType(),
      'vcs_url' => $this->getVcsUrl(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getKeys() {
    return [
      'title',
      'name',
      'production_mode',
      'unix_username',
      'vcs_type',
      'vcs_url',
    ];
  }

}
