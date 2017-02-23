<?php

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'charset'  => 'utf8',
    'host'     => 'localhost',
    'port'     => '3306',
    'dbname'   => 'jeanforteroche',
    'user'     => 'root',
    'password' => '',
);

$app['monolog.level'] = 'WARNING';