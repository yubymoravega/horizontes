<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009131535 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documento ADD id_tipo_documento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC77A4F962 FOREIGN KEY (id_tipo_documento_id) REFERENCES tipo_documento (id)');
        $this->addSql('CREATE INDEX IDX_B6B12EC77A4F962 ON documento (id_tipo_documento_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC77A4F962');
        $this->addSql('DROP INDEX IDX_B6B12EC77A4F962 ON documento');
        $this->addSql('ALTER TABLE documento DROP id_tipo_documento_id');
    }
}
