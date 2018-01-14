<?php

use Doctrine\DBAL\Driver\PDOMySql\Driver;

return [
    'doctrine' => [
        'connection' => [
            // default connection name
            'orm_default' => [
                'driverClass' => Driver::class,
                'params' => [
                    'host'     => 'database',
                    'port'     => '3306',
                    'user'     => 'demo',
                    'password' => 'demo',
                    'dbname'   => 'demo'
                ],
            ],
        ],
    ],
];
