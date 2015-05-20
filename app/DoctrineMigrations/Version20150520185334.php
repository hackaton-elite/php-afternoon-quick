<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150520185334 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location_start (id INT AUTO_INCREMENT NOT NULL, maze_id INT DEFAULT NULL, x INT NOT NULL, y INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted TINYINT(1) NOT NULL, INDEX IDX_E92510AA923FCDD9 (maze_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_end (id INT AUTO_INCREMENT NOT NULL, maze_id INT DEFAULT NULL, x INT NOT NULL, y INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted TINYINT(1) NOT NULL, INDEX IDX_612EB824923FCDD9 (maze_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_start ADD CONSTRAINT FK_E92510AA923FCDD9 FOREIGN KEY (maze_id) REFERENCES maze (id)');
        $this->addSql('ALTER TABLE location_end ADD CONSTRAINT FK_612EB824923FCDD9 FOREIGN KEY (maze_id) REFERENCES maze (id)');
        $this->addSql('DROP TABLE location');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE location (id INT AUTO_INCREMENT NOT NULL, maze_id INT DEFAULT NULL, x INT NOT NULL, y INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deleted TINYINT(1) NOT NULL, type TINYINT(1) NOT NULL, INDEX IDX_5E9E89CB923FCDD9 (maze_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location ADD CONSTRAINT FK_5E9E89CB923FCDD9 FOREIGN KEY (maze_id) REFERENCES maze (id)');
        $this->addSql('DROP TABLE location_start');
        $this->addSql('DROP TABLE location_end');
    }
}
