<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108222736 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acumulado_vacaciones (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, dias DOUBLE PRECISION NOT NULL, dinero DOUBLE PRECISION NOT NULL, INDEX IDX_246B9D168D392AC7 (id_empleado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vacaciones_disfrutadas (id INT AUTO_INCREMENT NOT NULL, id_empleado_id INT NOT NULL, cantidad_dias INT NOT NULL, cantidad_pagada DOUBLE PRECISION NOT NULL, fecha_inicio DATE DEFAULT NULL, fecha_fin DATE DEFAULT NULL, INDEX IDX_F02817318D392AC7 (id_empleado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acumulado_vacaciones ADD CONSTRAINT FK_246B9D168D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE vacaciones_disfrutadas ADD CONSTRAINT FK_F02817318D392AC7 FOREIGN KEY (id_empleado_id) REFERENCES empleado (id)');
        $this->addSql('ALTER TABLE empleado ADD identificacion VARCHAR(255) NOT NULL, DROP salario_x_hora');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE acumulado_vacaciones');
        $this->addSql('DROP TABLE vacaciones_disfrutadas');
        $this->addSql('ALTER TABLE empleado ADD salario_x_hora DOUBLE PRECISION DEFAULT NULL, DROP identificacion');
    }
}
