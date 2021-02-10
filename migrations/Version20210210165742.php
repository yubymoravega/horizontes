<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210165742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE banco (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuentas_unidad (id INT AUTO_INCREMENT NOT NULL, id_banco_id INT NOT NULL, id_unidad_id INT NOT NULL, id_moneda_id INT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_355374209CDF4BAB (id_banco_id), INDEX IDX_355374201D34FA6B (id_unidad_id), INDEX IDX_35537420374388F5 (id_moneda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pagos_cotizacion (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, id_empleado INT NOT NULL, monto INT NOT NULL, cambio INT DEFAULT NULL, id_cotizacion INT NOT NULL, id_moneda INT NOT NULL, id_tipo_de_pago INT NOT NULL, id_banco INT DEFAULT NULL, id_cuenta_bancaria INT DEFAULT NULL, numero_confirmacion_deposito VARCHAR(255) DEFAULT NULL, last4_tarjeta INT DEFAULT NULL, codigo_confirmacion_tarjeta VARCHAR(255) DEFAULT NULL, tipo_de_tarjeta VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuentas_unidad ADD CONSTRAINT FK_355374209CDF4BAB FOREIGN KEY (id_banco_id) REFERENCES banco (id)');
        $this->addSql('ALTER TABLE cuentas_unidad ADD CONSTRAINT FK_355374201D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE cuentas_unidad ADD CONSTRAINT FK_35537420374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE carrito CHANGE json json VARCHAR(1500) NOT NULL');
        $this->addSql('ALTER TABLE cuentas_cliente ADD id_banco_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuentas_cliente ADD CONSTRAINT FK_646533109CDF4BAB FOREIGN KEY (id_banco_id) REFERENCES banco (id)');
        $this->addSql('CREATE INDEX IDX_646533109CDF4BAB ON cuentas_cliente (id_banco_id)');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuentas_cliente DROP FOREIGN KEY FK_646533109CDF4BAB');
        $this->addSql('ALTER TABLE cuentas_unidad DROP FOREIGN KEY FK_355374209CDF4BAB');
        $this->addSql('DROP TABLE banco');
        $this->addSql('DROP TABLE cuentas_unidad');
        $this->addSql('DROP TABLE pagos_cotizacion');
        $this->addSql('ALTER TABLE carrito CHANGE json json VARCHAR(15000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_646533109CDF4BAB ON cuentas_cliente');
        $this->addSql('ALTER TABLE cuentas_cliente DROP id_banco_id');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
