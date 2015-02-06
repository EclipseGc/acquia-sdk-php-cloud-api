<?php
/**
 * @file
 * Contains Factory.php.
 */

namespace Acquia\Platform\Cloud\Hosting;

use Acquia\Platform\Cloud\Common\FactoryInterface;

class Factory implements FactoryInterface {

  protected $objectTypes = array(
    'sites' => '\Acquia\Platform\Cloud\Hosting\Site\Sites',
    'site' => '\Acquia\Platform\Cloud\Hosting\Site\Site',
    'task' => '\Acquia\Platform\Cloud\Hosting\Task\Task',
    'envs' => '\Acquia\Platform\Cloud\Hosting\Environment\Environment',
    'server' => '\Acquia\Platform\Cloud\Hosting\Server\Server',
    'domain' => '\Acquia\Platform\Cloud\Hosting\Domain\Domain',
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
