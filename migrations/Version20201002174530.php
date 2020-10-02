<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201002174530 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE subcuenta_proveedor (id INT AUTO_INCREMENT NOT NULL, id_subcuenta_id INT NOT NULL, id_proveedor_id INT NOT NULL, INDEX IDX_5C22E4B82D412F53 (id_subcuenta_id), INDEX IDX_5C22E4B8E8F12801 (id_proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subcuenta_proveedor ADD CONSTRAINT FK_5C22E4B82D412F53 FOREIGN KEY (id_subcuenta_id) REFERENCES subcuenta (id)');
        $this->addSql('ALTER TABLE subcuenta_proveedor ADD CONSTRAINT FK_5C22E4B8E8F12801 FOREIGN KEY (id_proveedor_id) REFERENCES proveedor (id)');
        $this->addSql('ALTER TABLE empleado CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF521D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF52D1E12F15 FOREIGN KEY (id_cargo_id) REFERENCES cargo (id)');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF527EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9D9BF521D34FA6B ON empleado (id_unidad_id)');
        $this->addSql('CREATE INDEX IDX_D9D9BF52D1E12F15 ON empleado (id_cargo_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D9D9BF527EB2C349 ON empleado (id_usuario_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subcuenta_proveedor');
        $this->addSql('ALTER TABLE empleado MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF521D34FA6B');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF52D1E12F15');
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF527EB2C349');
        $this->addSql('DROP INDEX IDX_D9D9BF521D34FA6B ON empleado');
        $this->addSql('DROP INDEX IDX_D9D9BF52D1E12F15 ON empleado');
        $this->addSql('DROP INDEX UNIQ_D9D9BF527EB2C349 ON empleado');
        $this->addSql('ALTER TABLE empleado DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE empleado CHANGE id id INT NOT NULL');
    }
}
