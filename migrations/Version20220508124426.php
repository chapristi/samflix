<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508124426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE serie_upload (id INT AUTO_INCREMENT NOT NULL, serie_id INT DEFAULT NULL, upload_id INT NOT NULL, INDEX IDX_E017BD76D94388BD (serie_id), INDEX IDX_E017BD76CCCFBA31 (upload_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE serie_upload ADD CONSTRAINT FK_E017BD76D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE serie_upload ADD CONSTRAINT FK_E017BD76CCCFBA31 FOREIGN KEY (upload_id) REFERENCES uploads (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE serie_upload');
    }
}
