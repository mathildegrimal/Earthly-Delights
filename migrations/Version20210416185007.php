<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210416185007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attraction ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE attraction ADD CONSTRAINT FK_D503E6B812469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D503E6B812469DE2 ON attraction (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attraction DROP FOREIGN KEY FK_D503E6B812469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_D503E6B812469DE2 ON attraction');
        $this->addSql('ALTER TABLE attraction DROP category_id');
    }
}
