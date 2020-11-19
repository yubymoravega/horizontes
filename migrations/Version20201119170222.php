<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119170222 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud_turismo DROP FOREIGN KEY FK_64E770B96E3131E1');
        $this->addSql('DROP INDEX IDX_64E770B96E3131E1 ON solicitud_turismo');
        $this->addSql('ALTER TABLE solicitud_turismo ADD vuelo_origen VARCHAR(255) DEFAULT NULL, DROP vuelo_origen_id_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud_turismo ADD vuelo_origen_id_id INT DEFAULT NULL, DROP vuelo_origen');
        $this->addSql('ALTER TABLE solicitud_turismo ADD CONSTRAINT FK_64E770B96E3131E1 FOREIGN KEY (vuelo_origen_id_id) REFERENCES vuelo_origen (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_64E770B96E3131E1 ON solicitud_turismo (vuelo_origen_id_id)');
    }
}
