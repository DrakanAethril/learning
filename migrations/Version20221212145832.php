<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221212145832 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, author_id INT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, date_create TIME NOT NULL, content JSON DEFAULT NULL, INDEX IDX_BC91F416C54C8C93 (type_id), INDEX IDX_BC91F416F675F31B (author_id), INDEX IDX_BC91F4166BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resource_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416C54C8C93 FOREIGN KEY (type_id) REFERENCES resource_type (id)');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F416F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F4166BF700BD FOREIGN KEY (status_id) REFERENCES resource_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416C54C8C93');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F416F675F31B');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F4166BF700BD');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE resource_status');
        $this->addSql('DROP TABLE resource_type');
    }
}
