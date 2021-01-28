<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210127185417 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
       /* $this->addSql('ALTER TABLE impuesto_sobre_renta DROP FOREIGN KEY FK_5EF11EF4E9DBC8E8');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante DROP FOREIGN KEY FK_D4A77ABF2547677');
        $this->addSql('ALTER TABLE impuesto_sobre_renta DROP FOREIGN KEY FK_5EF11EF4A9ECE748');
       */ $this->addSql('CREATE TABLE inposdom_cierre (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, json VARCHAR(1000) NOT NULL, empleado VARCHAR(255) NOT NULL, dop VARCHAR(255) DEFAULT NULL, usd VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
      /*  $this->addSql('DROP TABLE apertura');
        $this->addSql('DROP TABLE comprobante_salario');
        $this->addSql('DROP TABLE impuesto_sobre_renta');
        $this->addSql('DROP TABLE nomina_pago');
        $this->addSql('DROP TABLE nomina_tercero_comprobante');
        $this->addSql('DROP TABLE nominas_consecutivos');
        $this->addSql('DROP TABLE por_ciento_nominas');
        $this->addSql('DROP TABLE rango_escala_dgii');
        $this->addSql('ALTER TABLE cargo ADD salario_base DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE empleado ADD acumulado_tiempo_vacaciones DOUBLE PRECISION DEFAULT NULL, ADD acumulado_dinero_vacaciones DOUBLE PRECISION DEFAULT NULL, DROP salario_x_hora, DROP sueldo_bruto_mensual');
        $this->addSql('ALTER TABLE solicitud_turismo DROP urgente');*/
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
      /*  $this->addSql('CREATE TABLE apertura (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT NOT NULL, nro_cuenta_inventario VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, observacion VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nro_subcuenta_inventario VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nro_cuenta_acreedora VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nro_subcuenta_acreedora VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nro_concecutivo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, anno INT NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_DFFB55EB6601BA07 (id_documento_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE comprobante_salario (id INT AUTO_INCREMENT NOT NULL, id_registro_comprobante_id INT NOT NULL, id_unidad_id INT NOT NULL, mes INT NOT NULL, anno INT NOT NULL, quincena INT NOT NULL, INDEX IDX_8C5550701399A3CF (id_registro_comprobante_id), INDEX IDX_8C5550701D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE impuesto_sobre_renta (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, id_nomina_pago_id INT NOT NULL, id_rango_escala_id INT NOT NULL, seguridad_social_mensual DOUBLE PRECISION DEFAULT NULL, salario_bruto_anual DOUBLE PRECISION NOT NULL, seguridad_social_anual DOUBLE PRECISION DEFAULT NULL, salario_despues_seguridad_social DOUBLE PRECISION NOT NULL, monto_segun_rango DOUBLE PRECISION DEFAULT NULL, monto_segun_rango_escala DOUBLE PRECISION DEFAULT NULL, excedente_segun_rango_escala DOUBLE PRECISION DEFAULT NULL, por_ciento_impuesto_excedente DOUBLE PRECISION DEFAULT NULL, monto_adicional_rango_escala DOUBLE PRECISION DEFAULT NULL, impuesto_renta_pagar_anual DOUBLE PRECISION DEFAULT NULL, impuesto_renta_pagar_mensual DOUBLE PRECISION DEFAULT NULL, fecha DATE NOT NULL, INDEX IDX_5EF11EF48D392AC7 (id_empleado_id), INDEX IDX_5EF11EF4A9ECE748 (id_rango_escala_id), INDEX IDX_5EF11EF4E9DBC8E8 (id_nomina_pago_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nomina_pago (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, id_usuario_aprueba_id INT DEFAULT NULL, id_unidad_id INT NOT NULL, comision DOUBLE PRECISION DEFAULT NULL, vacaciones DOUBLE PRECISION DEFAULT NULL, horas_extra DOUBLE PRECISION DEFAULT NULL, otros DOUBLE PRECISION DEFAULT NULL, total_ingresos DOUBLE PRECISION NOT NULL, ingresos_cotizables_tss DOUBLE PRECISION NOT NULL, isr DOUBLE PRECISION DEFAULT NULL, ars DOUBLE PRECISION DEFAULT NULL, afp DOUBLE PRECISION DEFAULT NULL, cooperativa DOUBLE PRECISION DEFAULT NULL, plan_medico_complementario DOUBLE PRECISION DEFAULT NULL, restaurant DOUBLE PRECISION DEFAULT NULL, total_deducido DOUBLE PRECISION DEFAULT NULL, sueldo_neto_pagar DOUBLE PRECISION DEFAULT NULL, afp_empleador DOUBLE PRECISION DEFAULT NULL, sfs_empleador DOUBLE PRECISION DEFAULT NULL, srl_empleador DOUBLE PRECISION DEFAULT NULL, infotep_empleador DOUBLE PRECISION DEFAULT NULL, mes INT NOT NULL, anno INT NOT NULL, fecha DATE NOT NULL, elaborada TINYINT(1) DEFAULT NULL, aprobada TINYINT(1) DEFAULT NULL, quincena INT NOT NULL, salario_bruto DOUBLE PRECISION DEFAULT NULL, cant_horas_trabajadas DOUBLE PRECISION DEFAULT NULL, INDEX IDX_5CB8BD331D34FA6B (id_unidad_id), INDEX IDX_5CB8BD338D392AC7 (id_empleado_id), INDEX IDX_5CB8BD33AC6A6301 (id_usuario_aprueba_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nomina_tercero_comprobante (id INT AUTO_INCREMENT NOT NULL, id_nomina_id INT NOT NULL, id_unidad_id INT NOT NULL, id_comprobante_id INT DEFAULT NULL, mes INT NOT NULL, anno INT NOT NULL, INDEX IDX_D4A77ABF1800963C (id_comprobante_id), INDEX IDX_D4A77ABF1D34FA6B (id_unidad_id), INDEX IDX_D4A77ABF2547677 (id_nomina_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nominas_consecutivos (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT NOT NULL, mes INT NOT NULL, anno INT NOT NULL, nro_consecutivo INT NOT NULL, INDEX IDX_9FC8A71A1D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE por_ciento_nominas (id INT NOT NULL, por_ciento DOUBLE PRECISION NOT NULL, criterio VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, denominacion INT NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE rango_escala_dgii (id INT AUTO_INCREMENT NOT NULL, anno INT NOT NULL, escala VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, por_ciento DOUBLE PRECISION NOT NULL, minimo DOUBLE PRECISION DEFAULT NULL, maximo DOUBLE PRECISION NOT NULL, activo TINYINT(1) NOT NULL, valor_fijo DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apertura ADD CONSTRAINT FK_DFFB55EB6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comprobante_salario ADD CONSTRAINT FK_8C5550701399A3CF FOREIGN KEY (id_registro_comprobante_id) REFERENCES registro_comprobantes (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE comprobante_salario ADD CONSTRAINT FK_8C5550701D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF48D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF4A9ECE748 FOREIGN KEY (id_rango_escala_id) REFERENCES rango_escala_dgii (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE impuesto_sobre_renta ADD CONSTRAINT FK_5EF11EF4E9DBC8E8 FOREIGN KEY (id_nomina_pago_id) REFERENCES nomina_pago (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD331D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD338D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD33AC6A6301 FOREIGN KEY (id_usuario_aprueba_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante ADD CONSTRAINT FK_D4A77ABF1800963C FOREIGN KEY (id_comprobante_id) REFERENCES registro_comprobantes (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante ADD CONSTRAINT FK_D4A77ABF1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante ADD CONSTRAINT FK_D4A77ABF2547677 FOREIGN KEY (id_nomina_id) REFERENCES nomina_pago (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE nominas_consecutivos ADD CONSTRAINT FK_9FC8A71A1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE inposdom_cierre');
        $this->addSql('ALTER TABLE cargo DROP salario_base');
        $this->addSql('ALTER TABLE empleado ADD salario_x_hora DOUBLE PRECISION DEFAULT NULL, ADD sueldo_bruto_mensual DOUBLE PRECISION DEFAULT NULL, DROP acumulado_tiempo_vacaciones, DROP acumulado_dinero_vacaciones');
        $this->addSql('ALTER TABLE solicitud_turismo ADD urgente VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');

        */
    }
}
