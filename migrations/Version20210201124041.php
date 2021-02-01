<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210201124041 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B247B60D7E');
        $this->addSql('DROP INDEX IDX_B2D1B2B247B60D7E ON registro_comprobantes');
        $this->addSql('ALTER TABLE registro_comprobantes DROP id_instrumento_cobro_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registro_comprobantes ADD id_instrumento_cobro_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B247B60D7E FOREIGN KEY (id_instrumento_cobro_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('CREATE INDEX IDX_B2D1B2B247B60D7E ON registro_comprobantes (id_instrumento_cobro_id)');
    }
}
