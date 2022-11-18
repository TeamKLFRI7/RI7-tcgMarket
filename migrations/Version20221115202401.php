<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221115202401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_serie CHANGE serie_link serie_link VARCHAR(255) NOT NULL, CHANGE serie_img serie_img VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE card_set CHANGE set_link set_link VARCHAR(255) NOT NULL, CHANGE set_img set_img VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cata_card CHANGE img img VARCHAR(255) NOT NULL, CHANGE cata_card_link cata_card_link VARCHAR(255) NOT NULL, CHANGE api_card_id api_card_id VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE user_info CHANGE address adress VARCHAR(55) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE card_serie CHANGE serie_link serie_link VARCHAR(45) NOT NULL, CHANGE serie_img serie_img VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE user_info CHANGE adress address VARCHAR(55) DEFAULT NULL');
        $this->addSql('ALTER TABLE card_set CHANGE set_link set_link VARCHAR(200) NOT NULL, CHANGE set_img set_img VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE cata_card CHANGE api_card_id api_card_id INT NOT NULL, CHANGE img img VARCHAR(200) NOT NULL, CHANGE cata_card_link cata_card_link VARCHAR(200) NOT NULL');
    }
}
