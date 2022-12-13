<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221118163234 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création base de données';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE card (id INT AUTO_INCREMENT NOT NULL, card_set_id INT NOT NULL, api_card_id VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, img VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_161498D362C45E6C (card_set_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_serie (id INT AUTO_INCREMENT NOT NULL, fk_id_game_id INT NOT NULL, serie_name VARCHAR(100) NOT NULL, img VARCHAR(255) NOT NULL, INDEX IDX_920E62F2CA7CBAE6 (fk_id_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_set (id INT AUTO_INCREMENT NOT NULL, card_serie_id INT DEFAULT NULL, api_set_id VARCHAR(100) NOT NULL, set_name VARCHAR(100) NOT NULL, img VARCHAR(255) NOT NULL, INDEX IDX_B6E4A11D6072463E (card_serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE card_user (id INT AUTO_INCREMENT NOT NULL, fk_id_user_id INT NOT NULL, card_id INT NOT NULL, card_set_id INT NOT NULL, name VARCHAR(100) NOT NULL, quality VARCHAR(45) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_61A0D4EB899DB076 (fk_id_user_id), INDEX IDX_61A0D4EB4ACC9A20 (card_id), INDEX IDX_61A0D4EB62C45E6C (card_set_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, fk_id_user_id INT NOT NULL, shipping DOUBLE PRECISION DEFAULT NULL, total DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status_command VARCHAR(45) NOT NULL, INDEX IDX_8ECAEAD4899DB076 (fk_id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, fk_id_command_id INT NOT NULL, fk_id_card_user_id INT NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_52EA1F09F2219D8F (fk_id_command_id), INDEX IDX_52EA1F09A1678A4 (fk_id_card_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(50) NOT NULL, email VARCHAR(100) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, is_admin TINYINT(1) NOT NULL, password VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, fk_id_user_id INT NOT NULL, city VARCHAR(50) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, address VARCHAR(55) DEFAULT NULL, postal_code VARCHAR(5) DEFAULT NULL, description LONGTEXT DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B1087D9E899DB076 (fk_id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D362C45E6C FOREIGN KEY (card_set_id) REFERENCES card_set (id)');
        $this->addSql('ALTER TABLE card_serie ADD CONSTRAINT FK_920E62F2CA7CBAE6 FOREIGN KEY (fk_id_game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE card_set ADD CONSTRAINT FK_B6E4A11D6072463E FOREIGN KEY (card_serie_id) REFERENCES card_serie (id)');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EB899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EB4ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE card_user ADD CONSTRAINT FK_61A0D4EB62C45E6C FOREIGN KEY (card_set_id) REFERENCES card_set (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09F2219D8F FOREIGN KEY (fk_id_command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09A1678A4 FOREIGN KEY (fk_id_card_user_id) REFERENCES card_user (id)');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9E899DB076 FOREIGN KEY (fk_id_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D362C45E6C');
        $this->addSql('ALTER TABLE card_serie DROP FOREIGN KEY FK_920E62F2CA7CBAE6');
        $this->addSql('ALTER TABLE card_set DROP FOREIGN KEY FK_B6E4A11D6072463E');
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EB899DB076');
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EB4ACC9A20');
        $this->addSql('ALTER TABLE card_user DROP FOREIGN KEY FK_61A0D4EB62C45E6C');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4899DB076');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09F2219D8F');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09A1678A4');
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9E899DB076');
        $this->addSql('DROP TABLE card');
        $this->addSql('DROP TABLE card_serie');
        $this->addSql('DROP TABLE card_set');
        $this->addSql('DROP TABLE card_user');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_info');
    }
}
