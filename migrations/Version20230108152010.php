<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230108152010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trainings (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, resource_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, force_requirements TINYINT(1) DEFAULT NULL, params JSON NOT NULL, creation_date TIME NOT NULL, start_date TIME NOT NULL, end_date TIME DEFAULT NULL, INDEX IDX_66DC4330F675F31B (author_id), INDEX IDX_66DC433089329D25 (resource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainings_cohort (trainings_id INT NOT NULL, cohort_id INT NOT NULL, INDEX IDX_596CC1FF161BA2FF (trainings_id), INDEX IDX_596CC1FF35983C93 (cohort_id), PRIMARY KEY(trainings_id, cohort_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainings_resource (trainings_id INT NOT NULL, resource_id INT NOT NULL, INDEX IDX_A9BC31DC161BA2FF (trainings_id), INDEX IDX_A9BC31DC89329D25 (resource_id), PRIMARY KEY(trainings_id, resource_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trainings ADD CONSTRAINT FK_66DC4330F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE trainings ADD CONSTRAINT FK_66DC433089329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE trainings_cohort ADD CONSTRAINT FK_596CC1FF161BA2FF FOREIGN KEY (trainings_id) REFERENCES trainings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainings_cohort ADD CONSTRAINT FK_596CC1FF35983C93 FOREIGN KEY (cohort_id) REFERENCES cohort (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainings_resource ADD CONSTRAINT FK_A9BC31DC161BA2FF FOREIGN KEY (trainings_id) REFERENCES trainings (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainings_resource ADD CONSTRAINT FK_A9BC31DC89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trainings DROP FOREIGN KEY FK_66DC4330F675F31B');
        $this->addSql('ALTER TABLE trainings DROP FOREIGN KEY FK_66DC433089329D25');
        $this->addSql('ALTER TABLE trainings_cohort DROP FOREIGN KEY FK_596CC1FF161BA2FF');
        $this->addSql('ALTER TABLE trainings_cohort DROP FOREIGN KEY FK_596CC1FF35983C93');
        $this->addSql('ALTER TABLE trainings_resource DROP FOREIGN KEY FK_A9BC31DC161BA2FF');
        $this->addSql('ALTER TABLE trainings_resource DROP FOREIGN KEY FK_A9BC31DC89329D25');
        $this->addSql('DROP TABLE trainings');
        $this->addSql('DROP TABLE trainings_cohort');
        $this->addSql('DROP TABLE trainings_resource');
    }
}
