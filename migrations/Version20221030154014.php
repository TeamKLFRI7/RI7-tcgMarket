<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030154014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création entité CardSet';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_set (id INT AUTO_INCREMENT NOT NULL, api_set_id VARCHAR(45) NOT NULL, set_name VARCHAR(45) NOT NULL, set_link VARCHAR(45) NOT NULL, set_img VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_user ADD card_set_id INT NOT NULL');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EB62C45E6C FOREIGN KEY (card_set_id) REFERENCES card_set (id)');
        $this->addSql('CREATE INDEX IDX_61A0D4EB62C45E6C ON card_user (card_set_id)');
        $this->addSql('ALTER TABLE cata_card ADD card_set_id INT NOT NULL, CHANGE api_card_id api_card_id INT NOT NULL');
        $this->addSql('ALTER TABLE cata_card ADD CONSTRAINT FK_C93A3EF862C45E6C FOREIGN KEY (card_set_id) REFERENCES card_set (id)');
        $this->addSql('CREATE INDEX IDX_C93A3EF862C45E6C ON cata_card (card_set_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EB62C45E6C');
        $this->addSql('ALTER TABLE cata_card DROP FOREIGN KEY FK_C93A3EF862C45E6C');
        $this->addSql('DROP TABLE card_set');
        $this->addSql('DROP INDEX IDX_61A0D4EB62C45E6C ON card_user');
        $this->addSql('ALTER TABLE card_user DROP card_set_id');
        $this->addSql('DROP INDEX IDX_C93A3EF862C45E6C ON cata_card');
        $this->addSql('ALTER TABLE cata_card DROP card_set_id, CHANGE api_card_id api_card_id VARCHAR(45) NOT NULL');
    }
}
