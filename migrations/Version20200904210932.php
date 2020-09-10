<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200904210932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unidad ADD CONSTRAINT FK_F3E6D02F31E700CD FOREIGN KEY (id_padre_id) REFERENCES unidad (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C86601BA07 FOREIGN KEY (id_documento_id) REFERENCES documento (id)');
        $this->addSql('ALTER TABLE vale_salida ADD CONSTRAINT FK_90C265C8F66372E9 FOREIGN KEY (id_elemento_gasto_id) REFERENCES elemento_gasto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unidad DROP FOREIGN KEY FK_F3E6D02F31E700CD');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C86601BA07');
        $this->addSql('ALTER TABLE vale_salida DROP FOREIGN KEY FK_90C265C8F66372E9');
    }
}
