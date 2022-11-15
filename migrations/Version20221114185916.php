<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114185916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE card_set CHANGE card_serie_id card_serie_id INT DEFAULT NULL, CHANGE set_link set_link VARCHAR(200) NOT NULL, CHANGE set_img set_img VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE created_at create_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user_info CHANGE city city VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE cata_card CHANGE api_card_id api_card_id VARCHAR(50) NOT NULL, CHANGE img img VARCHAR(200) NOT NULL, cata_card_link cata_card_link VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE user_info CHANGE city city VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE card_set CHANGE card_serie_id card_serie_id INT NOT NULL, CHANGE set_link set_link VARCHAR(45) NOT NULL, CHANGE set_img set_img VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE create_time created_at DATETIME NOT NULL');
    }
}
