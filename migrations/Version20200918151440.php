<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918151440 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cotizacion ADD edit VARCHAR(255) NOT NULL, CHANGE datetime datetime DATETIME NOT NULL');
        $this->addSql('ALTER TABLE factura ADD id_cotizacion VARCHAR(255) NOT NULL, ADD id_pre_factura VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pre_facturas ADD id_cotizacion VARCHAR(255) NOT NULL, ADD edit VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cotizacion DROP edit, CHANGE datetime datetime VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE factura DROP id_cotizacion, DROP id_pre_factura');
        $this->addSql('ALTER TABLE pre_facturas DROP id_cotizacion, DROP edit');
    }
}
