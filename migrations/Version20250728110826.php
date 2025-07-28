<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728110826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteille_de_vin DROP FOREIGN KEY FK_E88F9E497F05B85');
        $this->addSql('ALTER TABLE bouteille_de_vin ADD CONSTRAINT FK_E88F9E497F05B85 FOREIGN KEY (cave_id) REFERENCES cave_avin (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteille_de_vin DROP FOREIGN KEY FK_E88F9E497F05B85');
        $this->addSql('ALTER TABLE bouteille_de_vin ADD CONSTRAINT FK_E88F9E497F05B85 FOREIGN KEY (cave_id) REFERENCES cave_avin (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
