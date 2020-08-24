<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200824171139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ajuste (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, is_salida TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DD35BD326601BA07 (id_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE almacen (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cargo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, salario_base DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centro_costo (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_749608CE1ADA4D3F (id_cuenta_id), INDEX IDX_749608CE2D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuracion_inicial (id INT AUTO_INCREMENT NOT NULL, id_modulo_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_cuenta_id INT DEFAULT NULL, id_subcuenta_id INT DEFAULT NULL, deudora TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_8521BE24404AE9D2 (id_modulo_id), INDEX IDX_8521BE247A4F962 (id_tipo_documento_id), INDEX IDX_8521BE241ADA4D3F (id_cuenta_id), INDEX IDX_8521BE242D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta (id INT AUTO_INCREMENT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, deudora TINYINT(1) NOT NULL, produccion TINYINT(1) DEFAULT NULL, patrimonio TINYINT(1) DEFAULT NULL, elemento_gasto TINYINT(1) DEFAULT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documento (id INT AUTO_INCREMENT NOT NULL, id_unidad_medida_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_configuracion_inicial_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, cantidad DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, precio DOUBLE PRECISION DEFAULT NULL, existencia DOUBLE PRECISION DEFAULT NULL, is_producto TINYINT(1) DEFAULT NULL, nro_tipo_anno INT DEFAULT NULL, fecha DATE DEFAULT NULL, activo TINYINT(1) DEFAULT NULL, INDEX IDX_B6B12EC7E16A5625 (id_unidad_medida_id), INDEX IDX_B6B12EC77A4F962 (id_tipo_documento_id), INDEX IDX_B6B12EC742F82C2 (id_configuracion_inicial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elemento_gasto (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_50F9A4E1ADA4D3F (id_cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_cargo_id INT DEFAULT NULL, id_usuario_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) DEFAULT NULL, salario_x_hora DOUBLE PRECISION DEFAULT NULL, fecha_alta DATE DEFAULT NULL, baja TINYINT(1) NOT NULL, fecha_baja DATE DEFAULT NULL, direccion_particular VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, acumulado_tiempo_vacaciones DOUBLE PRECISION DEFAULT NULL, acumulado_dinero_vacaciones DOUBLE PRECISION DEFAULT NULL, rol VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_D9D9BF521D34FA6B (id_unidad_id), INDEX IDX_D9D9BF52D1E12F15 (id_cargo_id), UNIQUE INDEX UNIQ_D9D9BF527EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_activos (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT DEFAULT NULL, porciento_deprecia_anno DOUBLE PRECISION NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_50ADD6F61ADA4D3F (id_cuenta_id), INDEX IDX_50ADD6F62D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informe_recepcion (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_proveedor_id INT NOT NULL, INDEX IDX_62A4EBD6601BA07 (id_documento_id), INDEX IDX_62A4EBDE8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrumento_cobro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercancia (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio_compra DOUBLE PRECISION NOT NULL, materiales_auxiliares TINYINT(1) DEFAULT NULL, activo TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercancia_producto (id INT AUTO_INCREMENT NOT NULL, id_mercancia_id INT NOT NULL, id_producto_id INT NOT NULL, INDEX IDX_3F705CF59F287F54 (id_mercancia_id), INDEX IDX_3F705CF56E57A479 (id_producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moneda (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
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
        $this->addSql('CREATE TABLE vale_salida (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_elemento_gasto_id INT NOT NULL, UNIQUE INDEX UNIQ_90C265C86601BA07 (id_documento_id), INDEX IDX_90C265C8F66372E9 (id_elemento_gasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ajuste ADD CONSTRAINT FK_DD35BD326601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CE1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CE2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE24404AE9D2 FOREIGN KEY (id_modulo_id) REFERENCES modulo (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE247A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE241ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE242D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC7E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC742F82C2 FOREIGN KEY (id_configuracion_inicial_id) REFERENCES configuracion_inicial (id)');
        $this->addSql('ALTER TABLE elemento_gasto ADD CONSTRAINT FK_50F9A4E1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF521D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52D1E12F15 FOREIGN KEY (id_cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF527EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F61ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F62D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBD6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBDE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF59F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF56E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE subcuenta ADD CONSTRAINT FK_57BB37EA1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606FA5CADE9 FOREIGN KEY (id_moneda_origen_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606D85CECF7 FOREIGN KEY (id_moneda_destino_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227306601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227301D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F31E700CD FOREIGN KEY (id_padre_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE cliente_reporte CHANGE fecha fecha DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52D1E12F15');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC742F82C2');
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CE1ADA4D3F');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE241ADA4D3F');
        $this->addSql('ALTER TABLE elemento_gasto DROP FOREIGN KEY FK_50F9A4E1ADA4D3F');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F61ADA4D3F');
        $this->addSql('ALTER TABLE subcuenta DROP FOREIGN KEY FK_57BB37EA1ADA4D3F');
        $this->addSql('ALTER TABLE ajuste DROP FOREIGN KEY FK_DD35BD326601BA07');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBD6601BA07');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227306601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C8F66372E9');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF59F287F54');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE24404AE9D2');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606FA5CADE9');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606D85CECF7');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF56E57A479');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBDE8F12801');
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CE2D412F53');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE242D412F53');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F62D412F53');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE247A4F962');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC77A4F962');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF521D34FA6B');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227301D34FA6B');
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F31E700CD');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC7E16A5625');
        $this->addSql('DROP TABLE ajuste');
        $this->addSql('DROP TABLE almacen');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE centro_costo');
        $this->addSql('DROP TABLE configuracion_inicial');
        $this->addSql('DROP TABLE cuenta');
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
        $this->addSql('DROP TABLE vale_salida');
        $this->addSql('ALTER TABLE cliente_reporte CHANGE fecha fecha DATETIME NOT NULL');
    }
}
