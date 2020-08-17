<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200816181425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado CHANGE id_cargo_id id_cargo_id INT DEFAULT NULL, CHANGE correo correo VARCHAR(255) DEFAULT NULL, CHANGE baja baja TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD status TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE empleado CHANGE id_cargo_id id_cargo_id INT NOT NULL, CHANGE correo correo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE baja baja TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP status');
    }
}
