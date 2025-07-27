<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725104929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_de_vin DROP FOREIGN KEY FK_BAD653F2BA62C651');
        $this->addSql('ALTER TABLE commentaire_de_vin DROP FOREIGN KEY FK_BAD653F2FB88E14F');
        $this->addSql('DROP TABLE commentaire_de_vin');
        $this->addSql('ALTER TABLE cave_avin CHANGE region region VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire_de_vin (id BIGINT AUTO_INCREMENT NOT NULL, vin_id BIGINT NOT NULL, utilisateur_id INT NOT NULL, commentaire LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_BAD653F2BA62C651 (vin_id), INDEX IDX_BAD653F2FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaire_de_vin ADD CONSTRAINT FK_BAD653F2BA62C651 FOREIGN KEY (vin_id) REFERENCES bouteille_de_vin (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commentaire_de_vin ADD CONSTRAINT FK_BAD653F2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE cave_avin CHANGE region region VARCHAR(255) NOT NULL');
    }
}
