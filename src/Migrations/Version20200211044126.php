<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200211044126 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot ADD depot_id INT DEFAULT NULL, ADD depotcompte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC8510D4DE FOREIGN KEY (depot_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC5B1EA4DE FOREIGN KEY (depotcompte_id) REFERENCES compte (id)');
        $this->addSql('CREATE INDEX IDX_47948BBC8510D4DE ON depot (depot_id)');
        $this->addSql('CREATE INDEX IDX_47948BBC5B1EA4DE ON depot (depotcompte_id)');
        $this->addSql('ALTER TABLE partenaire ADD partenairecontrat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373C1C33430 FOREIGN KEY (partenairecontrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_32FFA373C1C33430 ON partenaire (partenairecontrat_id)');
        $this->addSql('ALTER TABLE compte ADD partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF6526098DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_CFF6526098DE13AC ON compte (partenaire_id)');
        $this->addSql('ALTER TABLE user ADD partenaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64998DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64998DE13AC ON user (partenaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF6526098DE13AC');
        $this->addSql('DROP INDEX IDX_CFF6526098DE13AC ON compte');
        $this->addSql('ALTER TABLE compte DROP partenaire_id');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC8510D4DE');
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC5B1EA4DE');
        $this->addSql('DROP INDEX IDX_47948BBC8510D4DE ON depot');
        $this->addSql('DROP INDEX IDX_47948BBC5B1EA4DE ON depot');
        $this->addSql('ALTER TABLE depot DROP depot_id, DROP depotcompte_id');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373C1C33430');
        $this->addSql('DROP INDEX UNIQ_32FFA373C1C33430 ON partenaire');
        $this->addSql('ALTER TABLE partenaire DROP partenairecontrat_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64998DE13AC');
        $this->addSql('DROP INDEX IDX_8D93D64998DE13AC ON user');
        $this->addSql('ALTER TABLE user DROP partenaire_id');
    }
}
