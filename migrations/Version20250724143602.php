<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724143602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, masque_id BIGINT DEFAULT NULL, user_id INT DEFAULT NULL, commentaire VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', auteur VARCHAR(255) DEFAULT NULL, INDEX IDX_67F068BCEE50B206 (masque_id), INDEX IDX_67F068BCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, vin_id BIGINT NOT NULL, note INT NOT NULL, INDEX IDX_268BC95A76ED395 (user_id), INDEX IDX_268BC95BA62C651 (vin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_de_vin (id BIGINT AUTO_INCREMENT NOT NULL, vin_id BIGINT NOT NULL, utilisateur_id INT NOT NULL, note INT NOT NULL, INDEX IDX_B680D4A1BA62C651 (vin_id), INDEX IDX_B680D4A1FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCEE50B206 FOREIGN KEY (masque_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notation ADD CONSTRAINT FK_268BC95BA62C651 FOREIGN KEY (vin_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('ALTER TABLE note_de_vin ADD CONSTRAINT FK_B680D4A1BA62C651 FOREIGN KEY (vin_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('ALTER TABLE note_de_vin ADD CONSTRAINT FK_B680D4A1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bouteille_de_vin ADD CONSTRAINT FK_E88F9E491576D565 FOREIGN KEY (type_de_vin_id) REFERENCES type_de_vin (id)');
        $this->addSql('ALTER TABLE type_de_vin CHANGE nom nom VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCEE50B206');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCA76ED395');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95A76ED395');
        $this->addSql('ALTER TABLE notation DROP FOREIGN KEY FK_268BC95BA62C651');
        $this->addSql('ALTER TABLE note_de_vin DROP FOREIGN KEY FK_B680D4A1BA62C651');
        $this->addSql('ALTER TABLE note_de_vin DROP FOREIGN KEY FK_B680D4A1FB88E14F');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE notation');
        $this->addSql('DROP TABLE note_de_vin');
        $this->addSql('ALTER TABLE type_de_vin CHANGE nom nom VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE bouteille_de_vin DROP FOREIGN KEY FK_E88F9E491576D565');
    }
}
