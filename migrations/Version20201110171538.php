<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110171538 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE solicitud_turismo (id INT AUTO_INCREMENT NOT NULL, vuelo_cantidad_adultos VARCHAR(255) DEFAULT NULL, vuelo_cantidad_ninos VARCHAR(255) DEFAULT NULL, vuelo_origen VARCHAR(255) DEFAULT NULL, vuelo_destino VARCHAR(255) DEFAULT NULL, vuelo_ida DATE NOT NULL, vuelo_vuelta DATE DEFAULT NULL, vuelo_comentario VARCHAR(255) DEFAULT NULL, hotel_destino VARCHAR(255) DEFAULT NULL, hotel_nombre VARCHAR(255) DEFAULT NULL, hotel_categoria VARCHAR(255) DEFAULT NULL, hotel_plan VARCHAR(255) DEFAULT NULL, hotel_comentario VARCHAR(255) DEFAULT NULL, tranfer_llegada DATETIME DEFAULT NULL, tramfer_salida DATETIME DEFAULT NULL, tramfer_lugar VARCHAR(255) DEFAULT NULL, tramfer_destino VARCHAR(255) DEFAULT NULL, tramfer_vehiculo VARCHAR(255) DEFAULT NULL, tramfer_comentario VARCHAR(255) DEFAULT NULL, tour_nombre VARCHAR(255) DEFAULT NULL, tour_fecha DATE DEFAULT NULL, tour_comentario VARCHAR(255) DEFAULT NULL, tour_cantidad_adultos VARCHAR(255) DEFAULT NULL, tour_cantidad_ninos VARCHAR(255) DEFAULT NULL, rent_tipo_vehiculo VARCHAR(255) DEFAULT NULL, rent_lugar_recogida VARCHAR(255) DEFAULT NULL, rent_lugar_entrega VARCHAR(255) DEFAULT NULL, rent_comentario VARCHAR(255) DEFAULT NULL, rent_fecha_desde DATE DEFAULT NULL, hotel_desde DATE DEFAULT NULL, hotel_hasta DATE DEFAULT NULL, rent_fecha_hasta DATE DEFAULT NULL, empleado VARCHAR(255) NOT NULL, id_cliente VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE solicitud_turismo');
    }
}
