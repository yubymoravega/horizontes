<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013175450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cierre (id INT AUTO_INCREMENT NOT NULL, id_almacen_id INT NOT NULL, id_usuario_id INT DEFAULT NULL, diario TINYINT(1) NOT NULL, mes INT DEFAULT NULL, anno INT NOT NULL, fecha DATE NOT NULL, saldo DOUBLE PRECISION NOT NULL, abierto TINYINT(1) DEFAULT NULL, debito DOUBLE PRECISION NOT NULL, credito DOUBLE PRECISION NOT NULL, INDEX IDX_D0DCFCC739161EBF (id_almacen_id), INDEX IDX_D0DCFCC77EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE registro_comprobantes (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_tipo_comprobante_id INT NOT NULL, id_usuario_id INT NOT NULL, id_almacen_id INT NOT NULL, nro_consecutivo INT NOT NULL, fecha DATE NOT NULL, descripcion VARCHAR(255) NOT NULL, debito DOUBLE PRECISION NOT NULL, credito DOUBLE PRECISION NOT NULL, INDEX IDX_B2D1B2B21D34FA6B (id_unidad_id), INDEX IDX_B2D1B2B2EF5F7851 (id_tipo_comprobante_id), INDEX IDX_B2D1B2B27EB2C349 (id_usuario_id), INDEX IDX_B2D1B2B239161EBF (id_almacen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_comprobante (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, boolean VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cierre ADD CONSTRAINT FK_D0DCFCC739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE cierre ADD CONSTRAINT FK_D0DCFCC77EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B21D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B2EF5F7851 FOREIGN KEY (id_tipo_comprobante_id) REFERENCES tipo_comprobante (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B27EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B239161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD id_almacen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_44876BD739161EBF ON movimiento_mercancia (id_almacen_id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD id_almacen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_FFC0EDFC39161EBF ON movimiento_producto (id_almacen_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B2EF5F7851');
        $this->addSql('DROP TABLE cierre');
        $this->addSql('DROP TABLE registro_comprobantes');
        $this->addSql('DROP TABLE tipo_comprobante');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD739161EBF');
        $this->addSql('DROP INDEX IDX_44876BD739161EBF ON movimiento_mercancia');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP id_almacen_id');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC39161EBF');
        $this->addSql('DROP INDEX IDX_FFC0EDFC39161EBF ON movimiento_producto');
        $this->addSql('ALTER TABLE movimiento_producto DROP id_almacen_id');
    }
}
