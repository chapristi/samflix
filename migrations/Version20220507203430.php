<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507203430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_of_upload (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, upload_id INT NOT NULL, INDEX IDX_5F665BA412469DE2 (category_id), INDEX IDX_5F665BA4CCCFBA31 (upload_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_of_upload ADD CONSTRAINT FK_5F665BA412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE categories_of_upload ADD CONSTRAINT FK_5F665BA4CCCFBA31 FOREIGN KEY (upload_id) REFERENCES uploads (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE categories_of_upload');
    }
}
