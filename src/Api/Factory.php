<?php
/**
 * @file
 * Contains Factory.php.
 */

namespace Acquia\Platform\Cloud\Api;

class Factory implements FactoryInterface {

  protected $objectTypes = array(
    'sites' => '\Acquia\Platform\Cloud\Api\SDK\Sites',
    'site' => '\Acquia\Platform\Cloud\Api\SDK\Site',
    'task' => '\Acquia\Platform\Cloud\Api\SDK\Task\Task',
    'envs' => '\Acquia\Platform\Cloud\Api\SDK\Environment\Environment',
    'server' => '\Acquia\Platform\Cloud\Api\SDK\Server\Server',
    'domain' => '\Acquia\Platform\Cloud\Api\SDK\Domain\Domain',
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
