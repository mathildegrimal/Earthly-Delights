<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415133617 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attraction (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) DEFAULT NULL, image VARCHAR(255) NOT NULL, rate INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, user_has_many_bookings_id INT DEFAULT NULL, park_has_many_bookings_id INT DEFAULT NULL, date DATE NOT NULL, nb_of_seats INT NOT NULL, booking_ref VARCHAR(255) NOT NULL, total_booking_price DOUBLE PRECISION NOT NULL, begin_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, INDEX IDX_E00CEDDE2E7F97AF (user_has_many_bookings_id), INDEX IDX_E00CEDDEA64EE80B (park_has_many_bookings_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE park (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, capacity INT NOT NULL, entry_price DOUBLE PRECISION NOT NULL, total_income DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, attraction_id INT DEFAULT NULL, rate INT DEFAULT NULL, INDEX IDX_DFEC3F393C216F9D (attraction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, age INT NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE2E7F97AF FOREIGN KEY (user_has_many_bookings_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEA64EE80B FOREIGN KEY (park_has_many_bookings_id) REFERENCES park (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F393C216F9D FOREIGN KEY (attraction_id) REFERENCES attraction (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F393C216F9D');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEA64EE80B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE2E7F97AF');
        $this->addSql('DROP TABLE attraction');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE park');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE user');
    }
}
