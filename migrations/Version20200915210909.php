<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915210909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE users_categories');
        $this->addSql('ALTER TABLE commentaires ADD retourcom_id INT DEFAULT NULL, ADD actu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4B456788B FOREIGN KEY (retourcom_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4F77EEF58 FOREIGN KEY (actu_id) REFERENCES actualites (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4B456788B ON commentaires (retourcom_id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4F77EEF58 ON commentaires (actu_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_categories (users_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_ED98E9FCA21214B7 (categories_id), INDEX IDX_ED98E9FC67B3B43D (users_id), PRIMARY KEY(users_id, categories_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_categories ADD CONSTRAINT FK_ED98E9FC67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_categories ADD CONSTRAINT FK_ED98E9FCA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4B456788B');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4F77EEF58');
        $this->addSql('DROP INDEX IDX_D9BEC0C4B456788B ON commentaires');
        $this->addSql('DROP INDEX IDX_D9BEC0C4F77EEF58 ON commentaires');
        $this->addSql('ALTER TABLE commentaires DROP retourcom_id, DROP actu_id');
    }
}
