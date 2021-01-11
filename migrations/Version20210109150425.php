<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210109150425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orden_trabajo CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE orden_trabajo ADD CONSTRAINT FK_4158A0241D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE orden_trabajo ADD CONSTRAINT FK_4158A02439161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE pais CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE producto CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E2C70A62 FOREIGN KEY (id_amlacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('ALTER TABLE proveedor CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE provincias CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE registro_comprobantes CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B21D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B2EF5F7851 FOREIGN KEY (id_tipo_comprobante_id) REFERENCES tipo_comprobante (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B27EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B239161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE reglas_remesas CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rent_entrega CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rent_recogida CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reporte_efectivo CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE saldo_cuentas CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEF5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE71381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('ALTER TABLE solicitud_turismo CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE solicitud_turismo_comentario CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE stripe_factura CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta ADD CONSTRAINT FK_57BB37EA1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7682D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7685ABBE5F6 FOREIGN KEY (id_criterio_analisis_id) REFERENCES criterio_analisis (id)');
        $this->addSql('ALTER TABLE subcuenta_proveedor CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta_proveedor ADD CONSTRAINT FK_5C22E4B82D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_proveedor ADD CONSTRAINT FK_5C22E4B8E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE tasa_cambio CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606FA5CADE9 FOREIGN KEY (id_moneda_origen_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE tasa_cambio ADD CONSTRAINT FK_DAB48606D85CECF7 FOREIGN KEY (id_moneda_destino_id) REFERENCES moneda (id)');
        $this->addSql('ALTER TABLE tasa_de_cambio CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE test_crud CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tipo_cuenta CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tipo_documento_activo_fijo CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tour_nombre CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transfer_destino CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transfer_origen CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transferencia CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227306601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC227301D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC2273039161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE trasacciones CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE unidad CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F31E700CD FOREIGN KEY (id_padre_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE user CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE vale_salida CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE vuelo_destino CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE vuelo_origen CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orden_trabajo DROP FOREIGN KEY FK_4158A0241D34FA6B');
        $this->addSql('ALTER TABLE orden_trabajo DROP FOREIGN KEY FK_4158A02439161EBF');
        $this->addSql('ALTER TABLE orden_trabajo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE pais CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E2C70A62');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E16A5625');
        $this->addSql('ALTER TABLE producto CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE proveedor CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE provincias CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B21D34FA6B');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B2EF5F7851');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B27EB2C349');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B239161EBF');
        $this->addSql('ALTER TABLE registro_comprobantes CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reglas_remesas CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE rent_entrega CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE rent_recogida CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reporte_efectivo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE1ADA4D3F');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE2D412F53');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEC59B01FF');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEF66372E9');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE39161EBF');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE1D34FA6B');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEE8F12801');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AEF5DBAF2B');
        $this->addSql('ALTER TABLE saldo_cuentas DROP FOREIGN KEY FK_BB2B71AE71381BB3');
        $this->addSql('ALTER TABLE saldo_cuentas CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE solicitud_turismo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE solicitud_turismo_comentario CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE stripe_factura CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta DROP FOREIGN KEY FK_57BB37EA1ADA4D3F');
        $this->addSql('ALTER TABLE subcuenta CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis DROP FOREIGN KEY FK_52A4A7682D412F53');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis DROP FOREIGN KEY FK_52A4A7685ABBE5F6');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE subcuenta_proveedor DROP FOREIGN KEY FK_5C22E4B82D412F53');
        $this->addSql('ALTER TABLE subcuenta_proveedor DROP FOREIGN KEY FK_5C22E4B8E8F12801');
        $this->addSql('ALTER TABLE subcuenta_proveedor CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606FA5CADE9');
        $this->addSql('ALTER TABLE tasa_cambio DROP FOREIGN KEY FK_DAB48606D85CECF7');
        $this->addSql('ALTER TABLE tasa_cambio CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tasa_de_cambio CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE test_crud CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tipo_cuenta CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tipo_documento_activo_fijo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tour_nombre CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE transfer_destino CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE transfer_origen CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227306601BA07');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC227301D34FA6B');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC2273039161EBF');
        $this->addSql('ALTER TABLE transferencia CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE trasacciones CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F31E700CD');
        $this->addSql('ALTER TABLE unidad CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
        $this->addSql('ALTER TABLE vale_salida CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE vuelo_destino CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE vuelo_origen CHANGE id id INT NOT NULL');
    }
}
