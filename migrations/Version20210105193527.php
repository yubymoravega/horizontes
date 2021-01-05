<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105193527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comprobante_movimiento_activo_fijo (id INT AUTO_INCREMENT NOT NULL, id_registro_comprobante_id INT NOT NULL, id_movimiento_activo_id INT NOT NULL, id_unidad_id INT NOT NULL, anno INT NOT NULL, INDEX IDX_81F5096A1399A3CF (id_registro_comprobante_id), INDEX IDX_81F5096A9D00B230 (id_movimiento_activo_id), INDEX IDX_81F5096A1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A1399A3CF FOREIGN KEY (id_registro_comprobante_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A9D00B230 FOREIGN KEY (id_movimiento_activo_id) REFERENCES movimiento_activo_fijo (id)');
        $this->addSql('ALTER TABLE comprobante_movimiento_activo_fijo ADD CONSTRAINT FK_81F5096A1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comprobante_movimiento_activo_fijo');
    }
}
