<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212200511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asiento ADD id_elemento_visa_id INT DEFAULT NULL, ADD orden_operacion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C4CC57875 FOREIGN KEY (id_elemento_visa_id) REFERENCES elementos_visa (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C4CC57875 ON asiento (id_elemento_visa_id)');
        $this->addSql('ALTER TABLE elementos_visa ADD id_servicio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE elementos_visa ADD CONSTRAINT FK_90B65E0469D86E10 FOREIGN KEY (id_servicio_id) REFERENCES servicios (id)');
        $this->addSql('CREATE INDEX IDX_90B65E0469D86E10 ON elementos_visa (id_servicio_id)');
        $this->addSql('ALTER TABLE pagos_cotizacion ADD id_transaccion INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C4CC57875');
        $this->addSql('DROP INDEX IDX_71D6D35C4CC57875 ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_elemento_visa_id, DROP orden_operacion');
        $this->addSql('ALTER TABLE elementos_visa DROP FOREIGN KEY FK_90B65E0469D86E10');
        $this->addSql('DROP INDEX IDX_90B65E0469D86E10 ON elementos_visa');
        $this->addSql('ALTER TABLE elementos_visa DROP id_servicio_id');
        $this->addSql('ALTER TABLE pagos_cotizacion DROP id_transaccion');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
