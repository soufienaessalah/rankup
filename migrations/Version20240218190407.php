<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218190407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD photo VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD birthdate DATE DEFAULT NULL, ADD why_blocked VARCHAR(255) DEFAULT NULL, ADD status TINYINT(1) NOT NULL, ADD elo JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD bio VARCHAR(255) DEFAULT NULL, ADD summonername VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP photo, DROP phone, DROP birthdate, DROP why_blocked, DROP status, DROP elo, DROP bio, DROP summonername');
    }
}
