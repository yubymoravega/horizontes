<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208152304 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD id_instrumento_cobro_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones ADD CONSTRAINT FK_E7EA17E47B60D7E FOREIGN KEY (id_instrumento_cobro_id) REFERENCES instrumento_cobro (id)');
        $this->addSql('CREATE INDEX IDX_E7EA17E47B60D7E ON operaciones_comprobante_operaciones (id_instrumento_cobro_id)');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP FOREIGN KEY FK_E7EA17E47B60D7E');
        $this->addSql('DROP INDEX IDX_E7EA17E47B60D7E ON operaciones_comprobante_operaciones');
        $this->addSql('ALTER TABLE operaciones_comprobante_operaciones DROP id_instrumento_cobro_id');
        $this->addSql('ALTER TABLE tipo_movimiento CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
