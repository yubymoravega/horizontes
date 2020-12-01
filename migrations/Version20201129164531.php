<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129164531 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura ADD ncf VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_venta ADD descripcion VARCHAR(255) DEFAULT NULL, ADD id_mercancia INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unidad ADD direccion VARCHAR(255) DEFAULT NULL, ADD telefono VARCHAR(255) DEFAULT NULL, ADD correo VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE factura DROP ncf');
        $this->addSql('ALTER TABLE movimiento_venta DROP descripcion, DROP id_mercancia');
        $this->addSql('ALTER TABLE unidad DROP direccion, DROP telefono, DROP correo');
    }
}
