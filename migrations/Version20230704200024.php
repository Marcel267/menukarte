<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704200024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bestellung (id INT AUTO_INCREMENT NOT NULL, tisch VARCHAR(255) DEFAULT NULL, bnummer VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, preis DOUBLE PRECISION DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kategorie (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, stadt VARCHAR(255) NOT NULL, telefon VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gericht ADD kategorie_id INT DEFAULT NULL, ADD bild VARCHAR(255) NOT NULL, ADD preis DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE gericht ADD CONSTRAINT FK_FEA51929BAF991D3 FOREIGN KEY (kategorie_id) REFERENCES kategorie (id)');
        $this->addSql('CREATE INDEX IDX_FEA51929BAF991D3 ON gericht (kategorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gericht DROP FOREIGN KEY FK_FEA51929BAF991D3');
        $this->addSql('DROP TABLE bestellung');
        $this->addSql('DROP TABLE kategorie');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_FEA51929BAF991D3 ON gericht');
        $this->addSql('ALTER TABLE gericht DROP kategorie_id, DROP bild, DROP preis');
    }
}
