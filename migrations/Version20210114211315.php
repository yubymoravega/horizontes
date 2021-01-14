<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114211315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE factura_imposdom (id INT AUTO_INCREMENT NOT NULL, id_cliente VARCHAR(255) NOT NULL, cedula VARCHAR(255) NOT NULL, casillero VARCHAR(255) NOT NULL, ciudad VARCHAR(255) NOT NULL, fecha DATETIME NOT NULL, sh VARCHAR(255) NOT NULL, cierre VARCHAR(255) NOT NULL, pago VARCHAR(255) NOT NULL, json VARCHAR(5000) NOT NULL, lb VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impuesto_sobre_renta (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, id_nomina_pago_id INT NOT NULL, id_rango_escala_id INT NOT NULL, seguridad_social_mensual DOUBLE PRECISION DEFAULT NULL, salario_bruto_anual DOUBLE PRECISION NOT NULL, seguridad_social_anual DOUBLE PRECISION DEFAULT NULL, salario_despues_seguridad_social DOUBLE PRECISION NOT NULL, monto_segun_rango DOUBLE PRECISION DEFAULT NULL, monto_segun_rango_escala DOUBLE PRECISION DEFAULT NULL, excedente_segun_rango_escala DOUBLE PRECISION DEFAULT NULL, por_ciento_impuesto_excedente DOUBLE PRECISION DEFAULT NULL, monto_adicional_rango_escala DOUBLE PRECISION DEFAULT NULL, impuesto_renta_pagar_anual DOUBLE PRECISION DEFAULT NULL, impuesto_renta_pagar_mensual DOUBLE PRECISION DEFAULT NULL, fecha DATE NOT NULL, INDEX IDX_5EF11EF48D392AC7 (id_empleado_id), INDEX IDX_5EF11EF4E9DBC8E8 (id_nomina_pago_id), INDEX IDX_5EF11EF4A9ECE748 (id_rango_escala_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nomina_pago (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, id_usuario_aprueba_id INT DEFAULT NULL, comision DOUBLE PRECISION DEFAULT NULL, vacaciones DOUBLE PRECISION DEFAULT NULL, horas_extra DOUBLE PRECISION DEFAULT NULL, otros DOUBLE PRECISION DEFAULT NULL, total_ingresos DOUBLE PRECISION NOT NULL, ingresos_cotizables_tss DOUBLE PRECISION NOT NULL, isr DOUBLE PRECISION DEFAULT NULL, ars DOUBLE PRECISION DEFAULT NULL, afp DOUBLE PRECISION DEFAULT NULL, cooperativa DOUBLE PRECISION DEFAULT NULL, plan_medico_complementario DOUBLE PRECISION DEFAULT NULL, restaurant DOUBLE PRECISION DEFAULT NULL, total_deducido DOUBLE PRECISION DEFAULT NULL, sueldo_neto_pagar DOUBLE PRECISION DEFAULT NULL, afp_empleador DOUBLE PRECISION DEFAULT NULL, sfs_empleador DOUBLE PRECISION DEFAULT NULL, srl_empleador DOUBLE PRECISION DEFAULT NULL, infotep_empleador DOUBLE PRECISION DEFAULT NULL, mes INT NOT NULL, anno INT NOT NULL, fecha DATE NOT NULL, elaborada TINYINT(1) DEFAULT NULL, aprobada TINYINT(1) DEFAULT NULL, INDEX IDX_5CB8BD338D392AC7 (id_empleado_id), INDEX IDX_5CB8BD33AC6A6301 (id_usuario_aprueba_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rango_escala_dgii (id INT AUTO_INCREMENT NOT NULL, anno INT NOT NULL, escala VARCHAR(255) NOT NULL, por_ciento DOUBLE PRECISION NOT NULL, minimo DOUBLE PRECISION DEFAULT NULL, maximo DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, valor_fijo DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF48D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF4E9DBC8E8 FOREIGN KEY (id_nomina_pago_id) REFERENCES nomina_pago (id)');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF4A9ECE748 FOREIGN KEY (id_rango_escala_id) REFERENCES rango_escala_dgii (id)');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD338D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD33AC6A6301 FOREIGN KEY (id_usuario_aprueba_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cargo DROP salario_base');
        $this->addSql('ALTER TABLE empleado ADD sueldo_bruto_mensual DOUBLE PRECISION DEFAULT NULL, ADD salario_x_hora DOUBLE PRECISION DEFAULT NULL, DROP acumulado_tiempo_vacaciones, DROP acumulado_dinero_vacaciones');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE impuesto_sobre_renta DROP FOREIGN KEY FK_5EF11EF4E9DBC8E8');
        $this->addSql('ALTER TABLE impuesto_sobre_renta DROP FOREIGN KEY FK_5EF11EF4A9ECE748');
        $this->addSql('DROP TABLE factura_imposdom');
        $this->addSql('DROP TABLE impuesto_sobre_renta');
        $this->addSql('DROP TABLE nomina_pago');
        $this->addSql('DROP TABLE rango_escala_dgii');
        $this->addSql('ALTER TABLE cargo ADD salario_base DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE empleado ADD acumulado_tiempo_vacaciones DOUBLE PRECISION DEFAULT NULL, ADD acumulado_dinero_vacaciones DOUBLE PRECISION DEFAULT NULL, DROP sueldo_bruto_mensual, DROP salario_x_hora');
    }
}
