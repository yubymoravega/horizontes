<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008125630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE factura (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_usuario_id INT NOT NULL, fecha_factura DATE NOT NULL, tipo_cliente INT NOT NULL, id_cliente INT NOT NULL, nro_factura INT NOT NULL, anno INT NOT NULL, id_contrato INT NOT NULL, cuenta_obligacion VARCHAR(255) NOT NULL, subcuenta_obligacion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_F9EBA0091D34FA6B (id_unidad_id), INDEX IDX_F9EBA0097EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento_venta (id INT AUTO_INCREMENT NOT NULL, id_factura_id INT NOT NULL, mercancia TINYINT(1) NOT NULL, codigo VARCHAR(255) NOT NULL, cantidad DOUBLE PRECISION NOT NULL, precio DOUBLE PRECISION NOT NULL, descuento_recarga DOUBLE PRECISION DEFAULT NULL, existencia DOUBLE PRECISION DEFAULT NULL, cuenta_deudora VARCHAR(255) DEFAULT NULL, subcuenta_deudora VARCHAR(255) DEFAULT NULL, cuenta_acreedora VARCHAR(255) DEFAULT NULL, subcuenta_acreedora VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_8E3F7AE555C5F988 (id_factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obligacion_cobro (id INT AUTO_INCREMENT NOT NULL, id_factura_id INT NOT NULL, id_cliente INT NOT NULL, tipo_cliente INT NOT NULL, fecha_factura DATE NOT NULL, importe_factura DOUBLE PRECISION NOT NULL, cuenta_obligacion VARCHAR(255) NOT NULL, subcuenta_obligacion VARCHAR(255) DEFAULT NULL, resto_pagar DOUBLE PRECISION NOT NULL, liquidada TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_807C726D55C5F988 (id_factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0091D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0097EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE movimiento_venta ADD CONSTRAINT FK_8E3F7AE555C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE obligacion_cobro ADD CONSTRAINT FK_807C726D55C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE almacen_ocupado CHANGE id_almacen_id id_almacen_id INT NOT NULL, CHANGE id_usuario_id id_usuario_id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_venta DROP FOREIGN KEY FK_8E3F7AE555C5F988');
        $this->addSql('ALTER TABLE obligacion_cobro DROP FOREIGN KEY FK_807C726D55C5F988');
        $this->addSql('DROP TABLE factura');
        $this->addSql('DROP TABLE movimiento_venta');
        $this->addSql('DROP TABLE obligacion_cobro');
        $this->addSql('ALTER TABLE almacen_ocupado CHANGE id_almacen_id id_almacen_id INT DEFAULT NULL, CHANGE id_usuario_id id_usuario_id INT DEFAULT NULL');
    }
}
