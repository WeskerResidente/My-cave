<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721152323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteille_de_vin ADD cave_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE bouteille_de_vin ADD CONSTRAINT FK_E88F9E497F05B85 FOREIGN KEY (cave_id) REFERENCES cave_avin (id)');
        $this->addSql('CREATE INDEX IDX_E88F9E497F05B85 ON bouteille_de_vin (cave_id)');
        $this->addSql('ALTER TABLE cave_avin ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cave_avin DROP description');
        $this->addSql('ALTER TABLE bouteille_de_vin DROP FOREIGN KEY FK_E88F9E497F05B85');
        $this->addSql('DROP INDEX IDX_E88F9E497F05B85 ON bouteille_de_vin');
        $this->addSql('ALTER TABLE bouteille_de_vin DROP cave_id');
    }
}
