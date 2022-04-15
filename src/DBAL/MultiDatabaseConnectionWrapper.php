<?php

namespace App\DBAL;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;

final class MultiDatabaseConnectionWrapper extends Connection
{
    private array $params;
    private Driver $driver;
    private Configuration $config;
    private EventManager $eventManager;

    /**
     * @param array $params
     * @param Driver $driver
     * @param Configuration|null $config
     * @param EventManager|null $eventManager
     */
    public function __construct(
        array $params,
        Driver $driver,
        ?Configuration $config = null,
        ?EventManager $eventManager = null
    ) {
        parent::__construct($params, $driver, $config, $eventManager);
    }

    /**
     * @param string $dbName
     * @param string $user
     * @param string $pass
     * @param string $host
     * @param string $port
     * 
     * @return void
     */
    public function selectDatabase(
        string $dbName,
        string $user,
        string $pass,
        string $host,
        string $port
    ): void
    {
        if ($this->isConnected()) {
            $this->close();
        }

        $params = $this->getParams();
        $params['dbname'] = $dbName;
        $params['user'] = $user;
        $params['password'] = $pass;
        $params['host'] = $host;
        $params['port'] = $port;
        parent::__construct($params, $this->_driver, $this->_config, $this->_eventManager);
    }
}