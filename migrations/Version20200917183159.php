<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917183159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE criterio_analisis (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, abreviatura VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cuenta_criterio_analisis (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_criterio_analisis_id INT NOT NULL, INDEX IDX_AF040B091ADA4D3F (id_cuenta_id), INDEX IDX_AF040B095ABBE5F6 (id_criterio_analisis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_cuenta (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuenta_criterio_analisis ADD CONSTRAINT FK_AF040B091ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE cuenta_criterio_analisis ADD CONSTRAINT FK_AF040B095ABBE5F6 FOREIGN KEY (id_criterio_analisis_id) REFERENCES criterio_analisis (id)');
        $this->addSql('ALTER TABLE cuenta ADD id_tipo_cuenta_id INT NOT NULL, ADD obligacion_deudora TINYINT(1) NOT NULL, ADD obligacion_acreedora TINYINT(1) NOT NULL, DROP produccion, DROP patrimonio, CHANGE elemento_gasto elemento_gasto TINYINT(1) NOT NULL, CHANGE descripcion nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cuenta ADD CONSTRAINT FK_31C7BFCF45E7F350 FOREIGN KEY (id_tipo_cuenta_id) REFERENCES tipo_cuenta (id)');
        $this->addSql('CREATE INDEX IDX_31C7BFCF45E7F350 ON cuenta (id_tipo_cuenta_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuenta_criterio_analisis DROP FOREIGN KEY FK_AF040B095ABBE5F6');
        $this->addSql('ALTER TABLE cuenta DROP FOREIGN KEY FK_31C7BFCF45E7F350');
        $this->addSql('DROP TABLE criterio_analisis');
        $this->addSql('DROP TABLE cuenta_criterio_analisis');
        $this->addSql('DROP TABLE tipo_cuenta');
        $this->addSql('DROP INDEX IDX_31C7BFCF45E7F350 ON cuenta');
        $this->addSql('ALTER TABLE cuenta ADD produccion TINYINT(1) DEFAULT NULL, ADD patrimonio TINYINT(1) DEFAULT NULL, DROP id_tipo_cuenta_id, DROP obligacion_deudora, DROP obligacion_acreedora, CHANGE elemento_gasto elemento_gasto TINYINT(1) DEFAULT NULL, CHANGE nombre descripcion VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
