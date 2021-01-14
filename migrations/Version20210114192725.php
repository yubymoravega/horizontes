<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114192725 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nomina_pago (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, id_usuario_aprueba_id INT DEFAULT NULL, comision DOUBLE PRECISION DEFAULT NULL, vacaciones DOUBLE PRECISION DEFAULT NULL, horas_extra DOUBLE PRECISION DEFAULT NULL, otros DOUBLE PRECISION DEFAULT NULL, total_ingresos DOUBLE PRECISION NOT NULL, ingresos_cotizables_tss DOUBLE PRECISION NOT NULL, isr DOUBLE PRECISION DEFAULT NULL, ars DOUBLE PRECISION DEFAULT NULL, afp DOUBLE PRECISION DEFAULT NULL, cooperativa DOUBLE PRECISION DEFAULT NULL, plan_medico_complementario DOUBLE PRECISION DEFAULT NULL, restaurant DOUBLE PRECISION DEFAULT NULL, total_deducido DOUBLE PRECISION DEFAULT NULL, sueldo_neto_pagar DOUBLE PRECISION DEFAULT NULL, afp_empleador DOUBLE PRECISION DEFAULT NULL, sfs_empleador DOUBLE PRECISION DEFAULT NULL, srl_empleador DOUBLE PRECISION DEFAULT NULL, infotep_empleador DOUBLE PRECISION DEFAULT NULL, mes INT NOT NULL, anno INT NOT NULL, fecha DATE NOT NULL, elaborada TINYINT(1) DEFAULT NULL, aprobada TINYINT(1) DEFAULT NULL, INDEX IDX_5CB8BD338D392AC7 (id_empleado_id), INDEX IDX_5CB8BD33AC6A6301 (id_usuario_aprueba_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD338D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE nomina_pago ADD CONSTRAINT FK_5CB8BD33AC6A6301 FOREIGN KEY (id_usuario_aprueba_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE nomina_pago');
    }
}
