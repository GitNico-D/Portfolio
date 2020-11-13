<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112093621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD created_at DATETIME, ADD updated_at DATETIME');
        $this->addSql('ALTER TABLE education ADD created_at DATETIME, ADD updated_at DATETIME');
        $this->addSql('ALTER TABLE experience ADD created_at DATETIME, ADD updated_at DATETIME');
        $this->addSql('ALTER TABLE project ADD created_at DATETIME, ADD updated_at DATETIME, CHANGE create_at creation_date DATE NOT NULL');
        $this->addSql('ALTER TABLE skill ADD created_at DATETIME, ADD updated_at DATETIME');
        $this->addSql('ALTER TABLE software ADD created_at DATETIME, ADD updated_at DATETIME');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE education DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE experience DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE project DROP created_at, DROP updated_at, CHANGE creation_date create_at DATE NOT NULL');
        $this->addSql('ALTER TABLE skill DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE software DROP created_at, DROP updated_at');
    }
}
