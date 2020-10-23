<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023020146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuadre_diario ADD id_almacen_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD939161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_60ABEFD939161EBF ON cuadre_diario (id_almacen_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuadre_diario DROP FOREIGN KEY FK_60ABEFD939161EBF');
        $this->addSql('DROP INDEX IDX_60ABEFD939161EBF ON cuadre_diario');
        $this->addSql('ALTER TABLE cuadre_diario DROP id_almacen_id');
    }
}
