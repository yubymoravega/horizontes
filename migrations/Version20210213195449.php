<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210213195449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agencias_img (id INT AUTO_INCREMENT NOT NULL, id_unidad VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agencias_tv (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(1000) NOT NULL, nombre_tv VARCHAR(255) NOT NULL, id_unidad VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banco (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuentas_unidad (id INT AUTO_INCREMENT NOT NULL, id_banco_id INT NOT NULL, id_unidad_id INT NOT NULL, id_moneda_id INT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_355374209CDF4BAB (id_banco_id), INDEX IDX_355374201D34FA6B (id_unidad_id), INDEX IDX_35537420374388F5 (id_moneda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pagos_cotizacion (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, id_empleado INT NOT NULL, monto INT NOT NULL, cambio INT DEFAULT NULL, id_cotizacion INT NOT NULL, id_moneda INT NOT NULL, id_tipo_de_pago INT NOT NULL, id_banco INT DEFAULT NULL, id_cuenta_bancaria INT DEFAULT NULL, numero_confirmacion_deposito VARCHAR(255) DEFAULT NULL, last4_tarjeta INT DEFAULT NULL, codigo_confirmacion_tarjeta VARCHAR(255) DEFAULT NULL, tipo_de_tarjeta VARCHAR(255) DEFAULT NULL, nota VARCHAR(255) DEFAULT NULL, id_transaccion INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuentas_unidad ADD CONSTRAINT FK_355374209CDF4BAB FOREIGN KEY (id_banco_id) REFERENCES banco (id)');
        $this->addSql('ALTER TABLE cuentas_unidad ADD CONSTRAINT FK_355374201D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE cuentas_unidad ADD CONSTRAINT FK_35537420374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE asiento ADD id_cotizacion_id INT DEFAULT NULL, ADD id_elemento_visa_id INT DEFAULT NULL, ADD orden_operacion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C8E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C4CC57875 FOREIGN KEY (id_elemento_visa_id) REFERENCES elementos_visa (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C8E5841CF ON asiento (id_cotizacion_id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C4CC57875 ON asiento (id_elemento_visa_id)');
        $this->addSql('ALTER TABLE cotizacion ADD pagado TINYINT(1) DEFAULT NULL, ADD id_factura INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuentas_cliente ADD id_banco_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuentas_cliente ADD CONSTRAINT FK_646533109CDF4BAB FOREIGN KEY (id_banco_id) REFERENCES banco (id)');
        $this->addSql('CREATE INDEX IDX_646533109CDF4BAB ON cuentas_cliente (id_banco_id)');
        $this->addSql('ALTER TABLE elementos_visa ADD id_servicio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E0469D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('CREATE INDEX IDX_90B65E0469D86E10 ON elementos_visa (id_servicio_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuentas_cliente DROP FOREIGN KEY FK_646533109CDF4BAB');
        $this->addSql('ALTER TABLE cuentas_unidad DROP FOREIGN KEY FK_355374209CDF4BAB');
        $this->addSql('DROP TABLE agencias_img');
        $this->addSql('DROP TABLE agencias_tv');
        $this->addSql('DROP TABLE banco');
        $this->addSql('DROP TABLE cuentas_unidad');
        $this->addSql('DROP TABLE pagos_cotizacion');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C8E5841CF');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C4CC57875');
        $this->addSql('DROP INDEX IDX_71D6D35C8E5841CF ON asiento');
        $this->addSql('DROP INDEX IDX_71D6D35C4CC57875 ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_cotizacion_id, DROP id_elemento_visa_id, DROP orden_operacion');
        $this->addSql('ALTER TABLE cotizacion DROP pagado, DROP id_factura');
        $this->addSql('DROP INDEX IDX_646533109CDF4BAB ON cuentas_cliente');
        $this->addSql('ALTER TABLE cuentas_cliente DROP id_banco_id');
        $this->addSql('ALTER TABLE elementos_visa DROP FOREIGN KEY FK_90B65E0469D86E10');
        $this->addSql('DROP INDEX IDX_90B65E0469D86E10 ON elementos_visa');
        $this->addSql('ALTER TABLE elementos_visa DROP id_servicio_id');
    }
}
