<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105220418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depreciacion DROP FOREIGN KEY FK_D618AE145832E72E');
        $this->addSql('DROP INDEX IDX_D618AE145832E72E ON depreciacion');
        $this->addSql('ALTER TABLE depreciacion ADD unidad_id INT NOT NULL, ADD fundamentacion VARCHAR(255) NOT NULL, DROP id_activo_fijo_id, DROP mes, CHANGE importe_depreciacion total DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE depreciacion ADD CONSTRAINT FK_D618AE149D01464C FOREIGN KEY (unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_D618AE149D01464C ON depreciacion (unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depreciacion DROP FOREIGN KEY FK_D618AE149D01464C');
        $this->addSql('DROP INDEX IDX_D618AE149D01464C ON depreciacion');
        $this->addSql('ALTER TABLE depreciacion ADD mes INT NOT NULL, DROP fundamentacion, CHANGE unidad_id id_activo_fijo_id INT NOT NULL, CHANGE total importe_depreciacion DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE depreciacion ADD CONSTRAINT FK_D618AE145832E72E FOREIGN KEY (id_activo_fijo_id) REFERENCES activo_fijo (id)');
        $this->addSql('CREATE INDEX IDX_D618AE145832E72E ON depreciacion (id_activo_fijo_id)');
    }
}
