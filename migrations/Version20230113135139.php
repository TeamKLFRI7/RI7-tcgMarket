<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230113135139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_user ADD fk_id_game_id INT NOT NULL');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EBCA7CBAE6 FOREIGN KEY (fk_id_game_id) REFERENCES game (id)');
        $this->addSql('CREATE INDEX IDX_61A0D4EBCA7CBAE6 ON card_user (fk_id_game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP is_active');
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EBCA7CBAE6');
        $this->addSql('DROP INDEX IDX_61A0D4EBCA7CBAE6 ON card_user');
    }
}
