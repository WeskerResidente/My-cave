<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250718065012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bouteille_cave (id BIGINT AUTO_INCREMENT NOT NULL, bouteille_id BIGINT NOT NULL, cave_id BIGINT NOT NULL, quantite INT NOT NULL, INDEX IDX_AD84F5BDF1966394 (bouteille_id), INDEX IDX_AD84F5BD7F05B85 (cave_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bouteille_de_vin (id BIGINT AUTO_INCREMENT NOT NULL, cree_par_id INT NOT NULL, nom VARCHAR(255) NOT NULL, annee INT NOT NULL, region VARCHAR(255) NOT NULL, cepage VARCHAR(255) NOT NULL, prix NUMERIC(10, 2) NOT NULL, images VARCHAR(255) NOT NULL, appelation VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_ajout DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_modification DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_E88F9E49FC29C013 (cree_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cave_avin (id BIGINT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, cree_par_id INT NOT NULL, nom VARCHAR(255) NOT NULL, date_ajout DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_modification DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_3FB7323DFB88E14F (utilisateur_id), INDEX IDX_3FB7323DFC29C013 (cree_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire_de_vin (id BIGINT AUTO_INCREMENT NOT NULL, vin_id BIGINT NOT NULL, utilisateur_id INT NOT NULL, commentaire LONGTEXT NOT NULL, INDEX IDX_BAD653F2BA62C651 (vin_id), INDEX IDX_BAD653F2FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note_de_vin (id BIGINT AUTO_INCREMENT NOT NULL, vin_id BIGINT NOT NULL, utilisateur_id INT NOT NULL, note INT NOT NULL, INDEX IDX_B680D4A1BA62C651 (vin_id), INDEX IDX_B680D4A1FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nom VARCHAR(255) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bouteille_cave ADD CONSTRAINT FK_AD84F5BDF1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('ALTER TABLE bouteille_cave ADD CONSTRAINT FK_AD84F5BD7F05B85 FOREIGN KEY (cave_id) REFERENCES cave_avin (id)');
        $this->addSql('ALTER TABLE bouteille_de_vin ADD CONSTRAINT FK_E88F9E49FC29C013 FOREIGN KEY (cree_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cave_avin ADD CONSTRAINT FK_3FB7323DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cave_avin ADD CONSTRAINT FK_3FB7323DFC29C013 FOREIGN KEY (cree_par_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaire_de_vin ADD CONSTRAINT FK_BAD653F2BA62C651 FOREIGN KEY (vin_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('ALTER TABLE commentaire_de_vin ADD CONSTRAINT FK_BAD653F2FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE note_de_vin ADD CONSTRAINT FK_B680D4A1BA62C651 FOREIGN KEY (vin_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('ALTER TABLE note_de_vin ADD CONSTRAINT FK_B680D4A1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteille_cave DROP FOREIGN KEY FK_AD84F5BDF1966394');
        $this->addSql('ALTER TABLE bouteille_cave DROP FOREIGN KEY FK_AD84F5BD7F05B85');
        $this->addSql('ALTER TABLE bouteille_de_vin DROP FOREIGN KEY FK_E88F9E49FC29C013');
        $this->addSql('ALTER TABLE cave_avin DROP FOREIGN KEY FK_3FB7323DFB88E14F');
        $this->addSql('ALTER TABLE cave_avin DROP FOREIGN KEY FK_3FB7323DFC29C013');
        $this->addSql('ALTER TABLE commentaire_de_vin DROP FOREIGN KEY FK_BAD653F2BA62C651');
        $this->addSql('ALTER TABLE commentaire_de_vin DROP FOREIGN KEY FK_BAD653F2FB88E14F');
        $this->addSql('ALTER TABLE note_de_vin DROP FOREIGN KEY FK_B680D4A1BA62C651');
        $this->addSql('ALTER TABLE note_de_vin DROP FOREIGN KEY FK_B680D4A1FB88E14F');
        $this->addSql('DROP TABLE bouteille_cave');
        $this->addSql('DROP TABLE bouteille_de_vin');
        $this->addSql('DROP TABLE cave_avin');
        $this->addSql('DROP TABLE commentaire_de_vin');
        $this->addSql('DROP TABLE note_de_vin');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
