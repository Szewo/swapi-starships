<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240305004324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change tables to nullable.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__starship AS SELECT id, name, model, starship_class, manufacturer, cost_in_credits, length, crew, passengers, max_atmosphering_speed, hyperdrive_rating, mglt, cargo_capacity, consumables FROM starship');
        $this->addSql('DROP TABLE starship');
        $this->addSql('CREATE TABLE starship (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, starship_class VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) DEFAULT NULL, cost_in_credits VARCHAR(255) NOT NULL, length VARCHAR(255) DEFAULT NULL, crew VARCHAR(255) NOT NULL, passengers VARCHAR(255) NOT NULL, max_atmosphering_speed VARCHAR(255) DEFAULT NULL, hyperdrive_rating DOUBLE PRECISION NOT NULL, mglt VARCHAR(255) DEFAULT NULL, cargo_capacity VARCHAR(255) DEFAULT NULL, consumables VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO starship (id, name, model, starship_class, manufacturer, cost_in_credits, length, crew, passengers, max_atmosphering_speed, hyperdrive_rating, mglt, cargo_capacity, consumables) SELECT id, name, model, starship_class, manufacturer, cost_in_credits, length, crew, passengers, max_atmosphering_speed, hyperdrive_rating, mglt, cargo_capacity, consumables FROM __temp__starship');
        $this->addSql('DROP TABLE __temp__starship');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__starship AS SELECT id, name, model, starship_class, manufacturer, cost_in_credits, length, crew, passengers, max_atmosphering_speed, hyperdrive_rating, mglt, cargo_capacity, consumables FROM starship');
        $this->addSql('DROP TABLE starship');
        $this->addSql('CREATE TABLE starship (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, starship_class VARCHAR(255) NOT NULL, manufacturer VARCHAR(255) NOT NULL, cost_in_credits VARCHAR(255) NOT NULL, length VARCHAR(255) NOT NULL, crew VARCHAR(255) NOT NULL, passengers VARCHAR(255) NOT NULL, max_atmosphering_speed VARCHAR(255) NOT NULL, hyperdrive_rating DOUBLE PRECISION NOT NULL, mglt VARCHAR(255) NOT NULL, cargo_capacity VARCHAR(255) NOT NULL, consumables VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO starship (id, name, model, starship_class, manufacturer, cost_in_credits, length, crew, passengers, max_atmosphering_speed, hyperdrive_rating, mglt, cargo_capacity, consumables) SELECT id, name, model, starship_class, manufacturer, cost_in_credits, length, crew, passengers, max_atmosphering_speed, hyperdrive_rating, mglt, cargo_capacity, consumables FROM __temp__starship');
        $this->addSql('DROP TABLE __temp__starship');
    }
}
