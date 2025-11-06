<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106141013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estado_alcoholico (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_civil (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo_etario (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rol (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE siniestro_detalle (id INT AUTO_INCREMENT NOT NULL, siniestro_id INT DEFAULT NULL, persona_id INT DEFAULT NULL, rol_id INT DEFAULT NULL, tipo_vehiculo_id INT DEFAULT NULL, grupo_etario_id INT DEFAULT NULL, estado_civil_id INT DEFAULT NULL, estado_alcoholico_id INT DEFAULT NULL, edad INT NOT NULL, porcentaje_alcohol NUMERIC(10, 2) NOT NULL, vehiculo_modelo VARCHAR(255) NOT NULL, vehiculo_patente VARCHAR(255) NOT NULL, observaciones VARCHAR(255) NOT NULL, INDEX IDX_79FB882090195D8C (siniestro_id), INDEX IDX_79FB8820F5F88DB9 (persona_id), INDEX IDX_79FB88204BAB96C (rol_id), INDEX IDX_79FB882010D3FB8D (tipo_vehiculo_id), INDEX IDX_79FB882036ED91FF (grupo_etario_id), INDEX IDX_79FB882075376D93 (estado_civil_id), INDEX IDX_79FB8820D2B4E9D2 (estado_alcoholico_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_vehiculo (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB882090195D8C FOREIGN KEY (siniestro_id) REFERENCES siniestro (id)');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB8820F5F88DB9 FOREIGN KEY (persona_id) REFERENCES persona (id)');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB88204BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB882010D3FB8D FOREIGN KEY (tipo_vehiculo_id) REFERENCES tipo_vehiculo (id)');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB882036ED91FF FOREIGN KEY (grupo_etario_id) REFERENCES grupo_etario (id)');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB882075376D93 FOREIGN KEY (estado_civil_id) REFERENCES estado_civil (id)');
        $this->addSql('ALTER TABLE siniestro_detalle ADD CONSTRAINT FK_79FB8820D2B4E9D2 FOREIGN KEY (estado_alcoholico_id) REFERENCES estado_alcoholico (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB882090195D8C');
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB8820F5F88DB9');
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB88204BAB96C');
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB882010D3FB8D');
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB882036ED91FF');
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB882075376D93');
        $this->addSql('ALTER TABLE siniestro_detalle DROP FOREIGN KEY FK_79FB8820D2B4E9D2');
        $this->addSql('DROP TABLE estado_alcoholico');
        $this->addSql('DROP TABLE estado_civil');
        $this->addSql('DROP TABLE grupo_etario');
        $this->addSql('DROP TABLE rol');
        $this->addSql('DROP TABLE siniestro_detalle');
        $this->addSql('DROP TABLE tipo_vehiculo');
    }
}
