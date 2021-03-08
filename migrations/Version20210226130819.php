<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226130819 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente_solicitudes ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente_solicitudes ADD CONSTRAINT FK_D0874AE61D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_D0874AE61D34FA6B ON cliente_solicitudes (id_unidad_id)');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_239856611D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_239856611D34FA6B ON configuracion_reglas_remesas (id_unidad_id)');
        $this->addSql('ALTER TABLE creditos_precio_venta ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE creditos_precio_venta ADD CONSTRAINT FK_847FE8A91D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_847FE8A91D34FA6B ON creditos_precio_venta (id_unidad_id)');
        $this->addSql('ALTER TABLE elementos_visa ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E041D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_90B65E041D34FA6B ON elementos_visa (id_unidad_id)');
        $this->addSql('ALTER TABLE solicitud ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE solicitud ADD CONSTRAINT FK_96D27CC01D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_96D27CC01D34FA6B ON solicitud (id_unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente_solicitudes DROP FOREIGN KEY FK_D0874AE61D34FA6B');
        $this->addSql('DROP INDEX IDX_D0874AE61D34FA6B ON cliente_solicitudes');
        $this->addSql('ALTER TABLE cliente_solicitudes DROP id_unidad_id');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas DROP FOREIGN KEY FK_239856611D34FA6B');
        $this->addSql('DROP INDEX IDX_239856611D34FA6B ON configuracion_reglas_remesas');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas DROP id_unidad_id');
        $this->addSql('ALTER TABLE creditos_precio_venta DROP FOREIGN KEY FK_847FE8A91D34FA6B');
        $this->addSql('DROP INDEX IDX_847FE8A91D34FA6B ON creditos_precio_venta');
        $this->addSql('ALTER TABLE creditos_precio_venta DROP id_unidad_id');
        $this->addSql('ALTER TABLE elementos_visa DROP FOREIGN KEY FK_90B65E041D34FA6B');
        $this->addSql('DROP INDEX IDX_90B65E041D34FA6B ON elementos_visa');
        $this->addSql('ALTER TABLE elementos_visa DROP id_unidad_id');
        $this->addSql('ALTER TABLE solicitud DROP FOREIGN KEY FK_96D27CC01D34FA6B');
        $this->addSql('DROP INDEX IDX_96D27CC01D34FA6B ON solicitud');
        $this->addSql('ALTER TABLE solicitud DROP id_unidad_id');
    }
}
