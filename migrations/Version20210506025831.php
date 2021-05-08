<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506025831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postule (id INT AUTO_INCREMENT NOT NULL, postuled_at DATETIME NOT NULL, is_accepted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE projet_fin_etude ADD postule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet_fin_etude ADD CONSTRAINT FK_D88763673E34DCFD FOREIGN KEY (postule_id) REFERENCES postule (id)');
        $this->addSql('CREATE INDEX IDX_D88763673E34DCFD ON projet_fin_etude (postule_id)');
        $this->addSql('ALTER TABLE user ADD postule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493E34DCFD FOREIGN KEY (postule_id) REFERENCES postule (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493E34DCFD ON user (postule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_fin_etude DROP FOREIGN KEY FK_D88763673E34DCFD');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493E34DCFD');
        $this->addSql('DROP TABLE postule');
        $this->addSql('DROP INDEX IDX_D88763673E34DCFD ON projet_fin_etude');
        $this->addSql('ALTER TABLE projet_fin_etude DROP postule_id');
        $this->addSql('DROP INDEX IDX_8D93D6493E34DCFD ON user');
        $this->addSql('ALTER TABLE user DROP postule_id');
    }
}
