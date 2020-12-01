<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111152053 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud_turismo CHANGE vuelo_ida vuelo_ida VARCHAR(255) NOT NULL, CHANGE vuelo_vuelta vuelo_vuelta VARCHAR(255) DEFAULT NULL, CHANGE tranfer_llegada tranfer_llegada VARCHAR(255) DEFAULT NULL, CHANGE tramfer_salida tramfer_salida VARCHAR(255) DEFAULT NULL, CHANGE tour_fecha tour_fecha VARCHAR(255) DEFAULT NULL, CHANGE rent_fecha_desde rent_fecha_desde VARCHAR(255) DEFAULT NULL, CHANGE hotel_desde hotel_desde VARCHAR(255) DEFAULT NULL, CHANGE hotel_hasta hotel_hasta VARCHAR(255) DEFAULT NULL, CHANGE rent_fecha_hasta rent_fecha_hasta VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud_turismo CHANGE vuelo_ida vuelo_ida DATE NOT NULL, CHANGE vuelo_vuelta vuelo_vuelta DATE DEFAULT NULL, CHANGE tranfer_llegada tranfer_llegada DATETIME DEFAULT NULL, CHANGE tramfer_salida tramfer_salida DATETIME DEFAULT NULL, CHANGE tour_fecha tour_fecha DATE DEFAULT NULL, CHANGE rent_fecha_desde rent_fecha_desde DATE DEFAULT NULL, CHANGE hotel_desde hotel_desde DATE DEFAULT NULL, CHANGE hotel_hasta hotel_hasta DATE DEFAULT NULL, CHANGE rent_fecha_hasta rent_fecha_hasta DATE DEFAULT NULL');
    }
}
