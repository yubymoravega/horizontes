<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200915142324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centro_costo ADD id_elemento_gasto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE centro_costo ADD CONSTRAINT FK_749608CEF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
        $this->addSql('CREATE INDEX IDX_749608CEF66372E9 ON centro_costo (id_elemento_gasto_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE centro_costo DROP FOREIGN KEY FK_749608CEF66372E9');
        $this->addSql('DROP INDEX IDX_749608CEF66372E9 ON centro_costo');
        $this->addSql('ALTER TABLE centro_costo DROP id_elemento_gasto_id');
    }
}
