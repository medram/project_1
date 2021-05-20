<?php

require_once './vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\Configuration\Connection\ExistingConnection;
use Doctrine\Migrations\DependencyFactory;

// loading .env variables.
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->safeLoad();

$config = new PhpFile('application/migrations/migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders

$conn = DriverManager::getConnection([
    'dbname' => getenv('DB_NAME'),
    'user' => getenv('DB_USER'),
    'password' => getenv('DB_PASSWORD'),
    'host' => getenv('DB_HOSTNAME'),
    'driver' => 'pdo_mysql',
]);

return DependencyFactory::fromConnection($config, new ExistingConnection($conn));
