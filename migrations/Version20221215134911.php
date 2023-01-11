<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215134911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, user_name VARCHAR(100) NOT NULL, phone_number VARCHAR(15) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_user ADD fk_id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EB899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_61A0D4EB899DB076 ON card_user (fk_id_user_id)');
        $this->addSql('ALTER TABLE command ADD fk_id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD4899DB076 ON command (fk_id_user_id)');
        $this->addSql('ALTER TABLE user_info ADD fk_id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9E899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B1087D9E899DB076 ON user_info (fk_id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EB899DB076');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4899DB076');
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9E899DB076');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX UNIQ_B1087D9E899DB076 ON user_info');
        $this->addSql('ALTER TABLE user_info DROP fk_id_user_id');
        $this->addSql('DROP INDEX IDX_8ECAEAD4899DB076 ON command');
        $this->addSql('ALTER TABLE command DROP fk_id_user_id');
        $this->addSql('DROP INDEX IDX_61A0D4EB899DB076 ON card_user');
        $this->addSql('ALTER TABLE card_user DROP fk_id_user_id');
    }
}
