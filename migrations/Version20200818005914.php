<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818005914 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE body (id INT AUTO_INCREMENT NOT NULL, inventory_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_DBA80BB29EEA759 (inventory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bodypart (id INT AUTO_INCREMENT NOT NULL, body_id INT NOT NULL, health INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_85FE248B9B621D84 (body_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, volume INT NOT NULL, items LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_items (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medkit (id INT AUTO_INCREMENT NOT NULL, healing_capacity INT NOT NULL, volume INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE megaman (id INT AUTO_INCREMENT NOT NULL, body_id INT NOT NULL, birth_date DATE NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_115F19439B621D84 (body_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE body ADD CONSTRAINT FK_DBA80BB29EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE bodypart ADD CONSTRAINT FK_85FE248B9B621D84 FOREIGN KEY (body_id) REFERENCES body (id)');
        $this->addSql('ALTER TABLE megaman ADD CONSTRAINT FK_115F19439B621D84 FOREIGN KEY (body_id) REFERENCES body (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bodypart DROP FOREIGN KEY FK_85FE248B9B621D84');
        $this->addSql('ALTER TABLE megaman DROP FOREIGN KEY FK_115F19439B621D84');
        $this->addSql('ALTER TABLE body DROP FOREIGN KEY FK_DBA80BB29EEA759');
        $this->addSql('DROP TABLE body');
        $this->addSql('DROP TABLE bodypart');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE inventory_items');
        $this->addSql('DROP TABLE medkit');
        $this->addSql('DROP TABLE megaman');
    }
}
