<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922123000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto ADD id_amlacen_id INT NOT NULL, ADD id_unidad_medida_id INT NOT NULL, ADD cuenta VARCHAR(255) NOT NULL, ADD importe DOUBLE PRECISION NOT NULL, CHANGE activo activo TINYINT(1) NOT NULL, CHANGE precio_costo existencia DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E2C70A62 FOREIGN KEY (id_amlacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615E2C70A62 ON producto (id_amlacen_id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615E16A5625 ON producto (id_unidad_medida_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E2C70A62');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E16A5625');
        $this->addSql('DROP INDEX IDX_A7BB0615E2C70A62 ON producto');
        $this->addSql('DROP INDEX IDX_A7BB0615E16A5625 ON producto');
        $this->addSql('ALTER TABLE producto ADD precio_costo DOUBLE PRECISION NOT NULL, DROP id_amlacen_id, DROP id_unidad_medida_id, DROP cuenta, DROP existencia, DROP importe, CHANGE activo activo TINYINT(1) DEFAULT NULL');
    }
}
