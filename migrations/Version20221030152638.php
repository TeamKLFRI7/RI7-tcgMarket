<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221030152638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création entité OrderItem';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, fk_id_command_id INT NOT NULL, fk_id_card_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, discount DOUBLE PRECISION DEFAULT NULL, creatad_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_52EA1F09F2219D8F (fk_id_command_id), INDEX IDX_52EA1F09643FF9C3 (fk_id_card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09F2219D8F FOREIGN KEY (fk_id_command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09643FF9C3 FOREIGN KEY (fk_id_card_id) REFERENCES card_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09F2219D8F');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09643FF9C3');
        $this->addSql('DROP TABLE order_item');
    }
}
