<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201016235249 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE devolucion (id INT AUTO_INCREMENT NOT NULL, id_documento_id INT DEFAULT NULL, id_unidad_id INT NOT NULL, id_almacen_id INT NOT NULL, nro_cuenta VARCHAR(255) NOT NULL, nro_subcuenta VARCHAR(255) NOT NULL, anno INT NOT NULL, activo TINYINT(1) NOT NULL, INDEX IDX_524D9F676601BA07 (id_documento_id), INDEX IDX_524D9F671D34FA6B (id_unidad_id), INDEX IDX_524D9F6739161EBF (id_almacen_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F676601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F671D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE devolucion ADD CONSTRAINT FK_524D9F6739161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('ALTER TABLE expediente DROP INDEX UNIQ_D59CA4131D34FA6B, ADD INDEX IDX_D59CA4131D34FA6B (id_unidad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE devolucion');
        $this->addSql('ALTER TABLE expediente DROP INDEX IDX_D59CA4131D34FA6B, ADD UNIQUE INDEX UNIQ_D59CA4131D34FA6B (id_unidad_id)');
    }
}
