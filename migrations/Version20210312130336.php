<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312130336 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE impuesto (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, valor DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_B6E63AA11D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE impuesto ADD CONSTRAINT FK_B6E63AA11D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE avisos_pagos ADD CONSTRAINT FK_F439673A78A65A2 FOREIGN KEY (id_plazo_pago_id) REFERENCES plazos_pago_cotizacion (id)');
        $this->addSql('ALTER TABLE avisos_pagos ADD CONSTRAINT FK_F4396738E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE impuesto');
        $this->addSql('ALTER TABLE avisos_pagos DROP FOREIGN KEY FK_F439673A78A65A2');
        $this->addSql('ALTER TABLE avisos_pagos DROP FOREIGN KEY FK_F4396738E5841CF');
    }
}
