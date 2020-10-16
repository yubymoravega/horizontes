<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016130055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expediente ADD activo TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD id_expediente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7F5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('CREATE INDEX IDX_44876BD7F5DBAF2B ON movimiento_mercancia (id_expediente_id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD anno INT NOT NULL');
        $this->addSql('ALTER TABLE tipo_comprobante CHANGE id id INT NOT NULL, CHANGE boolean abreviatura VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expediente DROP activo');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7F5DBAF2B');
        $this->addSql('DROP INDEX IDX_44876BD7F5DBAF2B ON movimiento_mercancia');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP id_expediente_id');
        $this->addSql('ALTER TABLE registro_comprobantes DROP anno');
        $this->addSql('ALTER TABLE tipo_comprobante CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE abreviatura boolean VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
