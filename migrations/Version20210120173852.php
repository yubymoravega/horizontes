<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210120173852 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE inposdom_cierre (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, json VARCHAR(1000) NOT NULL, empleado VARCHAR(255) NOT NULL, dop VARCHAR(255) DEFAULT NULL, usd VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // this up() migration is auto-generated, please modify it to your needs
       /* $this->addSql('CREATE TABLE acumulado_vacaciones (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, dias DOUBLE PRECISION NOT NULL, dinero DOUBLE PRECISION NOT NULL, INDEX IDX_246B9D168D392AC7 (id_empleado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comprobante_movimiento_activo_fijo (id INT AUTO_INCREMENT NOT NULL, id_registro_comprobante_id INT NOT NULL, id_movimiento_activo_id INT NOT NULL, id_unidad_id INT NOT NULL, anno INT NOT NULL, INDEX IDX_81F5096A1399A3CF (id_registro_comprobante_id), INDEX IDX_81F5096A9D00B230 (id_movimiento_activo_id), INDEX IDX_81F5096A1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('CREATE TABLE periodo_sistema (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_almacen_id INT DEFAULT NULL, id_usuario_id INT NOT NULL, mes INT NOT NULL, anno INT NOT NULL, tipo INT NOT NULL, fecha DATE NOT NULL, cerrado TINYINT(1) NOT NULL, INDEX IDX_AEF0BAAD1D34FA6B (id_unidad_id), INDEX IDX_AEF0BAAD39161EBF (id_almacen_id), INDEX IDX_AEF0BAAD7EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacaciones_disfrutadas (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, cantidad_dias INT NOT NULL, cantidad_pagada DOUBLE PRECISION NOT NULL, fecha_inicio DATE DEFAULT NULL, fecha_fin DATE DEFAULT NULL, INDEX IDX_F02817318D392AC7 (id_empleado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acumulado_vacaciones ADD CONSTRAINT FK_246B9D168D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A1399A3CF FOREIGN KEY (id_registro_comprobante_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A9D00B230 FOREIGN KEY (id_movimiento_activo_id) REFERENCES movimiento_activo_fijo (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE periodo_sistema ADD CONSTRAINT FK_AEF0BAAD1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE periodo_sistema ADD CONSTRAINT FK_AEF0BAAD39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE periodo_sistema ADD CONSTRAINT FK_AEF0BAAD7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vacaciones_disfrutadas ADD CONSTRAINT FK_F02817318D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
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
        $this->addSql('ALTER TABLE cobros_pagos ADD id_movimiento_activo_fijo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cobros_pagos ADD CONSTRAINT FK_D9581D167786CA71 FOREIGN KEY (id_movimiento_activo_fijo_id) REFERENCES movimiento_activo_fijo (id)');
        $this->addSql('CREATE INDEX IDX_D9581D167786CA71 ON cobros_pagos (id_movimiento_activo_fijo_id)');
        $this->addSql('ALTER TABLE empleado ADD identificacion VARCHAR(255) NOT NULL, DROP salario_x_hora');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD id_unidad_destino_origen_id INT DEFAULT NULL, ADD id_proveedor_id INT DEFAULT NULL, ADD id_movimiento_cancelado_id INT DEFAULT NULL, ADD id_tipo_cliente INT DEFAULT NULL, ADD id_cliente INT DEFAULT NULL, ADD cancelado TINYINT(1) DEFAULT NULL, ADD fecha_factura DATE DEFAULT NULL, ADD nro_factura VARCHAR(255) DEFAULT NULL');
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
    /*    // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE acumulado_vacaciones');
        $this->addSql('DROP TABLE comprobante_movimiento_activo_fijo');
        $this->addSql('DROP TABLE inposdom_cierre');
        $this->addSql('DROP TABLE periodo_sistema');
        $this->addSql('DROP TABLE vacaciones_disfrutadas');
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
        $this->addSql('ALTER TABLE cobros_pagos DROP FOREIGN KEY FK_D9581D167786CA71');
        $this->addSql('DROP INDEX IDX_D9581D167786CA71 ON cobros_pagos');
        $this->addSql('ALTER TABLE cobros_pagos DROP id_movimiento_activo_fijo_id');
        $this->addSql('ALTER TABLE empleado ADD salario_x_hora DOUBLE PRECISION DEFAULT NULL, DROP identificacion');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP FOREIGN KEY FK_A985A0DA4B1CE99D');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP FOREIGN KEY FK_A985A0DAE8F12801');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP FOREIGN KEY FK_A985A0DA571159DE');
        $this->addSql('DROP INDEX IDX_A985A0DA4B1CE99D ON movimiento_activo_fijo');
        $this->addSql('DROP INDEX IDX_A985A0DAE8F12801 ON movimiento_activo_fijo');
        $this->addSql('DROP INDEX IDX_A985A0DA571159DE ON movimiento_activo_fijo');
        $this->addSql('ALTER TABLE movimiento_activo_fijo DROP id_unidad_destino_origen_id, DROP id_proveedor_id, DROP id_movimiento_cancelado_id, DROP id_tipo_cliente, DROP id_cliente, DROP cancelado, DROP fecha_factura, DROP nro_factura');
        $this->addSql('ALTER TABLE saldo_cuentas DROP tipo_cliente, DROP id_cliente');*/
    }
}
