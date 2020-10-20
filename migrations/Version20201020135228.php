<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201020135228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orden_trabajo ADD id_almacen_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orden_trabajo ADD CONSTRAINT FK_4158A02439161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_4158A02439161EBF ON orden_trabajo (id_almacen_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orden_trabajo DROP FOREIGN KEY FK_4158A02439161EBF');
        $this->addSql('DROP INDEX IDX_4158A02439161EBF ON orden_trabajo');
        $this->addSql('ALTER TABLE orden_trabajo DROP id_almacen_id');
    }
}
