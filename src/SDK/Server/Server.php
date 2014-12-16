<?php
/**
 * @file
 * Contains Server.php.
 */

namespace Acquia\Cloud\Api\SDK\Server;


use Acquia\Cloud\Api\SDK\RequestTrait;
use GuzzleHttp\Client;

class Server implements ServerInterface {

  use RequestTrait;

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

  function __construct($server, $env, $site_id, Client $client, array $data = []) {
    $this->name = $server;
    $this->env = $env;
    $this->siteId = $site_id;
    $this->client($client);
    if (array_diff_key(array_values($this->defaults), $data)) {
      $data = $this->request(['sites/{site}/envs/{env}/servers/{server}.json', ['site' => $site_id, 'env' => $env, 'server' => $server]])->json();
    }
    $this->fqdn = $data['fqdn'];
    $this->services = $data['services'];
    // @todo status is documented but doesn't appear available in the api.
    //$this->status = $data['status'];
    $this->amiTtype = $data['ami_type'];
    $this->ec2Region = $data['ec2_region'];
    $this->ec2AvailabilityZone = $data['ec2_availability_zone'];
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


} 