<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915230552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_mercancia ADD id_centro_costo_id INT DEFAULT NULL, ADD id_elemento_gasto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7C59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE movimiento_mercancia ADD CONSTRAINT FK_44876BD7F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('CREATE INDEX IDX_44876BD7C59B01FF ON movimiento_mercancia (id_centro_costo_id)');
        $this->addSql('CREATE INDEX IDX_44876BD7F66372E9 ON movimiento_mercancia (id_elemento_gasto_id)');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C8F66372E9');
        $this->addSql('DROP INDEX IDX_90C265C8F66372E9 ON vale_salida');
        $this->addSql('ALTER TABLE vale_salida ADD activo TINYINT(1) NOT NULL, ADD nro_consecutivo VARCHAR(255) NOT NULL, ADD fecha_solicitud DATE NOT NULL, ADD nro_solicitud VARCHAR(255) NOT NULL, ADD nro_cuenta_deudora VARCHAR(255) NOT NULL, ADD nro_subcuenta_deudora VARCHAR(255) NOT NULL, CHANGE id_elemento_gasto_id anno INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7C59B01FF');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP FOREIGN KEY FK_44876BD7F66372E9');
        $this->addSql('DROP INDEX IDX_44876BD7C59B01FF ON movimiento_mercancia');
        $this->addSql('DROP INDEX IDX_44876BD7F66372E9 ON movimiento_mercancia');
        $this->addSql('ALTER TABLE movimiento_mercancia DROP id_centro_costo_id, DROP id_elemento_gasto_id');
        $this->addSql('ALTER TABLE vale_salida DROP activo, DROP nro_consecutivo, DROP fecha_solicitud, DROP nro_solicitud, DROP nro_cuenta_deudora, DROP nro_subcuenta_deudora, CHANGE anno id_elemento_gasto_id INT NOT NULL');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('CREATE INDEX IDX_90C265C8F66372E9 ON vale_salida (id_elemento_gasto_id)');
    }
}
