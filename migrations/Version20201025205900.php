<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201025205900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comprobante_cierre (id INT AUTO_INCREMENT NOT NULL, id_comprobante_id INT NOT NULL, id_cierre_id INT NOT NULL, INDEX IDX_D03EA4C51800963C (id_comprobante_id), INDEX IDX_D03EA4C545F8C94C (id_cierre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comprobante_cierre ADD CONSTRAINT FK_D03EA4C51800963C FOREIGN KEY (id_comprobante_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE comprobante_cierre ADD CONSTRAINT FK_D03EA4C545F8C94C FOREIGN KEY (id_cierre_id) REFERENCES cierre (id)');
        $this->addSql('ALTER TABLE factura CHANGE id_contrato id_contrato_id INT NOT NULL');
        $this->addSql('ALTER TABLE factura ADD CONSTRAINT FK_F9EBA00968BCB606 FOREIGN KEY (id_contrato_id) REFERENCES contratos_cliente (id)');
        $this->addSql('CREATE INDEX IDX_F9EBA00968BCB606 ON factura (id_contrato_id)');
        $this->addSql('ALTER TABLE movimiento_venta ADD id_almacen_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_venta ADD CONSTRAINT FK_8E3F7AE539161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_8E3F7AE539161EBF ON movimiento_venta (id_almacen_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comprobante_cierre');
        $this->addSql('ALTER TABLE factura DROP FOREIGN KEY FK_F9EBA00968BCB606');
        $this->addSql('DROP INDEX IDX_F9EBA00968BCB606 ON factura');
        $this->addSql('ALTER TABLE factura CHANGE id_contrato_id id_contrato INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_venta DROP FOREIGN KEY FK_8E3F7AE539161EBF');
        $this->addSql('DROP INDEX IDX_8E3F7AE539161EBF ON movimiento_venta');
        $this->addSql('ALTER TABLE movimiento_venta DROP id_almacen_id');
    }
}
