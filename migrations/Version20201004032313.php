<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201004032313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente_contabilidad (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, direccion VARCHAR(255) NOT NULL, telefonos VARCHAR(255) NOT NULL, fax VARCHAR(255) NOT NULL, correos VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contratos_cliente (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_moneda_id INT NOT NULL, nro_contrato VARCHAR(255) NOT NULL, anno INT NOT NULL, fecha_aprobado DATE NOT NULL, fecha_vencimiento DATE DEFAULT NULL, activo TINYINT(1) NOT NULL, importe DOUBLE PRECISION NOT NULL, INDEX IDX_29A5BB477BF9CE86 (id_cliente_id), INDEX IDX_29A5BB47374388F5 (id_moneda_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuentas_cliente (id INT AUTO_INCREMENT NOT NULL, id_moneda_id INT NOT NULL, id_cliente_id INT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_64653310374388F5 (id_moneda_id), INDEX IDX_646533107BF9CE86 (id_cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contratos_cliente ADD CONSTRAINT FK_29A5BB477BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente_contabilidad (id)');
        $this->addSql('ALTER TABLE contratos_cliente ADD CONSTRAINT FK_29A5BB47374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE cuentas_cliente ADD CONSTRAINT FK_64653310374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE cuentas_cliente ADD CONSTRAINT FK_646533107BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente_contabilidad (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contratos_cliente DROP FOREIGN KEY FK_29A5BB477BF9CE86');
        $this->addSql('ALTER TABLE cuentas_cliente DROP FOREIGN KEY FK_646533107BF9CE86');
        $this->addSql('DROP TABLE cliente_contabilidad');
        $this->addSql('DROP TABLE contratos_cliente');
        $this->addSql('DROP TABLE cuentas_cliente');
    }
}
