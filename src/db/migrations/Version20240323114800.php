<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\Types;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323114800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $products = $schema->createTable("products");

        $products->addColumn("id", Types::INTEGER)->setAutoincrement(true);
        $products->addColumn("name", Types::STRING, ["length" => 100]);
        $products->addColumn("description", Types::STRING, ["length" => 255]);
        $products->addColumn("price", Types::DECIMAL, ["scale" => 2, "precision" => 10]);

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
