<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150520184100 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location ADD maze_id INT DEFAULT NULL, ADD type TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB923FCDD9 FOREIGN KEY (maze_id) REFERENCES maze (id)');
        $this->addSql('CREATE INDEX IDX_5E9E89CB923FCDD9 ON location (maze_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location DROP FOREIGN KEY FK_5E9E89CB923FCDD9');
        $this->addSql('DROP INDEX IDX_5E9E89CB923FCDD9 ON location');
        $this->addSql('ALTER TABLE location DROP maze_id, DROP type');
    }
}
