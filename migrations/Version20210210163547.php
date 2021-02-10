<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210163547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pagos_cotizacion (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, id_empleado INT NOT NULL, monto INT NOT NULL, cambio INT DEFAULT NULL, id_cotizacion INT NOT NULL, id_moneda INT NOT NULL, id_tipo_de_pago INT NOT NULL, id_banco INT DEFAULT NULL, id_cuenta_bancaria INT DEFAULT NULL, numero_confirmacion_deposito VARCHAR(255) DEFAULT NULL, last4_tarjeta INT DEFAULT NULL, codigo_confirmacion_tarjeta VARCHAR(255) DEFAULT NULL, tipo_de_tarjeta VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pagos_cotizacion');
    }
}
