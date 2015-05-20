<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150520185448 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location_start DROP INDEX IDX_E92510AA923FCDD9, ADD UNIQUE INDEX UNIQ_E92510AA923FCDD9 (maze_id)');
        $this->addSql('ALTER TABLE location_end DROP INDEX IDX_612EB824923FCDD9, ADD UNIQUE INDEX UNIQ_612EB824923FCDD9 (maze_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE location_end DROP INDEX UNIQ_612EB824923FCDD9, ADD INDEX IDX_612EB824923FCDD9 (maze_id)');
        $this->addSql('ALTER TABLE location_start DROP INDEX UNIQ_E92510AA923FCDD9, ADD INDEX IDX_E92510AA923FCDD9 (maze_id)');
    }
}
