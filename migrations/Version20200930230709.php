<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200930230709 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ajuste ADD nro_subcuenta_acreedora VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mercancia CHANGE id_unidad_medida_id id_unidad_medida_id INT NOT NULL');
        $this->addSql('ALTER TABLE transferencia ADD nro_subcuenta_acreedora VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE unidad_medida CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ajuste DROP nro_subcuenta_acreedora');
        $this->addSql('ALTER TABLE mercancia CHANGE id_unidad_medida_id id_unidad_medida_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transferencia DROP nro_subcuenta_acreedora');
        $this->addSql('ALTER TABLE unidad_medida CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
