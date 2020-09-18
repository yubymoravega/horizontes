<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906174245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ajuste (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, is_salida TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DD35BD326601BA07 (id_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE almacen (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_D5B2D2501D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cargo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, salario_base DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centro_costo (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_749608CE1ADA4D3F (id_cuenta_id), INDEX IDX_749608CE2D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cierre_diario (id INT AUTO_INCREMENT NOT NULL, id_almacen_id INT NOT NULL, id_usuario_id INT NOT NULL, fecha_cerrado DATE NOT NULL, fecha_cerrado_real DATETIME NOT NULL, INDEX IDX_F3D0CD8939161EBF (id_almacen_id), INDEX IDX_F3D0CD897EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, apellidos VARCHAR(255) DEFAULT NULL, correo VARCHAR(255) DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, fecha DATE DEFAULT NULL, usuario INT DEFAULT NULL, comentario VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente_reporte (id INT AUTO_INCREMENT NOT NULL, user VARCHAR(255) NOT NULL, fecha DATE NOT NULL, id_cliente VARCHAR(255) NOT NULL, bram VARCHAR(255) NOT NULL, last4 VARCHAR(255) NOT NULL, monto VARCHAR(255) NOT NULL, comercio VARCHAR(255) NOT NULL, estado VARCHAR(255) NOT NULL, auth VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuracion_inicial (id INT AUTO_INCREMENT NOT NULL, id_modulo_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, deudora TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, str_cuentas VARCHAR(255) NOT NULL, str_subcuentas VARCHAR(255) NOT NULL, str_elemento_gasto VARCHAR(255) NOT NULL, str_cuentas_contrapartida VARCHAR(255) NOT NULL, str_subcuentas_contrapartida VARCHAR(255) DEFAULT NULL, INDEX IDX_8521BE24404AE9D2 (id_modulo_id), INDEX IDX_8521BE247A4F962 (id_tipo_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta (id INT AUTO_INCREMENT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, deudora TINYINT(1) NOT NULL, produccion TINYINT(1) DEFAULT NULL, patrimonio TINYINT(1) DEFAULT NULL, elemento_gasto TINYINT(1) DEFAULT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE custom_user (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, nombre_completo VARCHAR(255) NOT NULL, correo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8CE51EB479F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documento (id INT AUTO_INCREMENT NOT NULL, id_almacen_id INT NOT NULL, id_unidad_id INT NOT NULL, importe_total DOUBLE PRECISION NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_B6B12EC739161EBF (id_almacen_id), INDEX IDX_B6B12EC71D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elemento_gasto (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_50F9A4E1ADA4D3F (id_cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_cargo_id INT DEFAULT NULL, id_usuario_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) DEFAULT NULL, salario_x_hora DOUBLE PRECISION DEFAULT NULL, fecha_alta DATE DEFAULT NULL, baja TINYINT(1) NOT NULL, fecha_baja DATE DEFAULT NULL, direccion_particular VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, acumulado_tiempo_vacaciones DOUBLE PRECISION DEFAULT NULL, acumulado_dinero_vacaciones DOUBLE PRECISION DEFAULT NULL, rol VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_D9D9BF521D34FA6B (id_unidad_id), INDEX IDX_D9D9BF52D1E12F15 (id_cargo_id), UNIQUE INDEX UNIQ_D9D9BF527EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_activos (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT DEFAULT NULL, porciento_deprecia_anno DOUBLE PRECISION NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_50ADD6F61ADA4D3F (id_cuenta_id), INDEX IDX_50ADD6F62D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informe_recepcion (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_proveedor_id INT NOT NULL, nro_cuenta_inventario VARCHAR(255) NOT NULL, nro_subcuenta_inventario VARCHAR(255) NOT NULL, nro_cuenta_acreedora VARCHAR(255) NOT NULL, nro_subcuenta_acreedora VARCHAR(255) NOT NULL, nro_concecutivo VARCHAR(255) NOT NULL, anno INT NOT NULL, codigo_factura VARCHAR(255) NOT NULL, fecha_factura DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_62A4EBD6601BA07 (id_documento_id), INDEX IDX_62A4EBDE8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrumento_cobro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercancia (id INT AUTO_INCREMENT NOT NULL, id_amlacen_id INT NOT NULL, id_unidad_medida_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, existencia DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_9D094AE0E2C70A62 (id_amlacen_id), INDEX IDX_9D094AE0E16A5625 (id_unidad_medida_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercancia_producto (id INT AUTO_INCREMENT NOT NULL, id_mercancia_id INT NOT NULL, id_producto_id INT NOT NULL, INDEX IDX_3F705CF59F287F54 (id_mercancia_id), INDEX IDX_3F705CF56E57A479 (id_producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moneda (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento_mercancia (id INT AUTO_INCREMENT NOT NULL, id_mercancia_id INT NOT NULL, id_documento_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_usuario_id INT DEFAULT NULL, cantidad DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, existencia DOUBLE PRECISION NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_44876BD79F287F54 (id_mercancia_id), INDEX IDX_44876BD76601BA07 (id_documento_id), INDEX IDX_44876BD77A4F962 (id_tipo_documento_id), INDEX IDX_44876BD77EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE obligacion_pago (id INT AUTO_INCREMENT NOT NULL, id_proveedor_id INT NOT NULL, id_documento_id INT NOT NULL, id_unidad_id INT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, nro_subcuenta VARCHAR(255) NOT NULL, valor_pagado DOUBLE PRECISION DEFAULT NULL, resto DOUBLE PRECISION NOT NULL, liquidado TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, codigo_factura VARCHAR(255) NOT NULL, fecha_factura DATE NOT NULL, INDEX IDX_403C9B3BE8F12801 (id_proveedor_id), INDEX IDX_403C9B3B6601BA07 (id_documento_id), INDEX IDX_403C9B3B1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio_costo DOUBLE PRECISION NOT NULL, activo TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proveedor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, activo TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcuenta (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, nro_subcuenta VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, deudora TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_57BB37EA1ADA4D3F (id_cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasa_cambio (id INT AUTO_INCREMENT NOT NULL, id_moneda_origen_id INT NOT NULL, id_moneda_destino_id INT NOT NULL, anno INT NOT NULL, mes INT NOT NULL, valor DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_DAB48606FA5CADE9 (id_moneda_origen_id), INDEX IDX_DAB48606D85CECF7 (id_moneda_destino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_crud (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_documento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_documento_activo_fijo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_movimiento (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transferencia (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_unidad_id INT NOT NULL, is_salida TINYINT(1) DEFAULT NULL, INDEX IDX_EDC227306601BA07 (id_documento_id), INDEX IDX_EDC227301D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad (id INT AUTO_INCREMENT NOT NULL, id_padre_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F3E6D02F3A909126 (nombre), INDEX IDX_F3E6D02F31E700CD (id_padre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad_medida (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', status TINYINT(1) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vale_salida (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_elemento_gasto_id INT NOT NULL, UNIQUE INDEX UNIQ_90C265C86601BA07 (id_documento_id), INDEX IDX_90C265C8F66372E9 (id_elemento_gasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ajuste ADD CONSTRAINT FK_DD35BD326601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE almacen ADD CONSTRAINT FK_D5B2D2501D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CE1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CE2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE cierre_diario ADD CONSTRAINT FK_F3D0CD8939161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE cierre_diario ADD CONSTRAINT FK_F3D0CD897EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE24404AE9D2 FOREIGN KEY (id_modulo_id) REFERENCES modulo (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE247A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE custom_user ADD CONSTRAINT FK_8CE51EB479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC71D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE elemento_gasto ADD CONSTRAINT FK_50F9A4E1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF521D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52D1E12F15 FOREIGN KEY (id_cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF527EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F61ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F62D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBD6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBDE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE mercancia ADD CONSTRAINT FK_9D094AE0E2C70A62 FOREIGN KEY (id_amlacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE mercancia ADD CONSTRAINT FK_9D094AE0E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF59F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF56E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD79F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD76601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD77EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3BE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3B6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3B1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE subcuenta ADD CONSTRAINT FK_57BB37EA1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606FA5CADE9 FOREIGN KEY (id_moneda_origen_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606D85CECF7 FOREIGN KEY (id_moneda_destino_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227306601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227301D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F31E700CD FOREIGN KEY (id_padre_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cierre_diario DROP FOREIGN KEY FK_F3D0CD8939161EBF');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC739161EBF');
        $this->addSql('ALTER TABLE mercancia DROP FOREIGN KEY FK_9D094AE0E2C70A62');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52D1E12F15');
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CE1ADA4D3F');
        $this->addSql('ALTER TABLE elemento_gasto DROP FOREIGN KEY FK_50F9A4E1ADA4D3F');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F61ADA4D3F');
        $this->addSql('ALTER TABLE subcuenta DROP FOREIGN KEY FK_57BB37EA1ADA4D3F');
        $this->addSql('ALTER TABLE ajuste DROP FOREIGN KEY FK_DD35BD326601BA07');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBD6601BA07');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD76601BA07');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3B6601BA07');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227306601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C8F66372E9');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF59F287F54');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD79F287F54');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE24404AE9D2');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606FA5CADE9');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606D85CECF7');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF56E57A479');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBDE8F12801');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3BE8F12801');
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CE2D412F53');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F62D412F53');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE247A4F962');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD77A4F962');
        $this->addSql('ALTER TABLE almacen DROP FOREIGN KEY FK_D5B2D2501D34FA6B');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC71D34FA6B');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF521D34FA6B');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3B1D34FA6B');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227301D34FA6B');
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F31E700CD');
        $this->addSql('ALTER TABLE mercancia DROP FOREIGN KEY FK_9D094AE0E16A5625');
        $this->addSql('ALTER TABLE cierre_diario DROP FOREIGN KEY FK_F3D0CD897EB2C349');
        $this->addSql('ALTER TABLE custom_user DROP FOREIGN KEY FK_8CE51EB479F37AE5');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF527EB2C349');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD77EB2C349');
        $this->addSql('DROP TABLE ajuste');
        $this->addSql('DROP TABLE almacen');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE centro_costo');
        $this->addSql('DROP TABLE cierre_diario');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE cliente_reporte');
        $this->addSql('DROP TABLE configuracion_inicial');
        $this->addSql('DROP TABLE cuenta');
        $this->addSql('DROP TABLE custom_user');
        $this->addSql('DROP TABLE documento');
        $this->addSql('DROP TABLE elemento_gasto');
        $this->addSql('DROP TABLE empleado');
        $this->addSql('DROP TABLE grupo_activos');
        $this->addSql('DROP TABLE informe_recepcion');
        $this->addSql('DROP TABLE instrumento_cobro');
        $this->addSql('DROP TABLE mercancia');
        $this->addSql('DROP TABLE mercancia_producto');
        $this->addSql('DROP TABLE modulo');
        $this->addSql('DROP TABLE moneda');
        $this->addSql('DROP TABLE movimiento_mercancia');
        $this->addSql('DROP TABLE obligacion_pago');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE proveedor');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE subcuenta');
        $this->addSql('DROP TABLE tasa_cambio');
        $this->addSql('DROP TABLE test_crud');
        $this->addSql('DROP TABLE tipo_documento');
        $this->addSql('DROP TABLE tipo_documento_activo_fijo');
        $this->addSql('DROP TABLE tipo_movimiento');
        $this->addSql('DROP TABLE transferencia');
        $this->addSql('DROP TABLE unidad');
        $this->addSql('DROP TABLE unidad_medida');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vale_salida');
    }
}