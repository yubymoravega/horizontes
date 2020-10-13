<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201013154142 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cierre ADD id_usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cierre ADD CONSTRAINT FK_D0DCFCC77EB2C349 FOREIGN KEY (id_usuario_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D0DCFCC77EB2C349 ON cierre (id_usuario_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cierre DROP FOREIGN KEY FK_D0DCFCC77EB2C349');
        $this->addSql('DROP INDEX IDX_D0DCFCC77EB2C349 ON cierre');
        $this->addSql('ALTER TABLE cierre DROP id_usuario_id');
    }
}
