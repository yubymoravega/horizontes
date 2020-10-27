<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027010106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE saldo_cuentas (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT NOT NULL, id_centro_costo_id INT DEFAULT NULL, id_elemento_gasto_id INT DEFAULT NULL, id_almacen_id INT DEFAULT NULL, id_unidad_id INT NOT NULL, id_proveedor_id INT DEFAULT NULL, id_expediente_id INT DEFAULT NULL, id_orden_trabajo_id INT DEFAULT NULL, mes INT NOT NULL, anno INT NOT NULL, saldo DOUBLE PRECISION NOT NULL, INDEX IDX_BB2B71AE1ADA4D3F (id_cuenta_id), INDEX IDX_BB2B71AE2D412F53 (id_subcuenta_id), INDEX IDX_BB2B71AEC59B01FF (id_centro_costo_id), INDEX IDX_BB2B71AEF66372E9 (id_elemento_gasto_id), INDEX IDX_BB2B71AE39161EBF (id_almacen_id), INDEX IDX_BB2B71AE1D34FA6B (id_unidad_id), INDEX IDX_BB2B71AEE8F12801 (id_proveedor_id), INDEX IDX_BB2B71AEF5DBAF2B (id_expediente_id), INDEX IDX_BB2B71AE71381BB3 (id_orden_trabajo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE1ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE2D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEE8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AEF5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('ALTER TABLE saldo_cuentas ADD CONSTRAINT FK_BB2B71AE71381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE saldo_cuentas');
    }
}
