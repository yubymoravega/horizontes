<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302000005 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiarios_clientes (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_pais_id INT NOT NULL, id_provincia_id INT NOT NULL, id_municipio_id INT NOT NULL, primer_nombre VARCHAR(255) NOT NULL, primer_apellido VARCHAR(255) NOT NULL, segundo_apellido VARCHAR(255) NOT NULL, nombre_alternativo VARCHAR(255) DEFAULT NULL, primer_apellido_alternativo VARCHAR(255) DEFAULT NULL, segundo_apellido_alternativo VARCHAR(255) DEFAULT NULL, primer_telefono VARCHAR(255) DEFAULT NULL, segundo_telefono VARCHAR(255) DEFAULT NULL, identificacion VARCHAR(255) DEFAULT NULL, calle VARCHAR(255) NOT NULL, entre VARCHAR(255) DEFAULT NULL, y VARCHAR(255) DEFAULT NULL, nro_casa VARCHAR(255) DEFAULT NULL, edificio VARCHAR(255) DEFAULT NULL, apto VARCHAR(255) DEFAULT NULL, reparto VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_AE9DBD1E7BF9CE86 (id_cliente_id), INDEX IDX_AE9DBD1E18997CB6 (id_pais_id), INDEX IDX_AE9DBD1E6DB054DD (id_provincia_id), INDEX IDX_AE9DBD1E7B7D6E92 (id_municipio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE configuracion_reglas_remesas (id INT AUTO_INCREMENT NOT NULL, id_pais_id INT NOT NULL, id_proveedor_id INT NOT NULL, id_unidad_id INT DEFAULT NULL, minimo DOUBLE PRECISION NOT NULL, maximo DOUBLE PRECISION NOT NULL, valor_fijo_costo DOUBLE PRECISION DEFAULT NULL, porciento_costo DOUBLE PRECISION DEFAULT NULL, valor_fijo_venta DOUBLE PRECISION DEFAULT NULL, porciento_venta DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2398566118997CB6 (id_pais_id), INDEX IDX_23985661E8F12801 (id_proveedor_id), INDEX IDX_239856611D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E7BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E18997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E6DB054DD FOREIGN KEY (id_provincia_id) REFERENCES provincias (id)');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E7B7D6E92 FOREIGN KEY (id_municipio_id) REFERENCES municipios (id)');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_2398566118997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_23985661E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_239856611D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE asiento ADD id_cotizacion_id INT DEFAULT NULL, ADD id_elemento_visa_id INT DEFAULT NULL, ADD orden_operacion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C8E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C4CC57875 FOREIGN KEY (id_elemento_visa_id) REFERENCES elementos_visa (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C8E5841CF ON asiento (id_cotizacion_id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C4CC57875 ON asiento (id_elemento_visa_id)');
        $this->addSql('ALTER TABLE cliente_beneficiario ADD id_pais INT NOT NULL');
        $this->addSql('ALTER TABLE cliente_solicitudes ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente_solicitudes ADD CONSTRAINT FK_D0874AE61D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_D0874AE61D34FA6B ON cliente_solicitudes (id_unidad_id)');
        $this->addSql('ALTER TABLE cotizacion ADD pagado TINYINT(1) DEFAULT NULL, ADD id_factura INT DEFAULT NULL, ADD fecha_factura DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE creditos_precio_venta ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creditos_precio_venta ADD CONSTRAINT FK_847FE8A91D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_847FE8A91D34FA6B ON creditos_precio_venta (id_unidad_id)');
        $this->addSql('ALTER TABLE elementos_visa ADD id_servicio_id INT DEFAULT NULL, ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E0469D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E041D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_90B65E0469D86E10 ON elementos_visa (id_servicio_id)');
        $this->addSql('CREATE INDEX IDX_90B65E041D34FA6B ON elementos_visa (id_unidad_id)');
        $this->addSql('ALTER TABLE pagos_cotizacion ADD nota VARCHAR(255) DEFAULT NULL, ADD id_transaccion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pais ADD activo TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE provincias ADD id_pais INT DEFAULT NULL');
        $this->addSql('ALTER TABLE solicitud ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_96D27CC01D34FA6B ON solicitud (id_unidad_id)');
        $this->addSql('ALTER TABLE unidad ADD id_moneda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('CREATE INDEX IDX_F3E6D02F374388F5 ON unidad (id_moneda_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beneficiarios_clientes');
        $this->addSql('DROP TABLE configuracion_reglas_remesas');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C8E5841CF');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C4CC57875');
        $this->addSql('DROP INDEX IDX_71D6D35C8E5841CF ON asiento');
        $this->addSql('DROP INDEX IDX_71D6D35C4CC57875 ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_cotizacion_id, DROP id_elemento_visa_id, DROP orden_operacion');
        $this->addSql('ALTER TABLE cliente_beneficiario DROP id_pais');
        $this->addSql('ALTER TABLE cliente_solicitudes DROP FOREIGN KEY FK_D0874AE61D34FA6B');
        $this->addSql('DROP INDEX IDX_D0874AE61D34FA6B ON cliente_solicitudes');
        $this->addSql('ALTER TABLE cliente_solicitudes DROP id_unidad_id');
        $this->addSql('ALTER TABLE cotizacion DROP pagado, DROP id_factura, DROP fecha_factura');
        $this->addSql('ALTER TABLE creditos_precio_venta DROP FOREIGN KEY FK_847FE8A91D34FA6B');
        $this->addSql('DROP INDEX IDX_847FE8A91D34FA6B ON creditos_precio_venta');
        $this->addSql('ALTER TABLE creditos_precio_venta DROP id_unidad_id');
        $this->addSql('ALTER TABLE elementos_visa DROP FOREIGN KEY FK_90B65E0469D86E10');
        $this->addSql('ALTER TABLE elementos_visa DROP FOREIGN KEY FK_90B65E041D34FA6B');
        $this->addSql('DROP INDEX IDX_90B65E0469D86E10 ON elementos_visa');
        $this->addSql('DROP INDEX IDX_90B65E041D34FA6B ON elementos_visa');
        $this->addSql('ALTER TABLE elementos_visa DROP id_servicio_id, DROP id_unidad_id');
        $this->addSql('ALTER TABLE pagos_cotizacion DROP nota, DROP id_transaccion');
        $this->addSql('ALTER TABLE pais DROP activo');
        $this->addSql('ALTER TABLE provincias DROP id_pais');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01D34FA6B');
        $this->addSql('DROP INDEX IDX_96D27CC01D34FA6B ON solicitud');
        $this->addSql('ALTER TABLE solicitud DROP id_unidad_id');
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F374388F5');
        $this->addSql('DROP INDEX IDX_F3E6D02F374388F5 ON unidad');
        $this->addSql('ALTER TABLE unidad DROP id_moneda_id');
    }
}
