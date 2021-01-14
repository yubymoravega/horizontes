<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114135215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE factura_imposdom (id INT AUTO_INCREMENT NOT NULL, id_cliente VARCHAR(255) NOT NULL, cedula VARCHAR(255) NOT NULL, casillero VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, sh VARCHAR(255) NOT NULL, cierre VARCHAR(255) NOT NULL, pago VARCHAR(255) NOT NULL, json VARCHAR(5000) NOT NULL, lb VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cargo DROP salario_base');
        $this->addSql('ALTER TABLE empleado ADD sueldo_bruto_mensual DOUBLE PRECISION DEFAULT NULL, ADD comision_mensual DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE factura_imposdom');
        $this->addSql('ALTER TABLE cargo ADD salario_base DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE empleado DROP sueldo_bruto_mensual, DROP comision_mensual');
    }
}
