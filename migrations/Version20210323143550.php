<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323143550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE descuestos_servicios_cotizacion (id INT AUTO_INCREMENT NOT NULL, id_cotizacion_id INT NOT NULL, id_servicio_id INT NOT NULL, descuento DOUBLE PRECISION NOT NULL, fijo TINYINT(1) NOT NULL, INDEX IDX_1C606F008E5841CF (id_cotizacion_id), INDEX IDX_1C606F0069D86E10 (id_servicio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impuestos_servicio_cotizacion (id INT AUTO_INCREMENT NOT NULL, id_cotizacion_id INT NOT NULL, id_servicio_id INT NOT NULL, id_impuesto_id INT NOT NULL, INDEX IDX_2CA4AD5E8E5841CF (id_cotizacion_id), INDEX IDX_2CA4AD5E69D86E10 (id_servicio_id), INDEX IDX_2CA4AD5ECA29A612 (id_impuesto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_crud (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE descuestos_servicios_cotizacion ADD CONSTRAINT FK_1C606F008E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
        $this->addSql('ALTER TABLE descuestos_servicios_cotizacion ADD CONSTRAINT FK_1C606F0069D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('ALTER TABLE impuestos_servicio_cotizacion ADD CONSTRAINT FK_2CA4AD5E8E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
        $this->addSql('ALTER TABLE impuestos_servicio_cotizacion ADD CONSTRAINT FK_2CA4AD5E69D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('ALTER TABLE impuestos_servicio_cotizacion ADD CONSTRAINT FK_2CA4AD5ECA29A612 FOREIGN KEY (id_impuesto_id) REFERENCES impuesto (id)');
        $this->addSql('DROP TABLE test1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test1 (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, nombre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, edad INT NOT NULL, fecha DATE DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_8AB2DCE21D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE test1 ADD CONSTRAINT FK_8AB2DCE21D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('DROP TABLE descuestos_servicios_cotizacion');
        $this->addSql('DROP TABLE impuestos_servicio_cotizacion');
        $this->addSql('DROP TABLE test_crud');
    }
}
