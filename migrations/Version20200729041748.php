<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729041748 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qmodule ADD module_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE qmodule ADD CONSTRAINT FK_6A95836A7648EE39 FOREIGN KEY (module_id_id) REFERENCES module (id)');
        $this->addSql('CREATE INDEX IDX_6A95836A7648EE39 ON qmodule (module_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qmodule DROP FOREIGN KEY FK_6A95836A7648EE39');
        $this->addSql('DROP INDEX IDX_6A95836A7648EE39 ON qmodule');
        $this->addSql('ALTER TABLE qmodule DROP module_id_id');
    }
}
