<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114194055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE impuesto_sobre_renta (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, id_nomina_pago_id INT NOT NULL, id_rango_escala_id INT NOT NULL, seguridad_social_mensual DOUBLE PRECISION DEFAULT NULL, salario_bruto_anual DOUBLE PRECISION NOT NULL, seguridad_social_anual DOUBLE PRECISION DEFAULT NULL, salario_despues_seguridad_social DOUBLE PRECISION NOT NULL, monto_segun_rango DOUBLE PRECISION DEFAULT NULL, monto_segun_rango_escala DOUBLE PRECISION DEFAULT NULL, excedente_segun_rango_escala DOUBLE PRECISION DEFAULT NULL, por_ciento_impuesto_excedente DOUBLE PRECISION DEFAULT NULL, monto_adicional_rango_escala DOUBLE PRECISION DEFAULT NULL, impuesto_renta_pagar_anual DOUBLE PRECISION DEFAULT NULL, impuesto_renta_pagar_mensual DOUBLE PRECISION DEFAULT NULL, fecha DATE NOT NULL, INDEX IDX_5EF11EF48D392AC7 (id_empleado_id), INDEX IDX_5EF11EF4E9DBC8E8 (id_nomina_pago_id), INDEX IDX_5EF11EF4A9ECE748 (id_rango_escala_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF48D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF4E9DBC8E8 FOREIGN KEY (id_nomina_pago_id) REFERENCES nomina_pago (id)');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF4A9ECE748 FOREIGN KEY (id_rango_escala_id) REFERENCES rango_escala_dgii (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE impuesto_sobre_renta');
    }
}
