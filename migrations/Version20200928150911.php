<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200928150911 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movimiento_producto (id INT AUTO_INCREMENT NOT NULL, id_producto_id INT NOT NULL, id_documento_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_usuario_id INT DEFAULT NULL, id_centro_costo_id INT DEFAULT NULL, id_elemento_gasto_id INT DEFAULT NULL, cantidad DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, existencia DOUBLE PRECISION NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_FFC0EDFC6E57A479 (id_producto_id), INDEX IDX_FFC0EDFC6601BA07 (id_documento_id), INDEX IDX_FFC0EDFC7A4F962 (id_tipo_documento_id), INDEX IDX_FFC0EDFC7EB2C349 (id_usuario_id), INDEX IDX_FFC0EDFCC59B01FF (id_centro_costo_id), INDEX IDX_FFC0EDFCF66372E9 (id_elemento_gasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcuenta_criterio_analisis (id INT AUTO_INCREMENT NOT NULL, id_subcuenta_id INT NOT NULL, id_criterio_analisis_id INT NOT NULL, INDEX IDX_52A4A7682D412F53 (id_subcuenta_id), INDEX IDX_52A4A7685ABBE5F6 (id_criterio_analisis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC6E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC7A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7682D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7685ABBE5F6 FOREIGN KEY (id_criterio_analisis_id) REFERENCES criterio_analisis (id)');
        $this->addSql('ALTER TABLE cuenta DROP elemento_gasto');
        $this->addSql('ALTER TABLE informe_recepcion ADD producto TINYINT(1) DEFAULT NULL, CHANGE id_proveedor_id id_proveedor_id INT DEFAULT NULL, CHANGE codigo_factura codigo_factura VARCHAR(255) DEFAULT NULL, CHANGE fecha_factura fecha_factura DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD id_amlacen_id INT NOT NULL, ADD id_unidad_medida_id INT NOT NULL, ADD cuenta VARCHAR(255) NOT NULL, ADD importe DOUBLE PRECISION NOT NULL, CHANGE activo activo TINYINT(1) NOT NULL, CHANGE precio_costo existencia DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E2C70A62 FOREIGN KEY (id_amlacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615E16A5625 FOREIGN KEY (id_unidad_medida_id) REFERENCES unidad_medida (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615E2C70A62 ON producto (id_amlacen_id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615E16A5625 ON producto (id_unidad_medida_id)');
        $this->addSql('ALTER TABLE subcuenta ADD elemento_gasto TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movimiento_producto');
        $this->addSql('DROP TABLE subcuenta_criterio_analisis');
        $this->addSql('ALTER TABLE cuenta ADD elemento_gasto TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE informe_recepcion DROP producto, CHANGE id_proveedor_id id_proveedor_id INT NOT NULL, CHANGE codigo_factura codigo_factura VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fecha_factura fecha_factura DATE NOT NULL');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E2C70A62');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615E16A5625');
        $this->addSql('DROP INDEX IDX_A7BB0615E2C70A62 ON producto');
        $this->addSql('DROP INDEX IDX_A7BB0615E16A5625 ON producto');
        $this->addSql('ALTER TABLE producto ADD precio_costo DOUBLE PRECISION NOT NULL, DROP id_amlacen_id, DROP id_unidad_medida_id, DROP cuenta, DROP existencia, DROP importe, CHANGE activo activo TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE subcuenta DROP elemento_gasto');
    }
}
