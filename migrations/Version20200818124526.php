<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818124526 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE custom_user');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE custom_user (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_unidad_id INT NOT NULL, nombre_completo VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, correo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8CE51EB479F37AE5 (id_user_id), INDEX IDX_8CE51EB41D34FA6B (id_unidad_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE custom_user ADD CONSTRAINT FK_8CE51EB41D34FA6B FOREIGN KEY (id_unidad_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE custom_user ADD CONSTRAINT FK_8CE51EB479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE reset_password_request');
    }
}
