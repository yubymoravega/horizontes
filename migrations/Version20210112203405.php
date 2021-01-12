<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210112203405 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE periodo_sistema (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, id_almacen_id INT DEFAULT NULL, id_usuario_id INT NOT NULL, mes INT NOT NULL, anno INT NOT NULL, tipo INT NOT NULL, fecha DATE NOT NULL, cerrado TINYINT(1) NOT NULL, INDEX IDX_AEF0BAAD1D34FA6B (id_unidad_id), INDEX IDX_AEF0BAAD39161EBF (id_almacen_id), INDEX IDX_AEF0BAAD7EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE periodo_sistema ADD CONSTRAINT FK_AEF0BAAD1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE periodo_sistema ADD CONSTRAINT FK_AEF0BAAD39161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE periodo_sistema ADD CONSTRAINT FK_AEF0BAAD7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cobros_pagos ADD id_movimiento_activo_fijo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cobros_pagos ADD CONSTRAINT FK_D9581D167786CA71 FOREIGN KEY (id_movimiento_activo_fijo_id) REFERENCES movimiento_activo_fijo (id)');
        $this->addSql('CREATE INDEX IDX_D9581D167786CA71 ON cobros_pagos (id_movimiento_activo_fijo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE periodo_sistema');
        $this->addSql('ALTER TABLE cobros_pagos DROP FOREIGN KEY FK_D9581D167786CA71');
        $this->addSql('DROP INDEX IDX_D9581D167786CA71 ON cobros_pagos');
        $this->addSql('ALTER TABLE cobros_pagos DROP id_movimiento_activo_fijo_id');
    }
}
