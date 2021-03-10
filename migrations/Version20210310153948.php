<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310153948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE config_servicios (id INT AUTO_INCREMENT NOT NULL, id_servicio_id INT NOT NULL, id_unidad_id INT NOT NULL, minimo DOUBLE PRECISION NOT NULL, porciento TINYINT(1) NOT NULL, INDEX IDX_A1A8B71269D86E10 (id_servicio_id), INDEX IDX_A1A8B7121D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE config_servicios ADD CONSTRAINT FK_A1A8B71269D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('ALTER TABLE config_servicios ADD CONSTRAINT FK_A1A8B7121D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE servicios DROP FOREIGN KEY FK_C07E802F1D34FA6B');
        $this->addSql('DROP INDEX IDX_C07E802F1D34FA6B ON servicios');
        $this->addSql('ALTER TABLE servicios DROP id_unidad_id, DROP minimo_pagar, DROP porciento');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE config_servicios');
        $this->addSql('ALTER TABLE servicios ADD id_unidad_id INT DEFAULT NULL, ADD minimo_pagar DOUBLE PRECISION DEFAULT NULL, ADD porciento TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE servicios ADD CONSTRAINT FK_C07E802F1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_C07E802F1D34FA6B ON servicios (id_unidad_id)');
    }
}
