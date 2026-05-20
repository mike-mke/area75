<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260520000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial schema: user and event tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "user" (
            id SERIAL NOT NULL,
            username VARCHAR(180) NOT NULL,
            email VARCHAR(255) NOT NULL,
            roles JSON NOT NULL,
            password VARCHAR(255) NOT NULL,
            google_id VARCHAR(255) DEFAULT NULL,
            is_verified BOOLEAN NOT NULL DEFAULT FALSE,
            reset_token VARCHAR(255) DEFAULT NULL,
            reset_token_expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');

        $this->addSql('CREATE TABLE event (
            id SERIAL NOT NULL,
            created_by_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            location VARCHAR(255) DEFAULT NULL,
            address VARCHAR(255) DEFAULT NULL,
            city VARCHAR(255) DEFAULT NULL,
            state VARCHAR(10) DEFAULT NULL,
            zip VARCHAR(10) DEFAULT NULL,
            flyer_path VARCHAR(255) DEFAULT NULL,
            zoom_link VARCHAR(500) DEFAULT NULL,
            is_approved BOOLEAN NOT NULL DEFAULT FALSE,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7B03A8386 ON event (created_by_id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7B03A8386');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE "user"');
    }
}
