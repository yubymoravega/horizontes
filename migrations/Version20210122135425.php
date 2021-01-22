<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122135425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nomina_tercero_comprobante (id INT AUTO_INCREMENT NOT NULL, id_nomina_id INT NOT NULL, id_unidad_id INT NOT NULL, id_comprobante_id INT DEFAULT NULL, mes INT NOT NULL, anno INT NOT NULL, INDEX IDX_D4A77ABF2547677 (id_nomina_id), INDEX IDX_D4A77ABF1D34FA6B (id_unidad_id), INDEX IDX_D4A77ABF1800963C (id_comprobante_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante ADD CONSTRAINT FK_D4A77ABF2547677 FOREIGN KEY (id_nomina_id) REFERENCES nomina_pago (id)');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante ADD CONSTRAINT FK_D4A77ABF1D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE nomina_tercero_comprobante ADD CONSTRAINT FK_D4A77ABF1800963C FOREIGN KEY (id_comprobante_id) REFERENCES registro_comprobantes (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE nomina_tercero_comprobante');
    }
}
