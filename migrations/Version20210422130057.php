<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422130057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE outlet_store (id INT AUTO_INCREMENT NOT NULL, main_picture VARCHAR(255) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, longitude DOUBLE PRECISION DEFAULT NULL, store_address VARCHAR(255) DEFAULT NULL, picture_one VARCHAR(255) DEFAULT NULL, picture_two VARCHAR(255) DEFAULT NULL, picture_three VARCHAR(255) DEFAULT NULL, picture_four VARCHAR(255) DEFAULT NULL, sales_area_description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE outlet_store');
    }
}
