<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201023123633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cuadre_diario (id INT AUTO_INCREMENT NOT NULL, id_cuenta_id INT NOT NULL, id_subcuenta_id INT NOT NULL, id_cierre_id INT NOT NULL, id_almacen_id INT NOT NULL, str_analisis VARCHAR(255) DEFAULT NULL, fecha DATE NOT NULL, saldo NUMERIC(10, 2) NOT NULL, debito DOUBLE PRECISION NOT NULL, credito DOUBLE PRECISION NOT NULL, INDEX IDX_60ABEFD91ADA4D3F (id_cuenta_id), INDEX IDX_60ABEFD92D412F53 (id_subcuenta_id), INDEX IDX_60ABEFD945F8C94C (id_cierre_id), INDEX IDX_60ABEFD939161EBF (id_almacen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD91ADA4D3F FOREIGN KEY (id_cuenta_id) REFERENCES cuenta (id)');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD92D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD945F8C94C FOREIGN KEY (id_cierre_id) REFERENCES cierre (id)');
        $this->addSql('ALTER TABLE cuadre_diario ADD CONSTRAINT FK_60ABEFD939161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE cuenta_criterio_analisis ADD orden INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cuadre_diario');
        $this->addSql('ALTER TABLE cuenta_criterio_analisis DROP orden');
    }
}
