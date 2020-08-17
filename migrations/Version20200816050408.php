<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816050408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado ADD id_usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE empleado ADD CONSTRAINT FK_D9D9BF527EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D9D9BF527EB2C349 ON empleado (id_usuario_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado DROP FOREIGN KEY FK_D9D9BF527EB2C349');
        $this->addSql('DROP INDEX UNIQ_D9D9BF527EB2C349 ON empleado');
        $this->addSql('ALTER TABLE empleado DROP id_usuario_id');
    }
}
