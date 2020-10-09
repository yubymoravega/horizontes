<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201009020515 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3E6D02F3A909126 ON unidad (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F3E6D02F20332D99 ON unidad (codigo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F3E6D02F3A909126 ON unidad');
        $this->addSql('DROP INDEX UNIQ_F3E6D02F20332D99 ON unidad');
    }
}
