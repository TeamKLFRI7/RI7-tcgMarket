<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030155922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE games (id INT AUTO_INCREMENT NOT NULL, names VARCHAR(45) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_serie ADD games_id INT NOT NULL');
        $this->addSql('ALTER TABLE card_serie ADD CONSTRAINT FK_920E62F297FFC673 FOREIGN KEY (games_id) REFERENCES games (id)');
        $this->addSql('CREATE INDEX IDX_920E62F297FFC673 ON card_serie (games_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_serie DROP FOREIGN KEY FK_920E62F297FFC673');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP INDEX IDX_920E62F297FFC673 ON card_serie');
        $this->addSql('ALTER TABLE card_serie DROP games_id');
    }
}
