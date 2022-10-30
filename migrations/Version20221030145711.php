<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030145711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création entité UserInfo';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, fk_user_id_id INT NOT NULL, city VARCHAR(50) NULL, country VARCHAR(45) DEFAULT NULL, adress VARCHAR(55) DEFAULT NULL, zip_code VARCHAR(5) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, delivery_adress VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_B1087D9E6DE8AF9C (fk_user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_info ADD CONSTRAINT FK_B1087D9E6DE8AF9C FOREIGN KEY (fk_user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_info DROP FOREIGN KEY FK_B1087D9E6DE8AF9C');
        $this->addSql('DROP TABLE user_info');
    }
}
