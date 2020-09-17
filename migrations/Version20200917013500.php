<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917013500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depreciacion (id INT AUTO_INCREMENT NOT NULL, id_activo_fijo_id INT NOT NULL, fecha DATE NOT NULL, anno INT NOT NULL, mes INT NOT NULL, importe_depreciacion DOUBLE PRECISION NOT NULL, INDEX IDX_D618AE145832E72E (id_activo_fijo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimiento (id INT AUTO_INCREMENT NOT NULL, id_tipo_documento_activo_fijo_id INT NOT NULL, id_tipo_movimiento_id INT NOT NULL, id_unidad_origen_id INT NOT NULL, id_unidad_destino_id INT NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_C8FF107AD1CE493D (id_tipo_documento_activo_fijo_id), INDEX IDX_C8FF107ADB763453 (id_tipo_movimiento_id), INDEX IDX_C8FF107A873C7FC7 (id_unidad_origen_id), INDEX IDX_C8FF107A4F781EA (id_unidad_destino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stripe_factura (id INT AUTO_INCREMENT NOT NULL, auth VARCHAR(255) NOT NULL, estatus VARCHAR(255) NOT NULL, cliente_id VARCHAR(255) NOT NULL, id_empleado VARCHAR(255) NOT NULL, monto VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depreciacion ADD CONSTRAINT FK_D618AE145832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107AD1CE493D FOREIGN KEY (id_tipo_documento_activo_fijo_id) REFERENCES tipo_documento_activo_fijo (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107ADB763453 FOREIGN KEY (id_tipo_movimiento_id) REFERENCES tipo_movimiento (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107A873C7FC7 FOREIGN KEY (id_unidad_origen_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento ADD CONSTRAINT FK_C8FF107A4F781EA FOREIGN KEY (id_unidad_destino_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93E1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93E4A667A2B FOREIGN KEY (id_grupo_activo_id) REFERENCES grupo_activos (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EA1BE243F FOREIGN KEY (id_tipo_documento_activo_id) REFERENCES tipo_documento_activo_fijo (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EEB3145A8 FOREIGN KEY (id_cuenta_deprecia_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE activo_fijo ADD CONSTRAINT FK_75EBC93EF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo ADD CONSTRAINT FK_2FA61FF25832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo ADD CONSTRAINT FK_2FA61FF27786CA71 FOREIGN KEY (id_movimiento_activo_fijo_id) REFERENCES movimiento (id)');
        $this->addSql('ALTER TABLE ajuste DROP INDEX UNIQ_DD35BD326601BA07, ADD INDEX IDX_DD35BD326601BA07 (id_documento_id)');
        $this->addSql('ALTER TABLE ajuste ADD nro_cuenta_inventario VARCHAR(255) NOT NULL, ADD observacion VARCHAR(255) NOT NULL, ADD nro_subcuenta_inventario VARCHAR(255) NOT NULL, ADD nro_cuenta_acreedora VARCHAR(255) NOT NULL, ADD nro_concecutivo VARCHAR(255) NOT NULL, ADD anno INT NOT NULL, ADD entrada TINYINT(1) NOT NULL, CHANGE is_salida activo TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE centro_costo ADD id_elemento_gasto LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE cliente_reporte ADD efectivo VARCHAR(255) DEFAULT NULL, CHANGE fecha fecha DATETIME NOT NULL');
        $this->addSql('ALTER TABLE mercancia ADD cuenta VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE modulo CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD id_centro_costo_id INT DEFAULT NULL, ADD id_elemento_gasto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7C59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('CREATE INDEX IDX_44876BD7C59B01FF ON movimiento_mercancia (id_centro_costo_id)');
        $this->addSql('CREATE INDEX IDX_44876BD7F66372E9 ON movimiento_mercancia (id_elemento_gasto_id)');
        $this->addSql('ALTER TABLE tipo_documento CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE transferencia ADD id_almacen_id INT DEFAULT NULL, ADD nro_cuenta_inventario VARCHAR(255) NOT NULL, ADD nro_subcuenta_inventario VARCHAR(255) NOT NULL, ADD nro_cuenta_acreedora VARCHAR(255) NOT NULL, ADD nro_concecutivo VARCHAR(255) NOT NULL, ADD anno INT NOT NULL, ADD activo TINYINT(1) NOT NULL, ADD entrada TINYINT(1) NOT NULL, DROP is_salida, CHANGE id_unidad_id id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transferencia ADD CONSTRAINT FK_EDC2273039161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_EDC2273039161EBF ON transferencia (id_almacen_id)');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C8F66372E9');
        $this->addSql('DROP INDEX IDX_90C265C8F66372E9 ON vale_salida');
        $this->addSql('ALTER TABLE vale_salida ADD activo TINYINT(1) NOT NULL, ADD nro_consecutivo VARCHAR(255) NOT NULL, ADD fecha_solicitud DATE NOT NULL, ADD nro_solicitud VARCHAR(255) NOT NULL, ADD nro_cuenta_deudora VARCHAR(255) NOT NULL, ADD nro_subcuenta_deudora VARCHAR(255) NOT NULL, CHANGE id_elemento_gasto_id anno INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo DROP FOREIGN KEY FK_2FA61FF27786CA71');
        $this->addSql('DROP TABLE depreciacion');
        $this->addSql('DROP TABLE movimiento');
        $this->addSql('DROP TABLE stripe_factura');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93E1D34FA6B');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93E4A667A2B');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EE8F12801');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EA1BE243F');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EEB3145A8');
        $this->addSql('ALTER TABLE activo_fijo DROP FOREIGN KEY FK_75EBC93EF66372E9');
        $this->addSql('ALTER TABLE activo_fijo_movimiento_activo_fijo DROP FOREIGN KEY FK_2FA61FF25832E72E');
        $this->addSql('ALTER TABLE ajuste DROP INDEX IDX_DD35BD326601BA07, ADD UNIQUE INDEX UNIQ_DD35BD326601BA07 (id_documento_id)');
        $this->addSql('ALTER TABLE ajuste ADD is_salida TINYINT(1) NOT NULL, DROP nro_cuenta_inventario, DROP observacion, DROP nro_subcuenta_inventario, DROP nro_cuenta_acreedora, DROP nro_concecutivo, DROP anno, DROP activo, DROP entrada');
        $this->addSql('ALTER TABLE centro_costo DROP id_elemento_gasto');
        $this->addSql('ALTER TABLE cliente_reporte DROP efectivo, CHANGE fecha fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE mercancia DROP cuenta');
        $this->addSql('ALTER TABLE modulo CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7C59B01FF');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7F66372E9');
        $this->addSql('DROP INDEX IDX_44876BD7C59B01FF ON movimiento_mercancia');
        $this->addSql('DROP INDEX IDX_44876BD7F66372E9 ON movimiento_mercancia');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP id_centro_costo_id, DROP id_elemento_gasto_id');
        $this->addSql('ALTER TABLE tipo_documento CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE transferencia DROP FOREIGN KEY FK_EDC2273039161EBF');
        $this->addSql('DROP INDEX IDX_EDC2273039161EBF ON transferencia');
        $this->addSql('ALTER TABLE transferencia ADD is_salida TINYINT(1) DEFAULT NULL, DROP id_almacen_id, DROP nro_cuenta_inventario, DROP nro_subcuenta_inventario, DROP nro_cuenta_acreedora, DROP nro_concecutivo, DROP anno, DROP activo, DROP entrada, CHANGE id_unidad_id id_unidad_id INT NOT NULL');
        $this->addSql('ALTER TABLE vale_salida DROP activo, DROP nro_consecutivo, DROP fecha_solicitud, DROP nro_solicitud, DROP nro_cuenta_deudora, DROP nro_subcuenta_deudora, CHANGE anno id_elemento_gasto_id INT NOT NULL');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('CREATE INDEX IDX_90C265C8F66372E9 ON vale_salida (id_elemento_gasto_id)');
    }
}
