<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102141245 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movimiento_activo_fijo (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_activo_fijo_id INT NOT NULL, id_tipo_movimiento_id INT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT NOT NULL, id_usuario_id INT NOT NULL, fecha DATE NOT NULL, fundamentacion VARCHAR(255) NOT NULL, entrada TINYINT(1) NOT NULL, nro_consecutivo INT NOT NULL, anno INT NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_A985A0DA1D34FA6B (id_unidad_id), INDEX IDX_A985A0DA5832E72E (id_activo_fijo_id), INDEX IDX_A985A0DADB763453 (id_tipo_movimiento_id), INDEX IDX_A985A0DA1ADA4D3F (id_cuenta_id), INDEX IDX_A985A0DA2D412F53 (id_subcuenta_id), INDEX IDX_A985A0DA7EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA5832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DADB763453 FOREIGN KEY (id_tipo_movimiento_id) REFERENCES tipo_movimiento (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE movimiento_activo_fijo ADD CONSTRAINT FK_A985A0DA7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EA1BE243F');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EE8F12801');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EEB3145A8');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EF66372E9');
        $this->addSql('DROP INDEX IDX_75EBC93EE8F12801 ON activo_fijo');
        $this->addSql('DROP INDEX IDX_75EBC93EF66372E9 ON activo_fijo');
        $this->addSql('DROP INDEX IDX_75EBC93EA1BE243F ON activo_fijo');
        $this->addSql('DROP INDEX IDX_75EBC93EEB3145A8 ON activo_fijo');
        $this->addSql('ALTER TABLE activo_fijo ADD id_tipo_movimiento_id INT NOT NULL, ADD id_area_responsabilidad_id INT NOT NULL, ADD nro_consecutivo INT NOT NULL, ADD nro_documento_baja INT DEFAULT NULL, ADD depreciacion_acumulada DOUBLE PRECISION DEFAULT NULL, ADD valor_real DOUBLE PRECISION DEFAULT NULL, ADD annos_vida_util DOUBLE PRECISION NOT NULL, ADD modelo VARCHAR(255) DEFAULT NULL, ADD tipo VARCHAR(255) DEFAULT NULL, ADD marca VARCHAR(255) DEFAULT NULL, ADD nro_motor VARCHAR(255) DEFAULT NULL, ADD nro_serie VARCHAR(255) DEFAULT NULL, ADD nro_chapa VARCHAR(255) DEFAULT NULL, ADD nro_chasis VARCHAR(255) DEFAULT NULL, ADD combustible VARCHAR(255) DEFAULT NULL, DROP id_proveedor_id, DROP id_cuenta_deprecia_id, DROP id_elemento_gasto_id, DROP nro_cuenta_deprecia, DROP baja, CHANGE id_tipo_documento_activo_id id_tipo_movimiento_baja_id INT DEFAULT NULL, CHANGE fecha fecha_alta DATE NOT NULL, CHANGE importe valor_inicial DOUBLE PRECISION NOT NULL, CHANGE motivo_baja pais VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EDB763453 FOREIGN KEY (id_tipo_movimiento_id) REFERENCES tipo_movimiento (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93E6FBA0327 FOREIGN KEY (id_tipo_movimiento_baja_id) REFERENCES tipo_movimiento (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93ED410562 FOREIGN KEY (id_area_responsabilidad_id) REFERENCES area_responsabilidad (id)');
        $this->addSql('CREATE INDEX IDX_75EBC93EDB763453 ON activo_fijo (id_tipo_movimiento_id)');
        $this->addSql('CREATE INDEX IDX_75EBC93E6FBA0327 ON activo_fijo (id_tipo_movimiento_baja_id)');
        $this->addSql('CREATE INDEX IDX_75EBC93ED410562 ON activo_fijo (id_area_responsabilidad_id)');
        $this->addSql('ALTER TABLE activo_fijo_cuentas ADD CONSTRAINT FK_E0DF2901A950EE53 FOREIGN KEY (id_centro_costo_gasto_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE activo_fijo_cuentas ADD CONSTRAINT FK_E0DF2901A752F04B FOREIGN KEY (id_elemento_gasto_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE area_responsabilidad ADD CONSTRAINT FK_F469C2BA1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE devolucion ADD id_centro_costo_id INT DEFAULT NULL, ADD id_elemento_gasto_id INT DEFAULT NULL, ADD id_orden_tabajo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F67C59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F67F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F675074DD86 FOREIGN KEY (id_orden_tabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('CREATE INDEX IDX_524D9F67C59B01FF ON devolucion (id_centro_costo_id)');
        $this->addSql('CREATE INDEX IDX_524D9F67F66372E9 ON devolucion (id_elemento_gasto_id)');
        $this->addSql('CREATE INDEX IDX_524D9F675074DD86 ON devolucion (id_orden_tabajo_id)');
        $this->addSql('ALTER TABLE factura CHANGE id_contrato id_contrato_id INT NOT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA00968BCB606 FOREIGN KEY (id_contrato_id) REFERENCES contratos_cliente (id)');
        $this->addSql('CREATE INDEX IDX_F9EBA00968BCB606 ON factura (id_contrato_id)');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F61ADA4D3F');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F62D412F53');
        $this->addSql('DROP INDEX IDX_50ADD6F61ADA4D3F ON grupo_activos');
        $this->addSql('DROP INDEX IDX_50ADD6F62D412F53 ON grupo_activos');
        $this->addSql('ALTER TABLE grupo_activos ADD codigo VARCHAR(255) NOT NULL, DROP id_cuenta_id, DROP id_subcuenta_id');
        $this->addSql('ALTER TABLE movimiento_venta ADD id_almacen_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_venta ADD CONSTRAINT FK_8E3F7AE539161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_8E3F7AE539161EBF ON movimiento_venta (id_almacen_id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEF5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE71381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('ALTER TABLE tipo_movimiento ADD codigo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movimiento_activo_fijo');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EDB763453');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93E6FBA0327');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93ED410562');
        $this->addSql('DROP INDEX IDX_75EBC93EDB763453 ON activo_fijo');
        $this->addSql('DROP INDEX IDX_75EBC93E6FBA0327 ON activo_fijo');
        $this->addSql('DROP INDEX IDX_75EBC93ED410562 ON activo_fijo');
        $this->addSql('ALTER TABLE activo_fijo ADD id_proveedor_id INT NOT NULL, ADD id_tipo_documento_activo_id INT DEFAULT NULL, ADD id_cuenta_deprecia_id INT NOT NULL, ADD id_elemento_gasto_id INT NOT NULL, ADD importe DOUBLE PRECISION NOT NULL, ADD nro_cuenta_deprecia VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD baja TINYINT(1) DEFAULT NULL, ADD motivo_baja VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP id_tipo_movimiento_id, DROP id_tipo_movimiento_baja_id, DROP id_area_responsabilidad_id, DROP nro_consecutivo, DROP nro_documento_baja, DROP valor_inicial, DROP depreciacion_acumulada, DROP valor_real, DROP annos_vida_util, DROP pais, DROP modelo, DROP tipo, DROP marca, DROP nro_motor, DROP nro_serie, DROP nro_chapa, DROP nro_chasis, DROP combustible, CHANGE fecha_alta fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EA1BE243F FOREIGN KEY (id_tipo_documento_activo_id) REFERENCES tipo_documento_activo_fijo (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EEB3145A8 FOREIGN KEY (id_cuenta_deprecia_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('CREATE INDEX IDX_75EBC93EE8F12801 ON activo_fijo (id_proveedor_id)');
        $this->addSql('CREATE INDEX IDX_75EBC93EF66372E9 ON activo_fijo (id_elemento_gasto_id)');
        $this->addSql('CREATE INDEX IDX_75EBC93EA1BE243F ON activo_fijo (id_tipo_documento_activo_id)');
        $this->addSql('CREATE INDEX IDX_75EBC93EEB3145A8 ON activo_fijo (id_cuenta_deprecia_id)');
        $this->addSql('ALTER TABLE activo_fijo_cuentas DROP FOREIGN KEY FK_E0DF2901A950EE53');
        $this->addSql('ALTER TABLE activo_fijo_cuentas DROP FOREIGN KEY FK_E0DF2901A752F04B');
        $this->addSql('ALTER TABLE area_responsabilidad DROP FOREIGN KEY FK_F469C2BA1D34FA6B');
        $this->addSql('ALTER TABLE devolucion DROP FOREIGN KEY FK_524D9F67C59B01FF');
        $this->addSql('ALTER TABLE devolucion DROP FOREIGN KEY FK_524D9F67F66372E9');
        $this->addSql('ALTER TABLE devolucion DROP FOREIGN KEY FK_524D9F675074DD86');
        $this->addSql('DROP INDEX IDX_524D9F67C59B01FF ON devolucion');
        $this->addSql('DROP INDEX IDX_524D9F67F66372E9 ON devolucion');
        $this->addSql('DROP INDEX IDX_524D9F675074DD86 ON devolucion');
        $this->addSql('ALTER TABLE devolucion DROP id_centro_costo_id, DROP id_elemento_gasto_id, DROP id_orden_tabajo_id');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA00968BCB606');
        $this->addSql('DROP INDEX IDX_F9EBA00968BCB606 ON factura');
        $this->addSql('ALTER TABLE factura CHANGE id_contrato_id id_contrato INT NOT NULL');
        $this->addSql('ALTER TABLE grupo_activos ADD id_cuenta_id INT NOT NULL, ADD id_subcuenta_id INT DEFAULT NULL, DROP codigo');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F61ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F62D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('CREATE INDEX IDX_50ADD6F61ADA4D3F ON grupo_activos (id_cuenta_id)');
        $this->addSql('CREATE INDEX IDX_50ADD6F62D412F53 ON grupo_activos (id_subcuenta_id)');
        $this->addSql('ALTER TABLE movimiento_venta DROP FOREIGN KEY FK_8E3F7AE539161EBF');
        $this->addSql('DROP INDEX IDX_8E3F7AE539161EBF ON movimiento_venta');
        $this->addSql('ALTER TABLE movimiento_venta DROP id_almacen_id');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE1ADA4D3F');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE2D412F53');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEC59B01FF');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEF66372E9');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE39161EBF');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE1D34FA6B');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEE8F12801');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEF5DBAF2B');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE71381BB3');
        $this->addSql('ALTER TABLE tipo_movimiento DROP codigo');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
    }
}
