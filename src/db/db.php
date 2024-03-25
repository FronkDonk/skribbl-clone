<?php

require_once "./vendor/autoload.php";

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__ . "/schemas"),
    isDevMode: true,
);


$connection = DriverManager::getConnection([
    'dbname' => "postgres",
    'user' => "postgres.wzqbaxbadiqwdodpcglt",
    "password" => "J%3!$qo6x#!S8o5Y@iJVTmt8BJ4G@TU97RyirUW29bamcUg@JDYrhod3$fBzXH6sKoQ8g3YRzmo&pnfR6bzzFD9yGJgxG8yZfq6",
    "host" => "aws-0-eu-central-1.pooler.supabase.com",
    "port" => 5432,
    "driver" => "pdo_pgsql",
], $config);

$entityManager = new EntityManager($connection, $config);
