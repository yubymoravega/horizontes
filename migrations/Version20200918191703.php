<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918191703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrito (id INT AUTO_INCREMENT NOT NULL, json VARCHAR(1500) NOT NULL, empleado VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente_beneficiario (id INT AUTO_INCREMENT NOT NULL, id_cliente VARCHAR(255) NOT NULL, primer_nombre VARCHAR(255) NOT NULL, telefono_casa VARCHAR(255) DEFAULT NULL, primer_apellido VARCHAR(255) NOT NULL, segundo_apellido VARCHAR(255) DEFAULT NULL, alternativo_nombre VARCHAR(255) DEFAULT NULL, alternativo_apellido VARCHAR(255) DEFAULT NULL, alternativo_segundo_apellido VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) NOT NULL, identificacion VARCHAR(255) DEFAULT NULL, calle VARCHAR(255) NOT NULL, no VARCHAR(255) NOT NULL, entre VARCHAR(255) DEFAULT NULL, y VARCHAR(255) DEFAULT NULL, apto VARCHAR(255) DEFAULT NULL, edificio VARCHAR(255) DEFAULT NULL, reparto VARCHAR(255) DEFAULT NULL, provincia VARCHAR(255) DEFAULT NULL, municipio VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE municipios (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provincias (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documento ADD id_moneda_id INT NOT NULL');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC7374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('CREATE INDEX IDX_B6B12EC7374388F5 ON documento (id_moneda_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE carrito');
        $this->addSql('DROP TABLE cliente_beneficiario');
        $this->addSql('DROP TABLE municipios');
        $this->addSql('DROP TABLE provincias');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC7374388F5');
        $this->addSql('DROP INDEX IDX_B6B12EC7374388F5 ON documento');
        $this->addSql('ALTER TABLE documento DROP id_moneda_id');
    }
}
