<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508172135 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_of_upload ADD serie_id INT NOT NULL');
        $this->addSql('ALTER TABLE categories_of_upload ADD CONSTRAINT FK_5F665BA4D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('CREATE INDEX IDX_5F665BA4D94388BD ON categories_of_upload (serie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_of_upload DROP FOREIGN KEY FK_5F665BA4D94388BD');
        $this->addSql('DROP INDEX IDX_5F665BA4D94388BD ON categories_of_upload');
        $this->addSql('ALTER TABLE categories_of_upload DROP serie_id');
    }
}
