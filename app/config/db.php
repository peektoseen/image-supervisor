<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'postgresql:host=postgres;dbname=yii2basic',
    'username' => env('DB_USER'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
