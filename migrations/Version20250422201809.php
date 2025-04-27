<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250422201809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE candidature (id SERIAL NOT NULL, relation_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, cv_file VARCHAR(255) NOT NULL, motivation_letter_file VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, note_interne TEXT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E33BD3B83256915B ON candidature (relation_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE offre (id SERIAL NOT NULL, offre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date_publication TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B83256915B FOREIGN KEY (relation_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B83256915B
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE candidature
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE offre
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE "user"
        SQL);
    }
}
