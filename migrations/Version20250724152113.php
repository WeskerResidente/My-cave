<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724152113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCEE50B206');
        $this->addSql('DROP INDEX IDX_67F068BCEE50B206 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE masque_id vin_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCBA62C651 FOREIGN KEY (vin_id) REFERENCES bouteille_de_vin (id)');
        $this->addSql('CREATE INDEX IDX_67F068BCBA62C651 ON commentaire (vin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BCBA62C651');
        $this->addSql('DROP INDEX IDX_67F068BCBA62C651 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE vin_id masque_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCEE50B206 FOREIGN KEY (masque_id) REFERENCES bouteille_de_vin (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_67F068BCEE50B206 ON commentaire (masque_id)');
    }
}
