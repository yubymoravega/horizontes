<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211193258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asiento ADD id_cotizacion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35C8E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35C8E5841CF ON asiento (id_cotizacion_id)');
        $this->addSql('ALTER TABLE carrito CHANGE json json VARCHAR(1500) NOT NULL');
        $this->addSql('ALTER TABLE cotizacion ADD pagado TINYINT(1) DEFAULT NULL, ADD id_factura INT DEFAULT NULL');
       // $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        /*// this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35C8E5841CF');
        $this->addSql('DROP INDEX IDX_71D6D35C8E5841CF ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_cotizacion_id');
        $this->addSql('ALTER TABLE carrito CHANGE json json VARCHAR(15000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE cotizacion DROP pagado, DROP id_factura');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');*/
    }
}
