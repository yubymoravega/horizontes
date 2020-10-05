<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201005135143 extends AbstractMigration
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
        $this->addSql('ALTER TABLE contratos_cliente ADD resto DOUBLE PRECISION DEFAULT NULL, ADD id_padre INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE subcuenta_proveedor');
        $this->addSql('ALTER TABLE contratos_cliente DROP resto, DROP id_padre');
    }
}
