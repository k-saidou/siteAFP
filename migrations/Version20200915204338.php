<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915204338 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualites ADD iduser_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualites ADD CONSTRAINT FK_75315B6D786A81FB FOREIGN KEY (iduser_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_75315B6D786A81FB ON actualites (iduser_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualites DROP FOREIGN KEY FK_75315B6D786A81FB');
        $this->addSql('DROP INDEX IDX_75315B6D786A81FB ON actualites');
        $this->addSql('ALTER TABLE actualites DROP iduser_id');
    }
}
