<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030151701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création entité CardUser';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card_user (id INT AUTO_INCREMENT NOT NULL, fk_id_user_id INT NOT NULL, name VARCHAR(45) NOT NULL, quality VARCHAR(45) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, img VARCHAR(45) NOT NULL, INDEX IDX_61A0D4EB899DB076 (fk_id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EB899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EB899DB076');
        $this->addSql('DROP TABLE card_user');
    }
}
