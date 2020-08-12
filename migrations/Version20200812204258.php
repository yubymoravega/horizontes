<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200812204258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE almacen (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D5B2D250A02A2F00 (descripcion), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centro_costo (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, codigo VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_749608CE1ADA4D3F (id_cuenta_id), INDEX IDX_749608CE2D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuracion_inicial (id INT AUTO_INCREMENT NOT NULL, id_modulo_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_cuenta_id INT DEFAULT NULL, id_subcuenta_id INT DEFAULT NULL, deudora TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_8521BE24404AE9D2 (id_modulo_id), INDEX IDX_8521BE247A4F962 (id_tipo_documento_id), INDEX IDX_8521BE241ADA4D3F (id_cuenta_id), INDEX IDX_8521BE242D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta (id INT AUTO_INCREMENT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, deudora TINYINT(1) NOT NULL, produccion TINYINT(1) DEFAULT NULL, patrimonio TINYINT(1) DEFAULT NULL, elemento_gasto TINYINT(1) DEFAULT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elemento_gasto (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_50F9A4E1ADA4D3F (id_cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_activos (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT DEFAULT NULL, porciento_deprecia_anno DOUBLE PRECISION NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_50ADD6F61ADA4D3F (id_cuenta_id), INDEX IDX_50ADD6F62D412F53 (id_subcuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instrumento_cobro (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modulo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moneda (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcuenta (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, nro_subcuenta VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, deudora TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_57BB37EA1ADA4D3F (id_cuenta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasa_cambio (id INT AUTO_INCREMENT NOT NULL, id_moneda_origen_id INT NOT NULL, id_moneda_destino_id INT NOT NULL, anno INT NOT NULL, mes INT NOT NULL, valor DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_DAB48606FA5CADE9 (id_moneda_origen_id), INDEX IDX_DAB48606D85CECF7 (id_moneda_destino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_documento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_documento_activo_fijo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_movimiento (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad (id INT AUTO_INCREMENT NOT NULL, id_padre_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_F3E6D02F3A909126 (nombre), INDEX IDX_F3E6D02F31E700CD (id_padre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unidad_medida (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CE1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CE2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE24404AE9D2 FOREIGN KEY (id_modulo_id) REFERENCES modulo (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE247A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE241ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE configuracion_inicial ADD CONSTRAINT FK_8521BE242D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE elemento_gasto ADD CONSTRAINT FK_50F9A4E1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F61ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F62D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta ADD CONSTRAINT FK_57BB37EA1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606FA5CADE9 FOREIGN KEY (id_moneda_origen_id) REFERENCES tasa_cambio (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606D85CECF7 FOREIGN KEY (id_moneda_destino_id) REFERENCES tasa_cambio (id)');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F31E700CD FOREIGN KEY (id_padre_id) REFERENCES unidad (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CE1ADA4D3F');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE241ADA4D3F');
        $this->addSql('ALTER TABLE elemento_gasto DROP FOREIGN KEY FK_50F9A4E1ADA4D3F');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F61ADA4D3F');
        $this->addSql('ALTER TABLE subcuenta DROP FOREIGN KEY FK_57BB37EA1ADA4D3F');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE24404AE9D2');
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CE2D412F53');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE242D412F53');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F62D412F53');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606FA5CADE9');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606D85CECF7');
        $this->addSql('ALTER TABLE configuracion_inicial DROP FOREIGN KEY FK_8521BE247A4F962');
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F31E700CD');
        $this->addSql('DROP TABLE almacen');
        $this->addSql('DROP TABLE centro_costo');
        $this->addSql('DROP TABLE configuracion_inicial');
        $this->addSql('DROP TABLE cuenta');
        $this->addSql('DROP TABLE elemento_gasto');
        $this->addSql('DROP TABLE grupo_activos');
        $this->addSql('DROP TABLE instrumento_cobro');
        $this->addSql('DROP TABLE modulo');
        $this->addSql('DROP TABLE moneda');
        $this->addSql('DROP TABLE subcuenta');
        $this->addSql('DROP TABLE tasa_cambio');
        $this->addSql('DROP TABLE tipo_documento');
        $this->addSql('DROP TABLE tipo_documento_activo_fijo');
        $this->addSql('DROP TABLE tipo_movimiento');
        $this->addSql('DROP TABLE unidad');
        $this->addSql('DROP TABLE unidad_medida');
    }
}
