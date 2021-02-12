<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212174855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elementos_visa ADD id_servicio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E0469D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('CREATE INDEX IDX_90B65E0469D86E10 ON elementos_visa (id_servicio_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE elementos_visa DROP FOREIGN KEY FK_90B65E0469D86E10');
        $this->addSql('DROP INDEX IDX_90B65E0469D86E10 ON elementos_visa');
        $this->addSql('ALTER TABLE elementos_visa DROP id_servicio_id');
    }
}
