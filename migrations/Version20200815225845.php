<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200815225845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ajuste (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, is_salida TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DD35BD326601BA07 (id_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cargo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, salario_base DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documento (id INT AUTO_INCREMENT NOT NULL, id_unidad_medida_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_configuracion_inicial_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, cantidad DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, precio DOUBLE PRECISION DEFAULT NULL, existencia DOUBLE PRECISION DEFAULT NULL, is_producto TINYINT(1) DEFAULT NULL, nro_tipo_anno INT DEFAULT NULL, fecha DATE DEFAULT NULL, activo TINYINT(1) DEFAULT NULL, INDEX IDX_B6B12EC7E16A5625 (id_unidad_medida_id), INDEX IDX_B6B12EC77A4F962 (id_tipo_documento_id), INDEX IDX_B6B12EC742F82C2 (id_configuracion_inicial_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE empleado (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_cargo_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) NOT NULL, salario_x_hora DOUBLE PRECISION DEFAULT NULL, fecha_alta DATE DEFAULT NULL, baja TINYINT(1) DEFAULT NULL, fecha_baja DATE DEFAULT NULL, direccion_particular VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, acumulado_tiempo_vacaciones DOUBLE PRECISION DEFAULT NULL, acumulado_dinero_vacaciones DOUBLE PRECISION DEFAULT NULL, rol VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_D9D9BF521D34FA6B (id_unidad_id), INDEX IDX_D9D9BF52D1E12F15 (id_cargo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informe_recepcion (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_proveedor_id INT NOT NULL, INDEX IDX_62A4EBD6601BA07 (id_documento_id), INDEX IDX_62A4EBDE8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercancia (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio_compra DOUBLE PRECISION NOT NULL, materiales_auxiliares TINYINT(1) DEFAULT NULL, activo TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mercancia_producto (id INT AUTO_INCREMENT NOT NULL, id_mercancia_id INT NOT NULL, id_producto_id INT NOT NULL, INDEX IDX_3F705CF59F287F54 (id_mercancia_id), INDEX IDX_3F705CF56E57A479 (id_producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, precio_costo DOUBLE PRECISION NOT NULL, activo TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proveedor (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, activo TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transferencia (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_unidad_id INT NOT NULL, is_salida TINYINT(1) DEFAULT NULL, INDEX IDX_EDC227306601BA07 (id_documento_id), INDEX IDX_EDC227301D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vale_salida (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, id_elemento_gasto_id INT NOT NULL, UNIQUE INDEX UNIQ_90C265C86601BA07 (id_documento_id), INDEX IDX_90C265C8F66372E9 (id_elemento_gasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ajuste ADD CONSTRAINT FK_DD35BD326601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC7E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC742F82C2 FOREIGN KEY (id_configuracion_inicial_id) REFERENCES configuracion_inicial (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF521D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52D1E12F15 FOREIGN KEY (id_cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBD6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBDE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF59F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF56E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227306601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227301D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52D1E12F15');
        $this->addSql('ALTER TABLE ajuste DROP FOREIGN KEY FK_DD35BD326601BA07');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBD6601BA07');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227306601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF59F287F54');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF56E57A479');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBDE8F12801');
        $this->addSql('DROP TABLE ajuste');
        $this->addSql('DROP TABLE cargo');
        $this->addSql('DROP TABLE documento');
        $this->addSql('DROP TABLE empleado');
        $this->addSql('DROP TABLE informe_recepcion');
        $this->addSql('DROP TABLE mercancia');
        $this->addSql('DROP TABLE mercancia_producto');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE proveedor');
        $this->addSql('DROP TABLE transferencia');
        $this->addSql('DROP TABLE vale_salida');
    }
}
