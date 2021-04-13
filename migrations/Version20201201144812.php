<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201144812 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualites CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE actualites RENAME INDEX idx_75315b6d9777d11e TO IDX_75315B6D12469DE2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualites CHANGE category_id category_id INT NOT NULL');
        $this->addSql('ALTER TABLE actualites RENAME INDEX idx_75315b6d12469de2 TO IDX_75315B6D9777D11E');
    }
}
