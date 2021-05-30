<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210530003322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postule ADD binome_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postule ADD CONSTRAINT FK_742304C98D4924C4 FOREIGN KEY (binome_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_742304C98D4924C4 ON postule (binome_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postule DROP FOREIGN KEY FK_742304C98D4924C4');
        $this->addSql('DROP INDEX UNIQ_742304C98D4924C4 ON postule');
        $this->addSql('ALTER TABLE postule DROP binome_id');
    }
}
