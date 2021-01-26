<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123161100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apertura (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, nro_cuenta_inventario VARCHAR(255) NOT NULL, observacion VARCHAR(255) NOT NULL, nro_subcuenta_inventario VARCHAR(255) NOT NULL, nro_cuenta_acreedora VARCHAR(255) NOT NULL, nro_subcuenta_acreedora VARCHAR(255) NOT NULL, nro_concecutivo VARCHAR(255) NOT NULL, anno INT NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_DFFB55EB6601BA07 (id_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apertura ADD CONSTRAINT FK_DFFB55EB6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE apertura');
    }
}
