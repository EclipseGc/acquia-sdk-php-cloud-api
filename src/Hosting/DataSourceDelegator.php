<?php

/**
 * @file
 * Contains \Acquia\Platform\Cloud\Hosting\DataSourceDelegator.
 *
 * Based on code originally distributed inside the Acquia Support ToolsBundle
 * Copyright (c) 2014-2015 Acquia, Inc.
 */

namespace Acquia\Platform\Cloud\Hosting;

/**
 * Integrates with cloud hosting data via one or more data sources.
 */
class DataSourceDelegator implements DataSourceInterface
{
    protected $dataSources = array();
    protected $dataSourceCount = 0;

    /**
     * Delegate methods to the data source implementation(s).
     *
     * Iterate through available data sources until a valid result is received.
     * A \RuntimeException is thrown if no data source provides the method.
     *
     * @param string $name A DataSourceInterface method name
     * @param array|null $arguments An array of method arguments, or null.
     *
     * @return mixed|null
     *
     * @throws \RuntimeException
     */
    protected function delegate($name, $arguments)
    {
        $result = null;
        $exceptions = array();
        $dataSources = array_values($this->dataSources);
        foreach ($dataSources as $dataSource) {
            $class = get_class($dataSource);
            try {
                if (method_exists($dataSource, $name)) {
                    $result = call_user_func_array(
                        array($dataSource, $name),
                        $arguments
                    );
                } else {
                    throw new \RuntimeException("No such method '{$name}'.");
                }
            } catch (\RuntimeException $exception) {
                $exceptions[$class] = $exception;
                continue;
            }
            break;
        }
        if (count($exceptions) >= count($dataSources)) {
            $error = "No successful delegate found for method '{$name}'. Exceptions caught:\n";
            /**
             * @var string $sourceName
             * @var \RuntimeException $exception
             */
            foreach ($exceptions as $sourceName => $exception) {
                $error .= sprintf(" * %s: %s\n", $sourceName, $exception->getMessage());
            }
            throw new \RuntimeException($error);
        }

        return $result;
    }

    /**
     * Adds a Data Source implementation
     *
     * @param DataSourceInterface $dataSource An Acquia Cloud hosting data source.
     * @param int $weight Controls the order data sources are attempted in.
     *
     * @throws \InvalidArgumentException
     */
    public function addDataSource(DataSourceInterface $dataSource, $weight = 0)
    {
        if (!is_integer($weight)) {
            throw new \InvalidArgumentException("Weight must be an integer.");
        }

        $index = ($weight * 10) + $this->dataSourceCount;
        $this->dataSources[$index] = $dataSource;
        ksort($this->dataSources, SORT_NUMERIC);
        $this->dataSourceCount++;
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createDomain($site_id, $env, $domain)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getSites()
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteDomain($site_id, $env, $domain)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getLogStream($site_id, $name)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function disableLiveDev($site_id, $name)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getPhpProcs($site_id, $env, $server)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getTasks($site_id)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function purgeDomainCache($site_id, $env, $domain)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getTask($site_id, $task_id)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getDomain($site_id, $env, $domain)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getServers($site_id, $env)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getDomains($site_id, $env)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function enableLiveDev($site_id, $name)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getServer($site_id, $env, $server)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getSite($site_id)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getEnvs($site_id)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getEnv($site_id, $name)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function install($site_id, $env, $type, $source)
    {
        return $this->delegate(__FUNCTION__, func_get_args());
    }
}
