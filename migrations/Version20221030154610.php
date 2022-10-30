<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030154610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création entité CardSerie';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_serie (id INT AUTO_INCREMENT NOT NULL, serie_name VARCHAR(45) NOT NULL, serie_link VARCHAR(45) NOT NULL, serie_img VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_set ADD card_serie_id INT NOT NULL');
        $this->addSql('ALTER TABLE card_set ADD CONSTRAINT FK_B6E4A11D6072463E FOREIGN KEY (card_serie_id) REFERENCES card_serie (id)');
        $this->addSql('CREATE INDEX IDX_B6E4A11D6072463E ON card_set (card_serie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_set DROP FOREIGN KEY FK_B6E4A11D6072463E');
        $this->addSql('DROP TABLE card_serie');
        $this->addSql('DROP INDEX IDX_B6E4A11D6072463E ON card_set');
        $this->addSql('ALTER TABLE card_set DROP card_serie_id');
    }
}
