<?php

namespace Doctrine\DBAL;

use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Driver\Middleware;
use Doctrine\DBAL\Logging\SQLLogger;

/**
 * Configuration container for the Doctrine DBAL.
 *
 * @internal
 */
class Configuration
{
    /** @var Middleware[] */
    private $middlewares = [];

    /**
     * The attributes that are contained in the configuration.
     * Values are default values.
     *
     * @var mixed[]
     */
    protected $_attributes = [];

    /**
     * Sets the SQL logger to use. Defaults to NULL which means SQL logging is disabled.
     *
     * @return void
     */
    public function setSQLLogger(?SQLLogger $logger = null)
    {
        $this->_attributes['sqlLogger'] = $logger;
    }

    /**
     * Gets the SQL logger that is used.
     *
     * @return SQLLogger|null
     */
    public function getSQLLogger()
    {
        return $this->_attributes['sqlLogger'] ?? null;
    }

    /**
     * Gets the cache driver implementation that is used for query result caching.
     *
     * @return Cache|null
     */
    public function getResultCacheImpl()
    {
        return $this->_attributes['resultCacheImpl'] ?? null;
    }

    /**
     * Sets the cache driver implementation that is used for query result caching.
     *
     * @return void
     */
    public function setResultCacheImpl(Cache $cacheImpl)
    {
        $this->_attributes['resultCacheImpl'] = $cacheImpl;
    }

    /**
     * Sets the callable to use to filter schema assets.
     */
    public function setSchemaAssetsFilter(?callable $callable = null): ?callable
    {
        $this->_attributes['filterSchemaAssetsExpression'] = null;

        return $this->_attributes['filterSchemaAssetsExpressionCallable'] = $callable;
    }

    /**
     * Returns the callable to use to filter schema assets.
     */
    public function getSchemaAssetsFilter(): ?callable
    {
        return $this->_attributes['filterSchemaAssetsExpressionCallable'] ?? null;
    }

    /**
     * Sets the default auto-commit mode for connections.
     *
     * If a connection is in auto-commit mode, then all its SQL statements will be executed and committed as individual
     * transactions. Otherwise, its SQL statements are grouped into transactions that are terminated by a call to either
     * the method commit or the method rollback. By default, new connections are in auto-commit mode.
     *
     * @see   getAutoCommit
     *
     * @param bool $autoCommit True to enable auto-commit mode; false to disable it.
     *
     * @return void
     */
    public function setAutoCommit($autoCommit)
    {
        $this->_attributes['autoCommit'] = (bool) $autoCommit;
    }

    /**
     * Returns the default auto-commit mode for connections.
     *
     * @see    setAutoCommit
     *
     * @return bool True if auto-commit mode is enabled by default for connections, false otherwise.
     */
    public function getAutoCommit()
    {
        return $this->_attributes['autoCommit'] ?? true;
    }

    /**
     * @param Middleware[] $middlewares
     *
     * @return $this
     */
    public function setMiddlewares(array $middlewares): self
    {
        $this->middlewares = $middlewares;

        return $this;
    }

    /**
     * @return Middleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}
