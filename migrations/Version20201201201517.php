<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201201517 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD id_almacen_id INT DEFAULT NULL, ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_E7EA17E39161EBF ON operaciones_comprobante_operaciones (id_almacen_id)');
        $this->addSql('CREATE INDEX IDX_E7EA17E1D34FA6B ON operaciones_comprobante_operaciones (id_unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP FOREIGN KEY FK_E7EA17E39161EBF');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP FOREIGN KEY FK_E7EA17E1D34FA6B');
        $this->addSql('DROP INDEX IDX_E7EA17E39161EBF ON operaciones_comprobante_operaciones');
        $this->addSql('DROP INDEX IDX_E7EA17E1D34FA6B ON operaciones_comprobante_operaciones');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP id_almacen_id, DROP id_unidad_id');
    }
}
