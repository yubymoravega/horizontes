<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218191608 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agencias (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, id_user VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE asiento (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT NOT NULL, id_documento_id INT DEFAULT NULL, id_almacen_id INT DEFAULT NULL, id_centro_costo_id INT DEFAULT NULL, id_elemento_gasto_id INT DEFAULT NULL, id_orden_trabajo_id INT DEFAULT NULL, id_expediente_id INT DEFAULT NULL, id_proveedor_id INT DEFAULT NULL, id_unidad_id INT NOT NULL, id_tipo_comprobante_id INT DEFAULT NULL, id_comprobante_id INT DEFAULT NULL, id_factura_id INT DEFAULT NULL, tipo_cliente INT DEFAULT NULL, id_cliente INT DEFAULT NULL, fecha DATE NOT NULL, anno INT NOT NULL, credito DOUBLE PRECISION DEFAULT NULL, debito DOUBLE PRECISION DEFAULT NULL, nro_documento VARCHAR(255) NOT NULL, INDEX IDX_71D6D35C1ADA4D3F (id_cuenta_id), INDEX IDX_71D6D35C2D412F53 (id_subcuenta_id), INDEX IDX_71D6D35C6601BA07 (id_documento_id), INDEX IDX_71D6D35C39161EBF (id_almacen_id), INDEX IDX_71D6D35CC59B01FF (id_centro_costo_id), INDEX IDX_71D6D35CF66372E9 (id_elemento_gasto_id), INDEX IDX_71D6D35C71381BB3 (id_orden_trabajo_id), INDEX IDX_71D6D35CF5DBAF2B (id_expediente_id), INDEX IDX_71D6D35CE8F12801 (id_proveedor_id), INDEX IDX_71D6D35C1D34FA6B (id_unidad_id), INDEX IDX_71D6D35CEF5F7851 (id_tipo_comprobante_id), INDEX IDX_71D6D35C1800963C (id_comprobante_id), INDEX IDX_71D6D35C55C5F988 (id_factura_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria_cliente (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, prefijo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cobros_pagos (id INT AUTO_INCREMENT NOT NULL, id_factura_id INT DEFAULT NULL, id_informe_id INT DEFAULT NULL, id_proveedor_id INT DEFAULT NULL, debito DOUBLE PRECISION DEFAULT NULL, credito DOUBLE PRECISION DEFAULT NULL, id_tipo_cliente INT DEFAULT NULL, id_cliente_venta INT DEFAULT NULL, INDEX IDX_D9581D1655C5F988 (id_factura_id), INDEX IDX_D9581D1626990C38 (id_informe_id), INDEX IDX_D9581D16E8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento_servicio (id INT AUTO_INCREMENT NOT NULL, id_factura_id INT NOT NULL, servicio_id INT NOT NULL, cantidad DOUBLE PRECISION NOT NULL, precio DOUBLE PRECISION NOT NULL, impuesto DOUBLE PRECISION DEFAULT NULL, activo TINYINT(1) NOT NULL, cuenta VARCHAR(255) NOT NULL, nro_subcuenta_deudora VARCHAR(255) NOT NULL, cuenta_nominal_acreedora VARCHAR(255) NOT NULL, subcuenta_nominal_acreedora VARCHAR(255) NOT NULL, costo DOUBLE PRECISION DEFAULT NULL, anno INT NOT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_93FD19C355C5F988 (id_factura_id), INDEX IDX_93FD19C371CAA3E7 (servicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operaciones_comprobante_operaciones (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT NOT NULL, id_centro_costo_id INT DEFAULT NULL, id_orden_trabajo_id INT DEFAULT NULL, id_elemento_gasto_id INT DEFAULT NULL, id_expediente_id INT DEFAULT NULL, id_proveedor_id INT DEFAULT NULL, id_registro_comprobantes_id INT NOT NULL, id_almacen_id INT DEFAULT NULL, id_unidad_id INT DEFAULT NULL, id_cliente INT DEFAULT NULL, id_tipo_cliente INT DEFAULT NULL, credito DOUBLE PRECISION NOT NULL, debito DOUBLE PRECISION NOT NULL, INDEX IDX_E7EA17E1ADA4D3F (id_cuenta_id), INDEX IDX_E7EA17E2D412F53 (id_subcuenta_id), INDEX IDX_E7EA17EC59B01FF (id_centro_costo_id), INDEX IDX_E7EA17E71381BB3 (id_orden_trabajo_id), INDEX IDX_E7EA17EF66372E9 (id_elemento_gasto_id), INDEX IDX_E7EA17EF5DBAF2B (id_expediente_id), INDEX IDX_E7EA17EE8F12801 (id_proveedor_id), INDEX IDX_E7EA17EECB9FBA7 (id_registro_comprobantes_id), INDEX IDX_E7EA17E39161EBF (id_almacen_id), INDEX IDX_E7EA17E1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicios (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE termino_pago (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C71381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CF5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CEF5F7851 FOREIGN KEY (id_tipo_comprobante_id) REFERENCES tipo_comprobante (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C1800963C FOREIGN KEY (id_comprobante_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C55C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE cobros_pagos ADD CONSTRAINT FK_D9581D1655C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE cobros_pagos ADD CONSTRAINT FK_D9581D1626990C38 FOREIGN KEY (id_informe_id) REFERENCES informe_recepcion (id)');
        $this->addSql('ALTER TABLE cobros_pagos ADD CONSTRAINT FK_D9581D16E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE movimiento_servicio ADD CONSTRAINT FK_93FD19C355C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE movimiento_servicio ADD CONSTRAINT FK_93FD19C371CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicios (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17EC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E71381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17EF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17EF5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17EE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17EECB9FBA7 FOREIGN KEY (id_registro_comprobantes_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE documento ADD id_documento_cancelado_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC74832F387 FOREIGN KEY (id_documento_cancelado_id) REFERENCES documento (id)');
        $this->addSql('CREATE INDEX IDX_B6B12EC74832F387 ON documento (id_documento_cancelado_id)');
        $this->addSql('ALTER TABLE factura ADD id_categoria_cliente_id INT DEFAULT NULL, ADD id_termino_pago_id INT DEFAULT NULL, ADD id_moneda_id INT DEFAULT NULL, ADD id_factura_cancela_id INT DEFAULT NULL, ADD cancelada TINYINT(1) DEFAULT NULL, ADD motivo_cancelacion VARCHAR(255) DEFAULT NULL, ADD servicio TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0094F4C4E26 FOREIGN KEY (id_categoria_cliente_id) REFERENCES categoria_cliente (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009C37A5552 FOREIGN KEY (id_termino_pago_id) REFERENCES termino_pago (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA009374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA00999274826 FOREIGN KEY (id_factura_cancela_id) REFERENCES factura (id)');
        $this->addSql('CREATE INDEX IDX_F9EBA0094F4C4E26 ON factura (id_categoria_cliente_id)');
        $this->addSql('CREATE INDEX IDX_F9EBA009C37A5552 ON factura (id_termino_pago_id)');
        $this->addSql('CREATE INDEX IDX_F9EBA009374388F5 ON factura (id_moneda_id)');
        $this->addSql('CREATE INDEX IDX_F9EBA00999274826 ON factura (id_factura_cancela_id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD id_movimiento_cancelado_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7571159DE FOREIGN KEY (id_movimiento_cancelado_id) REFERENCES movimiento_mercancia (id)');
        $this->addSql('CREATE INDEX IDX_44876BD7571159DE ON movimiento_mercancia (id_movimiento_cancelado_id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD id_movimiento_cancelado_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC571159DE FOREIGN KEY (id_movimiento_cancelado_id) REFERENCES movimiento_producto (id)');
        $this->addSql('CREATE INDEX IDX_FFC0EDFC571159DE ON movimiento_producto (id_movimiento_cancelado_id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD documento VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA0094F4C4E26');
        $this->addSql('ALTER TABLE movimiento_servicio DROP FOREIGN KEY FK_93FD19C371CAA3E7');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA009C37A5552');
        $this->addSql('DROP TABLE agencias');
        $this->addSql('DROP TABLE asiento');
        $this->addSql('DROP TABLE categoria_cliente');
        $this->addSql('DROP TABLE cobros_pagos');
        $this->addSql('DROP TABLE movimiento_servicio');
        $this->addSql('DROP TABLE operaciones_comprobante_operaciones');
        $this->addSql('DROP TABLE servicios');
        $this->addSql('DROP TABLE termino_pago');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC74832F387');
        $this->addSql('DROP INDEX IDX_B6B12EC74832F387 ON documento');
        $this->addSql('ALTER TABLE documento DROP id_documento_cancelado_id');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA009374388F5');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA00999274826');
        $this->addSql('DROP INDEX IDX_F9EBA0094F4C4E26 ON factura');
        $this->addSql('DROP INDEX IDX_F9EBA009C37A5552 ON factura');
        $this->addSql('DROP INDEX IDX_F9EBA009374388F5 ON factura');
        $this->addSql('DROP INDEX IDX_F9EBA00999274826 ON factura');
        $this->addSql('ALTER TABLE factura DROP id_categoria_cliente_id, DROP id_termino_pago_id, DROP id_moneda_id, DROP id_factura_cancela_id, DROP cancelada, DROP motivo_cancelacion, DROP servicio');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7571159DE');
        $this->addSql('DROP INDEX IDX_44876BD7571159DE ON movimiento_mercancia');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP id_movimiento_cancelado_id');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC571159DE');
        $this->addSql('DROP INDEX IDX_FFC0EDFC571159DE ON movimiento_producto');
        $this->addSql('ALTER TABLE movimiento_producto DROP id_movimiento_cancelado_id');
        $this->addSql('ALTER TABLE registro_comprobantes DROP documento');
    }
}
