<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210116154937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nomina_pago ADD id_unidad_id INT NOT NULL');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD331D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_5CB8BD331D34FA6B ON nomina_pago (id_unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nomina_pago DROP FOREIGN KEY FK_5CB8BD331D34FA6B');
        $this->addSql('DROP INDEX IDX_5CB8BD331D34FA6B ON nomina_pago');
        $this->addSql('ALTER TABLE nomina_pago DROP id_unidad_id');
    }
}
