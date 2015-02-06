<?php
/**
 * @file
 * Contains Server.php.
 */

namespace Acquia\Platform\Cloud\Hosting\Server;


use Acquia\Platform\Cloud\Hosting\DataInterface;

class Server implements ServerInterface {

  /**
   * @var \Acquia\Platform\Cloud\Hosting\DataInterface
   */
  protected $dataSource;

  /**
   * The server name.
   *
   * @var string
   */
  protected $name;

  /**
   * The environment name.
   *
   * @var string
   */
  protected $env;

  /**
   * The site identifier.
   *
   * @var string
   */
  protected $siteId;

  /**
   * The fully qualified domain name of this server.
   *
   * @var string
   */
  protected $fqdn;

  /**
   * The services this server supports.
   *
   * @var array
   */
  protected $services;

  /**
   * The status of this server.
   *
   * @var string
   */
  protected $status;

  /**
   * The Amazon Machine Image type.
   *
   * @var string
   */
  protected $amiType;

  /**
   * The Amazon EC2 region of this server.
   *
   * @var string
   */
  protected $ec2Region;

  /**
   * The Amazon EC2 availaibility zone of this server.
   *
   * @var string
   */
  protected $ec2AvailabilityZone;

  protected $defaults = array(
    'name',
    'fqdn',
    'services',
    //'status',
    'ami_type',
    'ec2_region',
    'ec2_availability_zone',
  );

  function __construct(DataInterface $dataSource, $site_id, $env, $name, $fqdn, $services, $ami_type, $ec2_region, $ec2_availability_zone) {
    $this->dataSource = $dataSource;
    $this->siteId = $site_id;
    $this->env = $env;
    $this->name = $name;
    $this->fqdn = $fqdn;
    $this->services = $services;
    // @todo status is documented but doesn't appear available in the api.
    //$this->status = $data['status'];
    $this->amiType = $ami_type;
    $this->ec2Region = $ec2_region;
    $this->ec2AvailabilityZone = $ec2_availability_zone;
  }

  /**
   * @return string
   */
  public function getAmiType() {
    return $this->amiType;
  }

  /**
   * @return string
   */
  public function getEc2AvailabilityZone() {
    return $this->ec2AvailabilityZone;
  }

  /**
   * @return string
   */
  public function getEc2Region() {
    return $this->ec2Region;
  }

  /**
   * @return string
   */
  public function getEnv() {
    return $this->env;
  }

  /**
   * @return string
   */
  public function getFqdn() {
    return $this->fqdn;
  }

  /**
   * @return string
   */
  public function getName() {
    return $this->name;
  }

  /**
   * @return array
   */
  public function getServices() {
    return $this->services;
  }

  /**
   * @return string
   */
  public function getSiteId() {
    return $this->siteId;
  }

  /**
   * @return string
   */
  public function getStatus() {
    return $this->status;
  }

  public function getPhpProcs() {
    return $this->dataSource->getPhpProcs($this->getSiteId(), $this->getEnv(), $this->getName());
  }

  public function getData() {
    return [
      'name' => $this->getName(),
      'fqdn' => $this->getFqdn(),
      'services' => $this->getServices(),
      'status' => NULL,
      'ami_type' => $this->getAmiType(),
      'ec2_region' => $this->getEc2Region(),
      'ec2_availability_zone' => $this->getEc2AvailabilityZone(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function getKeys() {
    return [
      'name',
      'fqdn',
      'services',
      'status',
      'ami_type',
      'ec2_region',
      'ec2_availability_zone',
    ];
  }

} 