<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210509020854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_fin_etude ADD salle_id INT DEFAULT NULL, ADD reporter_id INT DEFAULT NULL, ADD president_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projet_fin_etude ADD CONSTRAINT FK_D8876367DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE projet_fin_etude ADD CONSTRAINT FK_D8876367E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE projet_fin_etude ADD CONSTRAINT FK_D8876367B40A33C7 FOREIGN KEY (president_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8876367DC304035 ON projet_fin_etude (salle_id)');
        $this->addSql('CREATE INDEX IDX_D8876367E1CFE6F5 ON projet_fin_etude (reporter_id)');
        $this->addSql('CREATE INDEX IDX_D8876367B40A33C7 ON projet_fin_etude (president_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet_fin_etude DROP FOREIGN KEY FK_D8876367DC304035');
        $this->addSql('ALTER TABLE projet_fin_etude DROP FOREIGN KEY FK_D8876367E1CFE6F5');
        $this->addSql('ALTER TABLE projet_fin_etude DROP FOREIGN KEY FK_D8876367B40A33C7');
        $this->addSql('DROP INDEX UNIQ_D8876367DC304035 ON projet_fin_etude');
        $this->addSql('DROP INDEX IDX_D8876367E1CFE6F5 ON projet_fin_etude');
        $this->addSql('DROP INDEX IDX_D8876367B40A33C7 ON projet_fin_etude');
        $this->addSql('ALTER TABLE projet_fin_etude DROP salle_id, DROP reporter_id, DROP president_id');
    }
}
