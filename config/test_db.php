<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn'] = 'pgsql:host=' . getenv('POSTGRES_HOST') . ';dbname=' . getenv('POSTGRES_DB_NAME');

return $db;
