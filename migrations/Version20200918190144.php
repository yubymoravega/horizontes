<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200918190144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documento ADD id_moneda_id INT NOT NULL');
        $this->addSql('ALTER TABLE documento ADD CONSTRAINT FK_B6B12EC7374388F5 FOREIGN KEY (id_moneda_id) REFERENCES moneda (id)');
        $this->addSql('CREATE INDEX IDX_B6B12EC7374388F5 ON documento (id_moneda_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE test');
        $this->addSql('ALTER TABLE documento DROP FOREIGN KEY FK_B6B12EC7374388F5');
        $this->addSql('DROP INDEX IDX_B6B12EC7374388F5 ON documento');
        $this->addSql('ALTER TABLE documento DROP id_moneda_id');
    }
}
