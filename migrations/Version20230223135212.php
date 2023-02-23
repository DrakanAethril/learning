<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230223135212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE register_key (id INT AUTO_INCREMENT NOT NULL, key_code VARCHAR(255) NOT NULL, status INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE register_key_structure (register_key_id INT NOT NULL, structure_id INT NOT NULL, INDEX IDX_4D663505BEA42DD9 (register_key_id), INDEX IDX_4D6635052534008B (structure_id), PRIMARY KEY(register_key_id, structure_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE register_key_cohort (register_key_id INT NOT NULL, cohort_id INT NOT NULL, INDEX IDX_8D0CF40DBEA42DD9 (register_key_id), INDEX IDX_8D0CF40D35983C93 (cohort_id), PRIMARY KEY(register_key_id, cohort_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE register_key_structure ADD CONSTRAINT FK_4D663505BEA42DD9 FOREIGN KEY (register_key_id) REFERENCES register_key (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE register_key_structure ADD CONSTRAINT FK_4D6635052534008B FOREIGN KEY (structure_id) REFERENCES structure (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE register_key_cohort ADD CONSTRAINT FK_8D0CF40DBEA42DD9 FOREIGN KEY (register_key_id) REFERENCES register_key (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE register_key_cohort ADD CONSTRAINT FK_8D0CF40D35983C93 FOREIGN KEY (cohort_id) REFERENCES cohort (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE register_key_structure DROP FOREIGN KEY FK_4D663505BEA42DD9');
        $this->addSql('ALTER TABLE register_key_structure DROP FOREIGN KEY FK_4D6635052534008B');
        $this->addSql('ALTER TABLE register_key_cohort DROP FOREIGN KEY FK_8D0CF40DBEA42DD9');
        $this->addSql('ALTER TABLE register_key_cohort DROP FOREIGN KEY FK_8D0CF40D35983C93');
        $this->addSql('DROP TABLE register_key');
        $this->addSql('DROP TABLE register_key_structure');
        $this->addSql('DROP TABLE register_key_cohort');
    }
}
