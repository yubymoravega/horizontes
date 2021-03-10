<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310134450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servicios ADD id_unidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE servicios ADD CONSTRAINT FK_C07E802F1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('CREATE INDEX IDX_C07E802F1D34FA6B ON servicios (id_unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servicios DROP FOREIGN KEY FK_C07E802F1D34FA6B');
        $this->addSql('DROP INDEX IDX_C07E802F1D34FA6B ON servicios');
        $this->addSql('ALTER TABLE servicios DROP id_unidad_id');
    }
}
