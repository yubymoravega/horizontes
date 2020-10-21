<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201021174823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comprobante_cierre (id INT AUTO_INCREMENT NOT NULL, id_comprobante_id INT NOT NULL, id_cierre_id INT NOT NULL, INDEX IDX_D03EA4C51800963C (id_comprobante_id), INDEX IDX_D03EA4C545F8C94C (id_cierre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comprobante_cierre ADD CONSTRAINT FK_D03EA4C51800963C FOREIGN KEY (id_comprobante_id) REFERENCES registro_comprobantes (id)');
        $this->addSql('ALTER TABLE comprobante_cierre ADD CONSTRAINT FK_D03EA4C545F8C94C FOREIGN KEY (id_cierre_id) REFERENCES cierre (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comprobante_cierre');
    }
}
