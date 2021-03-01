<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210301141756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unidad ADD id_moneda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('CREATE INDEX IDX_F3E6D02F374388F5 ON unidad (id_moneda_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F374388F5');
        $this->addSql('DROP INDEX IDX_F3E6D02F374388F5 ON unidad');
        $this->addSql('ALTER TABLE unidad DROP id_moneda_id');
    }
}
