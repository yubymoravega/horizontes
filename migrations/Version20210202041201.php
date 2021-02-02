<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210202041201 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creditos_precio_venta (id INT AUTO_INCREMENT NOT NULL, id_config_precio_venta_id INT NOT NULL, identificador_servicio INT NOT NULL, credito TINYINT(1) DEFAULT NULL, importe DOUBLE PRECISION NOT NULL, INDEX IDX_847FE8A94699DFE5 (id_config_precio_venta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE creditos_precio_venta ADD CONSTRAINT FK_847FE8A94699DFE5 FOREIGN KEY (id_config_precio_venta_id) REFERENCES config_precio_venta_servicio (id)');
        $this->addSql('ALTER TABLE config_precio_venta_servicio ADD id_unidad_id INT NOT NULL, ADD precio_venta_total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE config_precio_venta_servicio ADD CONSTRAINT FK_6A244E601D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_6A244E601D34FA6B ON config_precio_venta_servicio (id_unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE creditos_precio_venta');
        $this->addSql('ALTER TABLE config_precio_venta_servicio DROP FOREIGN KEY FK_6A244E601D34FA6B');
        $this->addSql('DROP INDEX IDX_6A244E601D34FA6B ON config_precio_venta_servicio');
        $this->addSql('ALTER TABLE config_precio_venta_servicio DROP id_unidad_id, DROP precio_venta_total');
    }
}
