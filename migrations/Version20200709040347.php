<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200709040347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qtheme ADD theme_id INT NOT NULL');
        $this->addSql('ALTER TABLE qtheme ADD CONSTRAINT FK_20EB6FD259027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('CREATE INDEX IDX_20EB6FD259027487 ON qtheme (theme_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qtheme DROP FOREIGN KEY FK_20EB6FD259027487');
        $this->addSql('DROP INDEX IDX_20EB6FD259027487 ON qtheme');
        $this->addSql('ALTER TABLE qtheme DROP theme_id');
    }
}
