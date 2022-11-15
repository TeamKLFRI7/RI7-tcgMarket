<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030153131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création entité CataCard';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cata_card (id INT AUTO_INCREMENT NOT NULL, fk_id_card_id INT NOT NULL, api_card_id VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, img VARCHAR(45) NOT NULL, cata_card_link VARCHAR(45) NOT NULL, INDEX IDX_C93A3EF8643FF9C3 (fk_id_card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cata_card ADD CONSTRAINT FK_C93A3EF8643FF9C3 FOREIGN KEY (fk_id_card_id) REFERENCES card_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cata_card DROP FOREIGN KEY FK_C93A3EF8643FF9C3');
        $this->addSql('DROP TABLE cata_card');
    }
}
