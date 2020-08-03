<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729082855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE qformation (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX IDX_5C48B3C15200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE qformation ADD CONSTRAINT FK_5C48B3C15200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE qmodule CHANGE note note INT NOT NULL');
        $this->addSql('ALTER TABLE qtheme CHANGE note note INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE qformation');
        $this->addSql('ALTER TABLE qmodule CHANGE note note INT DEFAULT 5 NOT NULL');
        $this->addSql('ALTER TABLE qtheme CHANGE note note INT DEFAULT 5');
    }
}
