<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210107194537 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
       /* $this->addSql('CREATE TABLE comprobante_movimiento_activo_fijo (id INT AUTO_INCREMENT NOT NULL, id_registro_comprobante_id INT NOT NULL, id_movimiento_activo_id INT NOT NULL, id_unidad_id INT NOT NULL, anno INT NOT NULL, INDEX IDX_81F5096A1399A3CF (id_registro_comprobante_id), INDEX IDX_81F5096A9D00B230 (id_movimiento_activo_id), INDEX IDX_81F5096A1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A1399A3CF FOREIGN KEY (id_registro_comprobante_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A9D00B230 FOREIGN KEY (id_movimiento_activo_id) REFERENCES movimiento_activo_fijo (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE activo_fijo_cuentas ADD id_cuenta_acreedora_id INT DEFAULT NULL, ADD id_subcuenta_acreedora_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE activo_fijo_cuentas ADD CONSTRAINT FK_E0DF29014D7B4AB9 FOREIGN KEY (id_cuenta_acreedora_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE activo_fijo_cuentas ADD CONSTRAINT FK_E0DF2901EB1B341E FOREIGN KEY (id_subcuenta_acreedora_id) REFERENCES subcuenta (id)');
        $this->addSql('CREATE INDEX IDX_E0DF29014D7B4AB9 ON activo_fijo_cuentas (id_cuenta_acreedora_id)');
        $this->addSql('CREATE INDEX IDX_E0DF2901EB1B341E ON activo_fijo_cuentas (id_subcuenta_acreedora_id)');
        $this->addSql('ALTER TABLE asiento ADD id_activo_fijo_id INT DEFAULT NULL, ADD id_area_responsabilidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C5832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CD410562 FOREIGN KEY (id_area_responsabilidad_id) REFERENCES area_responsabilidad (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C5832E72E ON asiento (id_activo_fijo_id)');
        $this->addSql('CREATE INDEX IDX_71D6D35CD410562 ON asiento (id_area_responsabilidad_id)');
       */ $this->addSql('ALTER TABLE factura_imposdom ADD fecha DATETIME NOT NULL');/*
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD id_unidad_destino_origen_id INT DEFAULT NULL, ADD id_proveedor_id INT DEFAULT NULL, ADD id_movimiento_cancelado_id INT DEFAULT NULL, ADD id_tipo_cliente INT DEFAULT NULL, ADD id_cliente INT DEFAULT NULL, ADD cancelado TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA4B1CE99D FOREIGN KEY (id_unidad_destino_origen_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DAE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA571159DE FOREIGN KEY (id_movimiento_cancelado_id) REFERENCES movimiento_activo_fijo (id)');
        $this->addSql('CREATE INDEX IDX_A985A0DA4B1CE99D ON movimiento_activo_fijo (id_unidad_destino_origen_id)');
        $this->addSql('CREATE INDEX IDX_A985A0DAE8F12801 ON movimiento_activo_fijo (id_proveedor_id)');
        $this->addSql('CREATE INDEX IDX_A985A0DA571159DE ON movimiento_activo_fijo (id_movimiento_cancelado_id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD tipo_cliente INT DEFAULT NULL, ADD id_cliente INT DEFAULT NULL');*/
    }

    public function down(Schema $schema) : void
    {
        /*// this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comprobante_movimiento_activo_fijo');
        $this->addSql('ALTER TABLE activo_fijo_cuentas DROP FOREIGN KEY FK_E0DF29014D7B4AB9');
        $this->addSql('ALTER TABLE activo_fijo_cuentas DROP FOREIGN KEY FK_E0DF2901EB1B341E');
        $this->addSql('DROP INDEX IDX_E0DF29014D7B4AB9 ON activo_fijo_cuentas');
        $this->addSql('DROP INDEX IDX_E0DF2901EB1B341E ON activo_fijo_cuentas');
        $this->addSql('ALTER TABLE activo_fijo_cuentas DROP id_cuenta_acreedora_id, DROP id_subcuenta_acreedora_id');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C5832E72E');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35CD410562');
        $this->addSql('DROP INDEX IDX_71D6D35C5832E72E ON asiento');
        $this->addSql('DROP INDEX IDX_71D6D35CD410562 ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_activo_fijo_id, DROP id_area_responsabilidad_id');
        $this->addSql('ALTER TABLE factura_imposdom DROP fecha');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP FOREIGN KEY FK_A985A0DA4B1CE99D');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP FOREIGN KEY FK_A985A0DAE8F12801');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP FOREIGN KEY FK_A985A0DA571159DE');
        $this->addSql('DROP INDEX IDX_A985A0DA4B1CE99D ON movimiento_activo_fijo');
        $this->addSql('DROP INDEX IDX_A985A0DAE8F12801 ON movimiento_activo_fijo');
        $this->addSql('DROP INDEX IDX_A985A0DA571159DE ON movimiento_activo_fijo');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP id_unidad_destino_origen_id, DROP id_proveedor_id, DROP id_movimiento_cancelado_id, DROP id_tipo_cliente, DROP id_cliente, DROP cancelado');
        $this->addSql('ALTER TABLE saldo_cuentas DROP tipo_cliente, DROP id_cliente');*/
    }
}
