<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250422211226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP CONSTRAINT fk_e33bd3b83256915b
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_e33bd3b83256915b
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD user_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD date_candidature TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD cv VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD lettre_motivation VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP cv_file
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP motivation_letter_file
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ALTER status DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ALTER status TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature RENAME COLUMN relation_id TO offre_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B84CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B8A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E33BD3B84CC8505A ON candidature (offre_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E33BD3B8A76ED395 ON candidature (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre ADD date_fin_publication TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre ALTER description TYPE TEXT
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre RENAME COLUMN offre TO titre
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B84CC8505A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP CONSTRAINT FK_E33BD3B8A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E33BD3B84CC8505A
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E33BD3B8A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD relation_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD cv_file VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD motivation_letter_file VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP offre_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP user_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP date_candidature
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP cv
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature DROP lettre_motivation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ALTER status SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ALTER status TYPE VARCHAR(50)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE candidature ADD CONSTRAINT fk_e33bd3b83256915b FOREIGN KEY (relation_id) REFERENCES offre (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_e33bd3b83256915b ON candidature (relation_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre DROP date_fin_publication
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre ALTER description TYPE VARCHAR(255)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE offre RENAME COLUMN titre TO offre
        SQL);
    }
}
