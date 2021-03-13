<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313053642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, plan_hotel_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, categoria INT NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_3535ED93C268C62 (plan_hotel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_hotel (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sol_hotel (id INT AUTO_INCREMENT NOT NULL, hotel_id INT NOT NULL, destino_id INT NOT NULL, cant_adulto INT NOT NULL, cant_nino INT NOT NULL, fecha_desde DATE NOT NULL, fecha_hasta DATE NOT NULL, comentario LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_52536CDE3243BB18 (hotel_id), INDEX IDX_52536CDEE4360615 (destino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sol_rent_car (id INT AUTO_INCREMENT NOT NULL, entrega_id INT NOT NULL, recogida_id INT NOT NULL, tipo_vehiculo_id INT NOT NULL, cant_persona INT NOT NULL, fecha_desde DATETIME NOT NULL, fecha_hasta DATETIME NOT NULL, comentario LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_9F58603D7AB91AEC (entrega_id), INDEX IDX_9F58603D81E0EBAC (recogida_id), INDEX IDX_9F58603D10D3FB8D (tipo_vehiculo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sol_tour (id INT AUTO_INCREMENT NOT NULL, tour_id INT NOT NULL, cant_adulto INT NOT NULL, cant_nino INT NOT NULL, fecha_salida DATETIME NOT NULL, comentario LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_B4E3C45815ED8D43 (tour_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sol_tranfer (id INT AUTO_INCREMENT NOT NULL, origen_id INT NOT NULL, destino_id INT NOT NULL, tipo_vehiculo_id INT NOT NULL, cant_adulto INT NOT NULL, cant_nino INT NOT NULL, fecha DATETIME NOT NULL, fecha_salida DATETIME NOT NULL, ida_retorno TINYINT(1) NOT NULL, comentario LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_D147F76693529ECD (origen_id), INDEX IDX_D147F766E4360615 (destino_id), INDEX IDX_D147F76610D3FB8D (tipo_vehiculo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sol_vuelo (id INT AUTO_INCREMENT NOT NULL, origen_id INT NOT NULL, destino_id INT NOT NULL, cant_adulto INT NOT NULL, cant_nino INT NOT NULL, fecha DATETIME NOT NULL, comentario LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_E708D17293529ECD (origen_id), INDEX IDX_E708D172E4360615 (destino_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tour (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED93C268C62 FOREIGN KEY (plan_hotel_id) REFERENCES plan_hotel (id)');
        $this->addSql('ALTER TABLE sol_hotel ADD CONSTRAINT FK_52536CDE3243BB18 FOREIGN KEY (hotel_id) REFERENCES hotel (id)');
        $this->addSql('ALTER TABLE sol_hotel ADD CONSTRAINT FK_52536CDEE4360615 FOREIGN KEY (destino_id) REFERENCES lugares (id)');
        $this->addSql('ALTER TABLE sol_rent_car ADD CONSTRAINT FK_9F58603D7AB91AEC FOREIGN KEY (entrega_id) REFERENCES lugares (id)');
        $this->addSql('ALTER TABLE sol_rent_car ADD CONSTRAINT FK_9F58603D81E0EBAC FOREIGN KEY (recogida_id) REFERENCES lugares (id)');
        $this->addSql('ALTER TABLE sol_rent_car ADD CONSTRAINT FK_9F58603D10D3FB8D FOREIGN KEY (tipo_vehiculo_id) REFERENCES tipo_vehiculo (id)');
        $this->addSql('ALTER TABLE sol_tour ADD CONSTRAINT FK_B4E3C45815ED8D43 FOREIGN KEY (tour_id) REFERENCES tour (id)');
        $this->addSql('ALTER TABLE sol_tranfer ADD CONSTRAINT FK_D147F76693529ECD FOREIGN KEY (origen_id) REFERENCES lugares (id)');
        $this->addSql('ALTER TABLE sol_tranfer ADD CONSTRAINT FK_D147F766E4360615 FOREIGN KEY (destino_id) REFERENCES lugares (id)');
        $this->addSql('ALTER TABLE sol_tranfer ADD CONSTRAINT FK_D147F76610D3FB8D FOREIGN KEY (tipo_vehiculo_id) REFERENCES tipo_vehiculo (id)');
        $this->addSql('ALTER TABLE sol_vuelo ADD CONSTRAINT FK_E708D17293529ECD FOREIGN KEY (origen_id) REFERENCES lugares (id)');
        $this->addSql('ALTER TABLE sol_vuelo ADD CONSTRAINT FK_E708D172E4360615 FOREIGN KEY (destino_id) REFERENCES lugares (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sol_hotel DROP FOREIGN KEY FK_52536CDE3243BB18');
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED93C268C62');
        $this->addSql('ALTER TABLE sol_tour DROP FOREIGN KEY FK_B4E3C45815ED8D43');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE plan_hotel');
        $this->addSql('DROP TABLE sol_hotel');
        $this->addSql('DROP TABLE sol_rent_car');
        $this->addSql('DROP TABLE sol_tour');
        $this->addSql('DROP TABLE sol_tranfer');
        $this->addSql('DROP TABLE sol_vuelo');
        $this->addSql('DROP TABLE tour');
    }
}
