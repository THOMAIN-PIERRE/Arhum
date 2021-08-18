<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422153334 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE open_hours (id INT AUTO_INCREMENT NOT NULL, entitled VARCHAR(255) DEFAULT NULL, monday_am VARCHAR(255) DEFAULT NULL, monday_pm VARCHAR(255) DEFAULT NULL, tuesday_am VARCHAR(255) DEFAULT NULL, tuesday_pm VARCHAR(255) DEFAULT NULL, wednesday_am VARCHAR(255) DEFAULT NULL, wednesday_pm VARCHAR(255) DEFAULT NULL, thursday_am VARCHAR(255) DEFAULT NULL, thursday_pm VARCHAR(255) DEFAULT NULL, friday_am VARCHAR(255) DEFAULT NULL, friday_pm VARCHAR(255) DEFAULT NULL, saturday_am VARCHAR(255) DEFAULT NULL, saturday_pm VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE open_hours');
    }
}
