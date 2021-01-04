<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201228171036 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
