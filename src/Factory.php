<?php
/**
 * @file
 * Contains Factory.php.
 */

namespace Acquia\Cloud\Api;

class Factory implements FactoryInterface {

  protected $objectTypes = array(
    'sites' => '\Acquia\Cloud\Api\SDK\Sites',
    'site' => '\Acquia\Cloud\Api\SDK\Site',
    'task' => '\Acquia\Cloud\Api\SDK\Task\Task',
    'envs' => '\Acquia\Cloud\Api\SDK\Environment\Environment',
    'server' => '\Acquia\Cloud\Api\SDK\Server\Server',
    'domain' => '\Acquia\Cloud\Api\SDK\Domain\Domain',
  );

  public function getObjectTypeClass($type) {
    if (isset($this->objectTypes[$type])) {
      return $this->objectTypes[$type];
    }
    throw new \Exception(sprintf('No object type %s', $type));
  }

  public function createObjectType($type, array $data = []) {
    $objectClass = $this->getObjectTypeClass($type);
    $reflector = new \ReflectionClass($objectClass);
    if (!isset($data['factory'])) {
      $data['factory'] = $this;
    }
    $data += array_fill_keys($objectClass::getKeys(), NULL);
    $arguments = [];
    foreach ($reflector->getMethod('__construct')->getParameters() as $param) {
      $param_name = $param->getName();
      if (array_key_exists($param_name, $data)) {
        $arguments[] = $data[$param_name];
      }
    }
    return $reflector->newInstanceArgs($arguments);
  }

}
