<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210220020448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE configuracion_reglas_remesas (id INT AUTO_INCREMENT NOT NULL, id_pais_id INT NOT NULL, id_proveedor_id INT NOT NULL, minimo DOUBLE PRECISION NOT NULL, maximo DOUBLE PRECISION NOT NULL, valor_fijo_costo DOUBLE PRECISION DEFAULT NULL, porciento_costo DOUBLE PRECISION DEFAULT NULL, valor_fijo_venta DOUBLE PRECISION DEFAULT NULL, porciento_venta DOUBLE PRECISION DEFAULT NULL, INDEX IDX_2398566118997CB6 (id_pais_id), INDEX IDX_23985661E8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_2398566118997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE configuracion_reglas_remesas ADD CONSTRAINT FK_23985661E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE configuracion_reglas_remesas');
    }
}
