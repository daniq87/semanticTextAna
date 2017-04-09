<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170314142934 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_810763261F55203D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__criterias AS SELECT id, topic_id, name FROM criterias');
        $this->addSql('DROP TABLE criterias');
        $this->addSql('CREATE TABLE criterias (id INTEGER NOT NULL, topic_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_810763261F55203D FOREIGN KEY (topic_id) REFERENCES topics (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO criterias (id, topic_id, name) SELECT id, topic_id, name FROM __temp__criterias');
        $this->addSql('DROP TABLE __temp__criterias');
        $this->addSql('CREATE INDEX IDX_810763261F55203D ON criterias (topic_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_810763261F55203D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__criterias AS SELECT id, topic_id, name FROM criterias');
        $this->addSql('DROP TABLE criterias');
        $this->addSql('CREATE TABLE criterias (id INTEGER NOT NULL, topic_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO criterias (id, topic_id, name) SELECT id, topic_id, name FROM __temp__criterias');
        $this->addSql('DROP TABLE __temp__criterias');
        $this->addSql('CREATE INDEX IDX_810763261F55203D ON criterias (topic_id)');
    }
}
