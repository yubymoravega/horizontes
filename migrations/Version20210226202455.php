<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226202455 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beneficiarios_clientes (id INT AUTO_INCREMENT NOT NULL, id_cliente_id INT NOT NULL, id_pais_id INT NOT NULL, id_provincia_id INT NOT NULL, id_municipio_id INT NOT NULL, primer_nombre VARCHAR(255) NOT NULL, primer_apellido VARCHAR(255) NOT NULL, segundo_apellido VARCHAR(255) NOT NULL, nombre_alternativo VARCHAR(255) DEFAULT NULL, primer_apellido_alternativo VARCHAR(255) DEFAULT NULL, segundo_apellido_alternativo VARCHAR(255) DEFAULT NULL, primer_telefono VARCHAR(255) DEFAULT NULL, segundo_telefono VARCHAR(255) DEFAULT NULL, identificacion VARCHAR(255) DEFAULT NULL, calle VARCHAR(255) NOT NULL, entre VARCHAR(255) DEFAULT NULL, y VARCHAR(255) DEFAULT NULL, nro_casa VARCHAR(255) DEFAULT NULL, edificio VARCHAR(255) DEFAULT NULL, apto VARCHAR(255) DEFAULT NULL, reparto VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_AE9DBD1E7BF9CE86 (id_cliente_id), INDEX IDX_AE9DBD1E18997CB6 (id_pais_id), INDEX IDX_AE9DBD1E6DB054DD (id_provincia_id), INDEX IDX_AE9DBD1E7B7D6E92 (id_municipio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E7BF9CE86 FOREIGN KEY (id_cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E18997CB6 FOREIGN KEY (id_pais_id) REFERENCES pais (id)');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E6DB054DD FOREIGN KEY (id_provincia_id) REFERENCES provincias (id)');
        $this->addSql('ALTER TABLE beneficiarios_clientes ADD CONSTRAINT FK_AE9DBD1E7B7D6E92 FOREIGN KEY (id_municipio_id) REFERENCES municipios (id)');
        $this->addSql('ALTER TABLE cliente_beneficiario ADD id_pais INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beneficiarios_clientes');
        $this->addSql('ALTER TABLE cliente_beneficiario DROP id_pais');
    }
}
