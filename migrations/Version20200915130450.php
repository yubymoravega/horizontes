<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915130450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ajuste (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, nro_cuenta_inventario VARCHAR(255) NOT NULL, observacion VARCHAR(255) NOT NULL, nro_subcuenta_inventario VARCHAR(255) NOT NULL, nro_cuenta_acreedora VARCHAR(255) NOT NULL, nro_concecutivo VARCHAR(255) NOT NULL, anno INT NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_DD35BD326601BA07 (id_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cierre_diario (id INT AUTO_INCREMENT NOT NULL, id_almacen_id INT NOT NULL, id_usuario_id INT NOT NULL, fecha_cerrado DATE NOT NULL, fecha_cerrado_real DATETIME NOT NULL, INDEX IDX_F3D0CD8939161EBF (id_almacen_id), INDEX IDX_F3D0CD897EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depreciacion (id INT AUTO_INCREMENT NOT NULL, id_activo_fijo_id INT NOT NULL, fecha DATE NOT NULL, anno INT NOT NULL, mes INT NOT NULL, importe_depreciacion DOUBLE PRECISION NOT NULL, INDEX IDX_D618AE145832E72E (id_activo_fijo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documento (id INT AUTO_INCREMENT NOT NULL, id_almacen_id INT NOT NULL, id_unidad_id INT NOT NULL, importe_total DOUBLE PRECISION NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_B6B12EC739161EBF (id_almacen_id), INDEX IDX_B6B12EC71D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informe_recepcion (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_proveedor_id INT NOT NULL, nro_cuenta_inventario VARCHAR(255) NOT NULL, nro_subcuenta_inventario VARCHAR(255) NOT NULL, nro_cuenta_acreedora VARCHAR(255) NOT NULL, nro_subcuenta_acreedora VARCHAR(255) NOT NULL, nro_concecutivo VARCHAR(255) NOT NULL, anno INT NOT NULL, codigo_factura VARCHAR(255) NOT NULL, fecha_factura DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_62A4EBD6601BA07 (id_documento_id), INDEX IDX_62A4EBDE8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento (id INT AUTO_INCREMENT NOT NULL, id_tipo_documento_activo_fijo_id INT NOT NULL, id_tipo_movimiento_id INT NOT NULL, id_unidad_origen_id INT NOT NULL, id_unidad_destino_id INT NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_C8FF107AD1CE493D (id_tipo_documento_activo_fijo_id), INDEX IDX_C8FF107ADB763453 (id_tipo_movimiento_id), INDEX IDX_C8FF107A873C7FC7 (id_unidad_origen_id), INDEX IDX_C8FF107A4F781EA (id_unidad_destino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento_mercancia (id INT AUTO_INCREMENT NOT NULL, id_mercancia_id INT NOT NULL, id_documento_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_usuario_id INT DEFAULT NULL, cantidad DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, existencia DOUBLE PRECISION NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_44876BD79F287F54 (id_mercancia_id), INDEX IDX_44876BD76601BA07 (id_documento_id), INDEX IDX_44876BD77A4F962 (id_tipo_documento_id), INDEX IDX_44876BD77EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obligacion_pago (id INT AUTO_INCREMENT NOT NULL, id_proveedor_id INT NOT NULL, id_documento_id INT NOT NULL, id_unidad_id INT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, nro_subcuenta VARCHAR(255) NOT NULL, valor_pagado DOUBLE PRECISION DEFAULT NULL, resto DOUBLE PRECISION NOT NULL, liquidado TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, codigo_factura VARCHAR(255) NOT NULL, fecha_factura DATE NOT NULL, INDEX IDX_403C9B3BE8F12801 (id_proveedor_id), INDEX IDX_403C9B3B6601BA07 (id_documento_id), INDEX IDX_403C9B3B1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stripe_factura (id INT AUTO_INCREMENT NOT NULL, auth VARCHAR(255) NOT NULL, estatus VARCHAR(255) NOT NULL, cliente_id VARCHAR(255) NOT NULL, id_empleado VARCHAR(255) NOT NULL, monto VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transferencia (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_unidad_id INT DEFAULT NULL, id_almacen_id INT DEFAULT NULL, nro_cuenta_inventario VARCHAR(255) NOT NULL, nro_subcuenta_inventario VARCHAR(255) NOT NULL, nro_cuenta_acreedora VARCHAR(255) NOT NULL, nro_concecutivo VARCHAR(255) NOT NULL, anno INT NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_EDC227306601BA07 (id_documento_id), INDEX IDX_EDC227301D34FA6B (id_unidad_id), INDEX IDX_EDC2273039161EBF (id_almacen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vale_salida (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_elemento_gasto_id INT NOT NULL, UNIQUE INDEX UNIQ_90C265C86601BA07 (id_documento_id), INDEX IDX_90C265C8F66372E9 (id_elemento_gasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ajuste ADD CONSTRAINT FK_DD35BD326601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE cierre_diario ADD CONSTRAINT FK_F3D0CD8939161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE cierre_diario ADD CONSTRAINT FK_F3D0CD897EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depreciacion ADD CONSTRAINT FK_D618AE145832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC71D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBD6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBDE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107AD1CE493D FOREIGN KEY (id_tipo_documento_activo_fijo_id) REFERENCES tipo_documento_activo_fijo (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107ADB763453 FOREIGN KEY (id_tipo_movimiento_id) REFERENCES tipo_movimiento (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107A873C7FC7 FOREIGN KEY (id_unidad_origen_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107A4F781EA FOREIGN KEY (id_unidad_destino_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD79F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD76601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD77EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3BE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3B6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3B1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227306601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227301D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC2273039161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93E1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93E4A667A2B FOREIGN KEY (id_grupo_activo_id) REFERENCES grupo_activos (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EA1BE243F FOREIGN KEY (id_tipo_documento_activo_id) REFERENCES tipo_documento_activo_fijo (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EEB3145A8 FOREIGN KEY (id_cuenta_deprecia_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo ADD CONSTRAINT FK_2FA61FF25832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo ADD CONSTRAINT FK_2FA61FF27786CA71 FOREIGN KEY (id_movimiento_activo_fijo_id) REFERENCES movimiento (id)');
        $this->addSql('ALTER TABLE cliente_reporte ADD efectivo VARCHAR(255) DEFAULT NULL, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE mercancia ADD cuenta VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE modulo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tipo_documento CHANGE id id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_F3E6D02F3A909126 ON unidad');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ajuste DROP FOREIGN KEY FK_DD35BD326601BA07');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBD6601BA07');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD76601BA07');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3B6601BA07');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227306601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo DROP FOREIGN KEY FK_2FA61FF27786CA71');
        $this->addSql('DROP TABLE ajuste');
        $this->addSql('DROP TABLE cierre_diario');
        $this->addSql('DROP TABLE depreciacion');
        $this->addSql('DROP TABLE documento');
        $this->addSql('DROP TABLE informe_recepcion');
        $this->addSql('DROP TABLE movimiento');
        $this->addSql('DROP TABLE movimiento_mercancia');
        $this->addSql('DROP TABLE obligacion_pago');
        $this->addSql('DROP TABLE stripe_factura');
        $this->addSql('DROP TABLE transferencia');
        $this->addSql('DROP TABLE vale_salida');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93E1D34FA6B');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93E4A667A2B');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EE8F12801');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EA1BE243F');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EEB3145A8');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EF66372E9');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo DROP FOREIGN KEY FK_2FA61FF25832E72E');
        $this->addSql('ALTER TABLE cliente_reporte DROP efectivo, CHANGE fecha fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE mercancia DROP cuenta');
        $this->addSql('ALTER TABLE modulo CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tipo_documento CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3E6D02F3A909126 ON unidad (nombre)');
    }
}
