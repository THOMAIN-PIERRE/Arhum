<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422214436 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outlet_store ADD open_hours_id INT NOT NULL');
        $this->addSql('ALTER TABLE outlet_store ADD CONSTRAINT FK_AF12D35A77CF38C FOREIGN KEY (open_hours_id) REFERENCES open_hours (id)');
        $this->addSql('CREATE INDEX IDX_AF12D35A77CF38C ON outlet_store (open_hours_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE outlet_store DROP FOREIGN KEY FK_AF12D35A77CF38C');
        $this->addSql('DROP INDEX IDX_AF12D35A77CF38C ON outlet_store');
        $this->addSql('ALTER TABLE outlet_store DROP open_hours_id');
    }
}
