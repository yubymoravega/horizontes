<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023012616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cuadre_diario (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT NOT NULL, id_cierre_id INT NOT NULL, str_analisis VARCHAR(255) DEFAULT NULL, fecha DATE NOT NULL, saldo NUMERIC(10, 2) NOT NULL, debito DOUBLE PRECISION NOT NULL, credito DOUBLE PRECISION NOT NULL, INDEX IDX_60ABEFD91ADA4D3F (id_cuenta_id), INDEX IDX_60ABEFD92D412F53 (id_subcuenta_id), INDEX IDX_60ABEFD945F8C94C (id_cierre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD91ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD92D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD945F8C94C FOREIGN KEY (id_cierre_id) REFERENCES cierre (id)');
        $this->addSql('ALTER TABLE cuenta_criterio_analisis ADD orden INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depreciacion ADD CONSTRAINT FK_D618AE145832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F676601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F671D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F6739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC71D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC7374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF521D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52D1E12F15 FOREIGN KEY (id_cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF527EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE expediente ADD CONSTRAINT FK_D59CA4131D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0091D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA0097EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F61ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE grupo_activos ADD CONSTRAINT FK_50ADD6F62D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBD6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE informe_recepcion ADD CONSTRAINT FK_62A4EBDE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE mercancia ADD CONSTRAINT FK_9D094AE0E2C70A62 FOREIGN KEY (id_amlacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE mercancia ADD CONSTRAINT FK_9D094AE0E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF59F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE mercancia_producto ADD CONSTRAINT FK_3F705CF56E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107AD1CE493D FOREIGN KEY (id_tipo_documento_activo_fijo_id) REFERENCES tipo_documento_activo_fijo (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107ADB763453 FOREIGN KEY (id_tipo_movimiento_id) REFERENCES tipo_movimiento (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107A873C7FC7 FOREIGN KEY (id_unidad_origen_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107A4F781EA FOREIGN KEY (id_unidad_destino_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD79F287F54 FOREIGN KEY (id_mercancia_id) REFERENCES mercancia (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD76601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD77EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7C59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7F5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD771381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC6E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC7A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE movimiento_venta ADD CONSTRAINT FK_8E3F7AE555C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE obligacion_cobro ADD CONSTRAINT FK_807C726D55C5F988 FOREIGN KEY (id_factura_id) REFERENCES factura (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3BE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3B6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE obligacion_pago ADD CONSTRAINT FK_403C9B3B1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE orden_trabajo ADD CONSTRAINT FK_4158A0241D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE orden_trabajo ADD CONSTRAINT FK_4158A02439161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E2C70A62 FOREIGN KEY (id_amlacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B21D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B2EF5F7851 FOREIGN KEY (id_tipo_comprobante_id) REFERENCES tipo_comprobante (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B27EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B239161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE subcuenta ADD CONSTRAINT FK_57BB37EA1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7682D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7685ABBE5F6 FOREIGN KEY (id_criterio_analisis_id) REFERENCES criterio_analisis (id)');
        $this->addSql('ALTER TABLE subcuenta_proveedor ADD CONSTRAINT FK_5C22E4B82D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_proveedor ADD CONSTRAINT FK_5C22E4B8E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606FA5CADE9 FOREIGN KEY (id_moneda_origen_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606D85CECF7 FOREIGN KEY (id_moneda_destino_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227306601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227301D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC2273039161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F31E700CD FOREIGN KEY (id_padre_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cuadre_diario');
        $this->addSql('ALTER TABLE cuenta_criterio_analisis DROP orden');
        $this->addSql('ALTER TABLE depreciacion DROP FOREIGN KEY FK_D618AE145832E72E');
        $this->addSql('ALTER TABLE devolucion DROP FOREIGN KEY FK_524D9F676601BA07');
        $this->addSql('ALTER TABLE devolucion DROP FOREIGN KEY FK_524D9F671D34FA6B');
        $this->addSql('ALTER TABLE devolucion DROP FOREIGN KEY FK_524D9F6739161EBF');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC739161EBF');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC71D34FA6B');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC7374388F5');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC77A4F962');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF521D34FA6B');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52D1E12F15');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF527EB2C349');
        $this->addSql('ALTER TABLE expediente DROP FOREIGN KEY FK_D59CA4131D34FA6B');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA0091D34FA6B');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA0097EB2C349');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F61ADA4D3F');
        $this->addSql('ALTER TABLE grupo_activos DROP FOREIGN KEY FK_50ADD6F62D412F53');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBD6601BA07');
        $this->addSql('ALTER TABLE informe_recepcion DROP FOREIGN KEY FK_62A4EBDE8F12801');
        $this->addSql('ALTER TABLE mercancia DROP FOREIGN KEY FK_9D094AE0E2C70A62');
        $this->addSql('ALTER TABLE mercancia DROP FOREIGN KEY FK_9D094AE0E16A5625');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF59F287F54');
        $this->addSql('ALTER TABLE mercancia_producto DROP FOREIGN KEY FK_3F705CF56E57A479');
        $this->addSql('ALTER TABLE movimiento DROP FOREIGN KEY FK_C8FF107AD1CE493D');
        $this->addSql('ALTER TABLE movimiento DROP FOREIGN KEY FK_C8FF107ADB763453');
        $this->addSql('ALTER TABLE movimiento DROP FOREIGN KEY FK_C8FF107A873C7FC7');
        $this->addSql('ALTER TABLE movimiento DROP FOREIGN KEY FK_C8FF107A4F781EA');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD79F287F54');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD76601BA07');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD77A4F962');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD77EB2C349');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7C59B01FF');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7F66372E9');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD739161EBF');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7F5DBAF2B');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD771381BB3');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC6E57A479');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC6601BA07');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC7A4F962');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC7EB2C349');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFCC59B01FF');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFCF66372E9');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC39161EBF');
        $this->addSql('ALTER TABLE movimiento_venta DROP FOREIGN KEY FK_8E3F7AE555C5F988');
        $this->addSql('ALTER TABLE obligacion_cobro DROP FOREIGN KEY FK_807C726D55C5F988');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3BE8F12801');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3B6601BA07');
        $this->addSql('ALTER TABLE obligacion_pago DROP FOREIGN KEY FK_403C9B3B1D34FA6B');
        $this->addSql('ALTER TABLE orden_trabajo DROP FOREIGN KEY FK_4158A0241D34FA6B');
        $this->addSql('ALTER TABLE orden_trabajo DROP FOREIGN KEY FK_4158A02439161EBF');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E2C70A62');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E16A5625');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B21D34FA6B');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B2EF5F7851');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B27EB2C349');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B239161EBF');
        $this->addSql('ALTER TABLE subcuenta DROP FOREIGN KEY FK_57BB37EA1ADA4D3F');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis DROP FOREIGN KEY FK_52A4A7682D412F53');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis DROP FOREIGN KEY FK_52A4A7685ABBE5F6');
        $this->addSql('ALTER TABLE subcuenta_proveedor DROP FOREIGN KEY FK_5C22E4B82D412F53');
        $this->addSql('ALTER TABLE subcuenta_proveedor DROP FOREIGN KEY FK_5C22E4B8E8F12801');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606FA5CADE9');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606D85CECF7');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227306601BA07');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227301D34FA6B');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC2273039161EBF');
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F31E700CD');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
    }
}
