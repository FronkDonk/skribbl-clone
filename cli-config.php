<?php

require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\DBAL\DriverManager;

$config = new PhpFile('migrations.php'); 

$paths = [__DIR__ . '/src/db/schemas'];
$isDevMode = true;

$ORMConfig = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);

$connection = DriverManager::getConnection([
    'dbname' => "railway",
    'user' => "root",
    "password" => "NAwVfObZhEAdboaFRqZWjOcHenJZXVHK",
    "host" => "viaduct.proxy.rlwy.net",
    "port" => 48830,
    "driver" => "pdo_mysql",
]);

$entityManager = new EntityManager($connection, $ORMConfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));