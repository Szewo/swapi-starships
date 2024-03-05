<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240305003617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create starship table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE starship (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, starship_class VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) NOT NULL, cost_in_credits VARCHAR(255) NOT NULL, length VARCHAR(255) NOT NULL, crew VARCHAR(255) NOT NULL, passengers VARCHAR(255) NOT NULL, max_atmosphering_speed VARCHAR(255) NOT NULL, hyperdrive_rating DOUBLE PRECISION NOT NULL, mglt VARCHAR(255) NOT NULL, cargo_capacity VARCHAR(255) NOT NULL, consumables VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE starship');
    }
}
