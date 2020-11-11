<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108145944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_producto ADD id_orden_trabajo_id INT DEFAULT NULL, ADD id_expediente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC71381BB3 FOREIGN KEY (id_orden_trabajo_id) REFERENCES orden_trabajo (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCF5DBAF2B FOREIGN KEY (id_expediente_id) REFERENCES expediente (id)');
        $this->addSql('CREATE INDEX IDX_FFC0EDFC71381BB3 ON movimiento_producto (id_orden_trabajo_id)');
        $this->addSql('CREATE INDEX IDX_FFC0EDFCF5DBAF2B ON movimiento_producto (id_expediente_id)');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFC71381BB3');
        $this->addSql('ALTER TABLE movimiento_producto DROP FOREIGN KEY FK_FFC0EDFCF5DBAF2B');
        $this->addSql('DROP INDEX IDX_FFC0EDFC71381BB3 ON movimiento_producto');
        $this->addSql('DROP INDEX IDX_FFC0EDFCF5DBAF2B ON movimiento_producto');
        $this->addSql('ALTER TABLE movimiento_producto DROP id_orden_trabajo_id, DROP id_expediente_id');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
