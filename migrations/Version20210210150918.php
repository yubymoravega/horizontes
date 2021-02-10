<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210150918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agencias_img (id INT AUTO_INCREMENT NOT NULL, id_unidad VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agencias_tv (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(1000) NOT NULL, nombre_tv VARCHAR(255) NOT NULL, id_unidad VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE banco (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD id_instrumento_cobro_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E47B60D7E FOREIGN KEY (id_instrumento_cobro_id) REFERENCES instrumento_cobro (id)');
        $this->addSql('CREATE INDEX IDX_E7EA17E47B60D7E ON operaciones_comprobante_operaciones (id_instrumento_cobro_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE agencias_img');
        $this->addSql('DROP TABLE agencias_tv');
        $this->addSql('DROP TABLE banco');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP FOREIGN KEY FK_E7EA17E47B60D7E');
        $this->addSql('DROP INDEX IDX_E7EA17E47B60D7E ON operaciones_comprobante_operaciones');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP id_instrumento_cobro_id');
    }
}
