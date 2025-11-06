<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106125509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clima (id INT AUTO_INCREMENT NOT NULL, descripcion VARCHAR(80) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE siniestro (id INT AUTO_INCREMENT NOT NULL, clima_id INT DEFAULT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, ubicacion VARCHAR(255) NOT NULL, descripcion VARCHAR(255) NOT NULL, INDEX IDX_AF55697A23933F8A (clima_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE siniestro ADD CONSTRAINT FK_AF55697A23933F8A FOREIGN KEY (clima_id) REFERENCES clima (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE siniestro DROP FOREIGN KEY FK_AF55697A23933F8A');
        $this->addSql('DROP TABLE clima');
        $this->addSql('DROP TABLE siniestro');
    }
}
