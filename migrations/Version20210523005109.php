<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210523005109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE department ADD chef_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A150A48F1 FOREIGN KEY (chef_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CD1DE18A150A48F1 ON department (chef_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A150A48F1');
        $this->addSql('DROP INDEX UNIQ_CD1DE18A150A48F1 ON department');
        $this->addSql('ALTER TABLE department DROP chef_id');
    }
}
