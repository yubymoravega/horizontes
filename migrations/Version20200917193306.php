<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200917193306 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cotizacion (id INT AUTO_INCREMENT NOT NULL, json VARCHAR(255) NOT NULL, empleado VARCHAR(255) NOT NULL, datetime VARCHAR(255) NOT NULL, total VARCHAR(255) NOT NULL, id_cliente VARCHAR(255) NOT NULL, nombre_cliente VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pre_facturas (id INT AUTO_INCREMENT NOT NULL, json VARCHAR(10000) NOT NULL, empleado VARCHAR(255) NOT NULL, datetime VARCHAR(255) NOT NULL, total VARCHAR(255) NOT NULL, id_cliente VARCHAR(255) NOT NULL, nombre_cliente VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cotizacion');
        $this->addSql('DROP TABLE pre_facturas');
    }
}
