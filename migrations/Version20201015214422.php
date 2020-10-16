<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201015214422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expediente (id INT AUTO_INCREMENT NOT NULL, id_unidad_id INT DEFAULT NULL, codigo VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D59CA4131D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expediente ADD CONSTRAINT FK_D59CA4131D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE cierre ADD id_usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cierre ADD CONSTRAINT FK_D0DCFCC77EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D0DCFCC77EB2C349 ON cierre (id_usuario_id)');
        $this->addSql('ALTER TABLE registro_comprobantes ADD id_almacen_id INT NOT NULL, ADD anno INT NOT NULL');
        $this->addSql('ALTER TABLE registro_comprobantes ADD CONSTRAINT FK_B2D1B2B239161EBF FOREIGN KEY (id_almacen_id) REFERENCES almacen (id)');
        $this->addSql('CREATE INDEX IDX_B2D1B2B239161EBF ON registro_comprobantes (id_almacen_id)');
        $this->addSql('ALTER TABLE tipo_comprobante CHANGE id id INT NOT NULL, CHANGE boolean abreviatura VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE expediente');
        $this->addSql('ALTER TABLE cierre DROP FOREIGN KEY FK_D0DCFCC77EB2C349');
        $this->addSql('DROP INDEX IDX_D0DCFCC77EB2C349 ON cierre');
        $this->addSql('ALTER TABLE cierre DROP id_usuario_id');
        $this->addSql('ALTER TABLE registro_comprobantes DROP FOREIGN KEY FK_B2D1B2B239161EBF');
        $this->addSql('DROP INDEX IDX_B2D1B2B239161EBF ON registro_comprobantes');
        $this->addSql('ALTER TABLE registro_comprobantes DROP id_almacen_id, DROP anno');
        $this->addSql('ALTER TABLE tipo_comprobante CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE abreviatura boolean VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
