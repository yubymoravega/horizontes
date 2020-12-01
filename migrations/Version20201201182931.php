<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201182931 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trasacciones (id INT AUTO_INCREMENT NOT NULL, transaccion VARCHAR(255) NOT NULL, id_cotizacion VARCHAR(255) NOT NULL, monto VARCHAR(255) NOT NULL, banco VARCHAR(255) NOT NULL, empleado VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, cuenta VARCHAR(255) DEFAULT NULL, moneda VARCHAR(255) NOT NULL, no_transaccion VARCHAR(255) NOT NULL, nota VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trasacciones');
    }
}
