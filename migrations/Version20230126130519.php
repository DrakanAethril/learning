<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126130519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainings ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE trainings ADD CONSTRAINT FK_66DC43306BF700BD FOREIGN KEY (status_id) REFERENCES trainings_status (id)');
        $this->addSql('CREATE INDEX IDX_66DC43306BF700BD ON trainings (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainings DROP FOREIGN KEY FK_66DC43306BF700BD');
        $this->addSql('DROP INDEX IDX_66DC43306BF700BD ON trainings');
        $this->addSql('ALTER TABLE trainings DROP status_id');
    }
}
