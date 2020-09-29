<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD:migrations/Version20200929194227.php
final class Version20200929194227 extends AbstractMigration
=======
final class Version20200929155818 extends AbstractMigration
>>>>>>> 2f84ba1b106e51ef88e7543ce00d8f9d50ab1ff2:migrations/Version20200929155818.php
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20200929194227.php
        $this->addSql('ALTER TABLE unidad_medida CHANGE id id INT NOT NULL');
=======
        $this->addSql('ALTER TABLE transferencia ADD nro_subcuenta_acreedora VARCHAR(255) NOT NULL');
>>>>>>> 2f84ba1b106e51ef88e7543ce00d8f9d50ab1ff2:migrations/Version20200929155818.php
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<< HEAD:migrations/Version20200929194227.php
        $this->addSql('ALTER TABLE unidad_medida CHANGE id id INT AUTO_INCREMENT NOT NULL');
=======
        $this->addSql('ALTER TABLE transferencia DROP nro_subcuenta_acreedora');
>>>>>>> 2f84ba1b106e51ef88e7543ce00d8f9d50ab1ff2:migrations/Version20200929155818.php
    }
}
