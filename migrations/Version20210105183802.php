<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105183802 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agencias DROP id_user');
        $this->addSql('ALTER TABLE asiento ADD id_area_responsabilidad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE asiento ADD CONSTRAINT FK_71D6D35CD410562 FOREIGN KEY (id_area_responsabilidad_id) REFERENCES area_responsabilidad (id)');
        $this->addSql('CREATE INDEX IDX_71D6D35CD410562 ON asiento (id_area_responsabilidad_id)');
        $this->addSql('ALTER TABLE user ADD id_agencia VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agencias ADD id_user VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE asiento DROP FOREIGN KEY FK_71D6D35CD410562');
        $this->addSql('DROP INDEX IDX_71D6D35CD410562 ON asiento');
        $this->addSql('ALTER TABLE asiento DROP id_area_responsabilidad_id');
        $this->addSql('ALTER TABLE user DROP id_agencia');
    }
}
