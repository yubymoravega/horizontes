<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223191444 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configuracion_reglas_remesas (id INT AUTO_INCREMENT NOT NULL, id_pais_id INT NOT NULL, id_proveedor_id INT NOT NULL, minimo DOUBLE PRECISION NOT NULL, maximo DOUBLE PRECISION NOT NULL, valor_fijo_costo DOUBLE PRECISION DEFAULT NULL, porciento_costo DOUBLE PRECISION DEFAULT NULL, valor_fijo_venta DOUBLE PRECISION DEFAULT NULL, porciento_venta DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2398566118997CB6 (id_pais_id), INDEX IDX_23985661E8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lugares (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, habilitado TINYINT(1) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE precio_venta (id INT AUTO_INCREMENT NOT NULL, tramo INT DEFAULT NULL, poerciento DOUBLE PRECISION DEFAULT NULL, fijo DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_traslado (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_vehiculo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, cantidad_ini_persona INT NOT NULL, cantidad_fin_persona INT NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tramo (id INT AUTO_INCREMENT NOT NULL, proveedor INT NOT NULL, origen INT NOT NULL, destino INT NOT NULL, ida_vuelta TINYINT(1) NOT NULL, vehiculo INT NOT NULL, precio DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_2398566118997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_23985661E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE cotizacion ADD fecha_factura DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE provincias ADD id_pais INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE configuracion_reglas_remesas');
        $this->addSql('DROP TABLE lugares');
        $this->addSql('DROP TABLE precio_venta');
        $this->addSql('DROP TABLE tipo_traslado');
        $this->addSql('DROP TABLE tipo_vehiculo');
        $this->addSql('DROP TABLE tramo');
        $this->addSql('ALTER TABLE cotizacion DROP fecha_factura');
        $this->addSql('ALTER TABLE provincias DROP id_pais');
    }
}
