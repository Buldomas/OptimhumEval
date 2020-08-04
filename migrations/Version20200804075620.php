<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200804075620 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, titre VARCHAR(255) NOT NULL, stitre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_404021BF59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_module (formation_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_2C3D28055200282E (formation_id), INDEX IDX_2C3D2805AFC2B591 (module_id), PRIMARY KEY(formation_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) NOT NULL, niveau INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, stitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qformation (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX IDX_5C48B3C15200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qmodule (id INT AUTO_INCREMENT NOT NULL, module_id_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, note INT DEFAULT 5 NOT NULL, INDEX IDX_6A95836A7648EE39 (module_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE qtheme (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, note INT NOT NULL, INDEX IDX_20EB6FD259027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questionnaire (id INT AUTO_INCREMENT NOT NULL, formation_id INT NOT NULL, createur_id INT NOT NULL, intitule VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, rating INT NOT NULL, INDEX IDX_7A64DAF5200282E (formation_id), INDEX IDX_7A64DAF73A201E5 (createur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, questionnaire_id INT DEFAULT NULL, createur_id INT DEFAULT NULL, theme_id INT DEFAULT NULL, formation_id INT DEFAULT NULL, module_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, rating INT NOT NULL, INDEX IDX_8ADC54D5CE07E8FF (questionnaire_id), INDEX IDX_8ADC54D573A201E5 (createur_id), INDEX IDX_8ADC54D559027487 (theme_id), INDEX IDX_8ADC54D55200282E (formation_id), INDEX IDX_8ADC54D5AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, stitre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, niv_id INT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, hash VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, date_creation DATE NOT NULL, telephone VARCHAR(255) DEFAULT NULL, mobile VARCHAR(255) DEFAULT NULL, adresse2 VARCHAR(255) DEFAULT NULL, postal INT DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, email2 VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649C04A39D7 (niv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE formation_module ADD CONSTRAINT FK_2C3D28055200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_module ADD CONSTRAINT FK_2C3D2805AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE qformation ADD CONSTRAINT FK_5C48B3C15200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE qmodule ADD CONSTRAINT FK_6A95836A7648EE39 FOREIGN KEY (module_id_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE qtheme ADD CONSTRAINT FK_20EB6FD259027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF5200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE questionnaire ADD CONSTRAINT FK_7A64DAF73A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5CE07E8FF FOREIGN KEY (questionnaire_id) REFERENCES questionnaire (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D573A201E5 FOREIGN KEY (createur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D559027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D55200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C04A39D7 FOREIGN KEY (niv_id) REFERENCES level (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_module DROP FOREIGN KEY FK_2C3D28055200282E');
        $this->addSql('ALTER TABLE qformation DROP FOREIGN KEY FK_5C48B3C15200282E');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF5200282E');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D55200282E');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C04A39D7');
        $this->addSql('ALTER TABLE formation_module DROP FOREIGN KEY FK_2C3D2805AFC2B591');
        $this->addSql('ALTER TABLE qmodule DROP FOREIGN KEY FK_6A95836A7648EE39');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5AFC2B591');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5CE07E8FF');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF59027487');
        $this->addSql('ALTER TABLE qtheme DROP FOREIGN KEY FK_20EB6FD259027487');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D559027487');
        $this->addSql('ALTER TABLE questionnaire DROP FOREIGN KEY FK_7A64DAF73A201E5');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D573A201E5');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_module');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE qformation');
        $this->addSql('DROP TABLE qmodule');
        $this->addSql('DROP TABLE qtheme');
        $this->addSql('DROP TABLE questionnaire');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
    }
}
