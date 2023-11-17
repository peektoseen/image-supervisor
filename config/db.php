<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=' . getenv('POSTGRES_HOST') . ';dbname=' . getenv('POSTGRES_DB_NAME'),
    'username' => getenv('POSTGRES_USER'),
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
