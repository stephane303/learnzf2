<?php
return array(
    'db' => array(
        //The database driver. Mysqli, Sqlsrv, Pdo_Sqlite, Pdo_Mysql, Pdo=OtherPdoDriver
        'driver' => 'Mysqli',
        'database' => 'tc', // generally required the name of the database (schema)
        'username' => 'root', // generally required the connection username
        'password' => '', // generally required the connection password
//not generally required the IP address or hostname to connect to
        'hostname' => 'localhost',
// 'port' => 1234, // not generally required the port to connect to (if applicable)
        // 'charset' => 'utf8', // not generally required the character set to use
        'options' => array(
            'buffer_results' => 1
        )
    ),
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'tc',
                )
            )
        )
    )
);
