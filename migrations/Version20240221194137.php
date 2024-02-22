<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221194137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement_sponsor DROP FOREIGN KEY FK_8289DE0812F7FB51');
        $this->addSql('ALTER TABLE evenement_sponsor DROP FOREIGN KEY FK_8289DE08FD02F13');
        $this->addSql('DROP TABLE evenement_sponsor');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_sponsor (evenement_id INT NOT NULL, sponsor_id INT NOT NULL, INDEX IDX_8289DE08FD02F13 (evenement_id), INDEX IDX_8289DE0812F7FB51 (sponsor_id), PRIMARY KEY(evenement_id, sponsor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement_sponsor ADD CONSTRAINT FK_8289DE0812F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_sponsor ADD CONSTRAINT FK_8289DE08FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
    }
}
