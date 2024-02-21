<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217205004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi_reclamation DROP FOREIGN KEY FK_1F7160192D6BA2D9');
        $this->addSql('DROP INDEX IDX_1F7160192D6BA2D9 ON suivi_reclamation');
        $this->addSql('ALTER TABLE suivi_reclamation DROP reclamation_id, CHANGE idRec idRec INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi_reclamation ADD reclamation_id INT DEFAULT NULL, CHANGE idRec idRec VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE suivi_reclamation ADD CONSTRAINT FK_1F7160192D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_1F7160192D6BA2D9 ON suivi_reclamation (reclamation_id)');
    }
}
