<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506165201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postule (id INT AUTO_INCREMENT NOT NULL, pfe_id INT NOT NULL, student_id INT NOT NULL, postuled_at DATETIME NOT NULL, is_accepted TINYINT(1) NOT NULL, INDEX IDX_742304C9396A359C (pfe_id), INDEX IDX_742304C9CB944F1A (student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE postule ADD CONSTRAINT FK_742304C9396A359C FOREIGN KEY (pfe_id) REFERENCES projet_fin_etude (id)');
        $this->addSql('ALTER TABLE postule ADD CONSTRAINT FK_742304C9CB944F1A FOREIGN KEY (student_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE postule');
    }
}
