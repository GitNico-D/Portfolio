<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308184634 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact ADD presentation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638AB627E8B FOREIGN KEY (presentation_id) REFERENCES presentation (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638AB627E8B ON contact (presentation_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638AB627E8B');
        $this->addSql('DROP INDEX IDX_4C62E638AB627E8B ON contact');
        $this->addSql('ALTER TABLE contact DROP presentation_id');
    }
}
