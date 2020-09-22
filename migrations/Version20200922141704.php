<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200922141704 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movimiento_producto (id INT AUTO_INCREMENT NOT NULL, id_producto_id INT NOT NULL, id_documento_id INT NOT NULL, id_tipo_documento_id INT NOT NULL, id_usuario_id INT DEFAULT NULL, id_centro_costo_id INT DEFAULT NULL, id_elemento_gasto_id INT DEFAULT NULL, cantidad DOUBLE PRECISION NOT NULL, importe DOUBLE PRECISION NOT NULL, existencia DOUBLE PRECISION NOT NULL, fecha DATE NOT NULL, activo TINYINT(1) NOT NULL, entrada TINYINT(1) NOT NULL, INDEX IDX_FFC0EDFC6E57A479 (id_producto_id), INDEX IDX_FFC0EDFC6601BA07 (id_documento_id), INDEX IDX_FFC0EDFC7A4F962 (id_tipo_documento_id), INDEX IDX_FFC0EDFC7EB2C349 (id_usuario_id), INDEX IDX_FFC0EDFCC59B01FF (id_centro_costo_id), INDEX IDX_FFC0EDFCF66372E9 (id_elemento_gasto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC6E57A479 FOREIGN KEY (id_producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC6601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC7A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFC7EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCC59B01FF FOREIGN KEY (id_centro_costo_id) REFERENCES centro_costo (id)');
        $this->addSql('ALTER TABLE movimiento_producto ADD CONSTRAINT FK_FFC0EDFCF66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movimiento_producto');
    }
}
