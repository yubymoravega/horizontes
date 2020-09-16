<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200916204901 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alamcen_ocupado (id INT AUTO_INCREMENT NOT NULL, id_almaceh_id INT NOT NULL, id_usuario_id INT NOT NULL, INDEX IDX_35E394221C7D4163 (id_almaceh_id), INDEX IDX_35E394227EB2C349 (id_usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alamcen_ocupado ADD CONSTRAINT FK_35E394221C7D4163 FOREIGN KEY (id_almaceh_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE alamcen_ocupado ADD CONSTRAINT FK_35E394227EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE centro_costo ADD id_elemento_gasto LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE alamcen_ocupado');
        $this->addSql('ALTER TABLE centro_costo DROP id_elemento_gasto');
    }
}
