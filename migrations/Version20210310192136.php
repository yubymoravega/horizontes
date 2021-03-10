<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310192136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plazos_pago_cotizacion (id INT AUTO_INCREMENT NOT NULL, id_cotizacion_id INT NOT NULL, fecha DATE NOT NULL, cuota DOUBLE PRECISION NOT NULL, INDEX IDX_4A1D3ED28E5841CF (id_cotizacion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plazos_pago_cotizacion ADD CONSTRAINT FK_4A1D3ED28E5841CF FOREIGN KEY (id_cotizacion_id) REFERENCES cotizacion (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE plazos_pago_cotizacion');
    }
}
