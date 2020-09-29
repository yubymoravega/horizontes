<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200928225729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subcuenta_criterio_analisis (id INT AUTO_INCREMENT NOT NULL, id_subcuenta_id INT NOT NULL, id_criterio_analisis_id INT NOT NULL, INDEX IDX_52A4A7682D412F53 (id_subcuenta_id), INDEX IDX_52A4A7685ABBE5F6 (id_criterio_analisis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7682D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_criterio_analisis ADD CONSTRAINT FK_52A4A7685ABBE5F6 FOREIGN KEY (id_criterio_analisis_id) REFERENCES criterio_analisis (id)');
        $this->addSql('ALTER TABLE cuenta CHANGE nro_cuenta nro_cuenta INT NOT NULL, CHANGE elemento_gasto mixta TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE subcuenta ADD elemento_gasto TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE unidad_medida ADD abreviatura VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subcuenta_criterio_analisis');
        $this->addSql('ALTER TABLE cuenta CHANGE nro_cuenta nro_cuenta VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE mixta elemento_gasto TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE subcuenta DROP elemento_gasto');
        $this->addSql('ALTER TABLE unidad_medida DROP abreviatura');
    }
}
