<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201019183106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orden_trabajo (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT DEFAULT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_4158A0241D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orden_trabajo ADD CONSTRAINT FK_4158A0241D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD id_orden_trabajo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD771381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('CREATE INDEX IDX_44876BD771381BB3 ON movimiento_mercancia (id_orden_trabajo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD771381BB3');
        $this->addSql('DROP TABLE orden_trabajo');
        $this->addSql('DROP INDEX IDX_44876BD771381BB3 ON movimiento_mercancia');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP id_orden_trabajo_id');
    }
}
