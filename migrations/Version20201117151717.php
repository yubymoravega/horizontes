<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117151717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud_turismo ADD hotel_adultos VARCHAR(255) DEFAULT NULL, ADD hotel_ninos VARCHAR(255) DEFAULT NULL, ADD tramfer_adultos VARCHAR(255) DEFAULT NULL, ADD tramfer_ninos VARCHAR(255) DEFAULT NULL, ADD tour_ninos VARCHAR(255) DEFAULT NULL, ADD tour_adultos VARCHAR(255) DEFAULT NULL, ADD rent_cantidad_personas VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE solicitud_turismo DROP hotel_adultos, DROP hotel_ninos, DROP tramfer_adultos, DROP tramfer_ninos, DROP tour_ninos, DROP tour_adultos, DROP rent_cantidad_personas');
    }
}
