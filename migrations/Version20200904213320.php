<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200904213320 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente_beneficiario (id INT AUTO_INCREMENT NOT NULL, primer_nombre VARCHAR(255) NOT NULL, segundo_nombre VARCHAR(255) DEFAULT NULL, primer_apellido VARCHAR(255) NOT NULL, segundo_apellido VARCHAR(255) DEFAULT NULL, alternativo_nombre VARCHAR(255) DEFAULT NULL, alternativo_apellido VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) NOT NULL, identificacion VARCHAR(255) DEFAULT NULL, calle VARCHAR(255) NOT NULL, no VARCHAR(255) NOT NULL, entre VARCHAR(255) DEFAULT NULL, y VARCHAR(255) DEFAULT NULL, apto VARCHAR(255) DEFAULT NULL, piso VARCHAR(255) DEFAULT NULL, reparto VARCHAR(255) DEFAULT NULL, provincia VARCHAR(255) DEFAULT NULL, municipio VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cliente_beneficiario');
    }
}
