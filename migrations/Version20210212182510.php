<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212182510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asiento ADD id_elemento_visa_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C4CC57875 FOREIGN KEY (id_elemento_visa_id) REFERENCES elementos_visa (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C4CC57875 ON asiento (id_elemento_visa_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C4CC57875');
        $this->addSql('DROP INDEX IDX_71D6D35C4CC57875 ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_elemento_visa_id');
    }
}
