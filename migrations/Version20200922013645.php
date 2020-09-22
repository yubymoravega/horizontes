<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922013645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informe_recepcion ADD producto TINYINT(1) DEFAULT NULL, CHANGE id_proveedor_id id_proveedor_id INT DEFAULT NULL, CHANGE codigo_factura codigo_factura VARCHAR(255) DEFAULT NULL, CHANGE fecha_factura fecha_factura DATE DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE informe_recepcion DROP producto, CHANGE id_proveedor_id id_proveedor_id INT NOT NULL, CHANGE codigo_factura codigo_factura VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE fecha_factura fecha_factura DATE NOT NULL');
    }
}
