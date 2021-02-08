<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210203145757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente_solicitudes (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_solicitud_id INT NOT NULL, INDEX IDX_D0874AE67BF9CE86 (id_cliente_id), INDEX IDX_D0874AE63F78A396 (id_solicitud_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE config_precio_venta_servicio (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, identificador_servicio INT NOT NULL, prociento DOUBLE PRECISION DEFAULT NULL, valor_fijo DOUBLE PRECISION DEFAULT NULL, precio_venta_total DOUBLE PRECISION NOT NULL, INDEX IDX_6A244E601D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creditos_precio_venta (id INT AUTO_INCREMENT NOT NULL, id_config_precio_venta_id INT NOT NULL, identificador_servicio INT NOT NULL, credito TINYINT(1) DEFAULT NULL, importe DOUBLE PRECISION NOT NULL, INDEX IDX_847FE8A94699DFE5 (id_config_precio_venta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE elementos_visa (id INT AUTO_INCREMENT NOT NULL, id_proveedor_id INT NOT NULL, descripcion VARCHAR(255) NOT NULL, costo DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, codigo VARCHAR(255) DEFAULT NULL, INDEX IDX_90B65E04E8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_solicitudes (id INT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solicitud (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, primer_apellido VARCHAR(255) NOT NULL, segundo_apellido VARCHAR(255) NOT NULL, telefono_fijo VARCHAR(255) DEFAULT NULL, telefono_celular VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_client_tmp (id INT AUTO_INCREMENT NOT NULL, id_usuario_id INT NOT NULL, id_cliente_id INT NOT NULL, INDEX IDX_AC2C28007EB2C349 (id_usuario_id), INDEX IDX_AC2C28007BF9CE86 (id_cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente_solicitudes ADD CONSTRAINT FK_D0874AE67BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE cliente_solicitudes ADD CONSTRAINT FK_D0874AE63F78A396 FOREIGN KEY (id_solicitud_id) REFERENCES solicitud (id)');
        $this->addSql('ALTER TABLE config_precio_venta_servicio ADD CONSTRAINT FK_6A244E601D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE creditos_precio_venta ADD CONSTRAINT FK_847FE8A94699DFE5 FOREIGN KEY (id_config_precio_venta_id) REFERENCES config_precio_venta_servicio (id)');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E04E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE user_client_tmp ADD CONSTRAINT FK_AC2C28007EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_client_tmp ADD CONSTRAINT FK_AC2C28007BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente (id)');
        $this->addSql('DROP TABLE inposdom_cierre');
        $this->addSql('ALTER TABLE registro_comprobantes ADD id_instrumento_cobro_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B247B60D7E FOREIGN KEY (id_instrumento_cobro_id) REFERENCES instrumento_cobro (id)');
        $this->addSql('CREATE INDEX IDX_B2D1B2B247B60D7E ON registro_comprobantes (id_instrumento_cobro_id)');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE creditos_precio_venta DROP FOREIGN KEY FK_847FE8A94699DFE5');
        $this->addSql('ALTER TABLE cliente_solicitudes DROP FOREIGN KEY FK_D0874AE63F78A396');
        $this->addSql('CREATE TABLE inposdom_cierre (id INT AUTO_INCREMENT NOT NULL, factura INT NOT NULL, fecha DATETIME NOT NULL, json VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, empleado VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dop VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, usd VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE cliente_solicitudes');
        $this->addSql('DROP TABLE config_precio_venta_servicio');
        $this->addSql('DROP TABLE creditos_precio_venta');
        $this->addSql('DROP TABLE elementos_visa');
        $this->addSql('DROP TABLE estado_solicitudes');
        $this->addSql('DROP TABLE solicitud');
        $this->addSql('DROP TABLE user_client_tmp');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B247B60D7E');
        $this->addSql('DROP INDEX IDX_B2D1B2B247B60D7E ON registro_comprobantes');
        $this->addSql('ALTER TABLE registro_comprobantes DROP id_instrumento_cobro_id');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
