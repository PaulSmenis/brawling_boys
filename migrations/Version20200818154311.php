<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818154311 extends AbstractMigration
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
        $this->addSql('CREATE TABLE inventory (id INT AUTO_INCREMENT NOT NULL, wielded_id INT DEFAULT NULL, volume INT NOT NULL, UNIQUE INDEX UNIQ_B12D4A363C318021 (wielded_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inventory_items (id INT AUTO_INCREMENT NOT NULL, inventory_id INT DEFAULT NULL, item_type VARCHAR(255) NOT NULL, volume INT NOT NULL, INDEX IDX_3D82424D9EEA759 (inventory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE megaman (id INT AUTO_INCREMENT NOT NULL, body_id INT NOT NULL, birth_date DATE NOT NULL, name VARCHAR(255) NOT NULL, str INT NOT NULL, intellect INT NOT NULL, per INT NOT NULL, cha INT NOT NULL, agi INT NOT NULL, luc INT NOT NULL, end INT NOT NULL, UNIQUE INDEX UNIQ_115F19439B621D84 (body_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE body ADD CONSTRAINT FK_DBA80BB29EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE bodypart ADD CONSTRAINT FK_85FE248B9B621D84 FOREIGN KEY (body_id) REFERENCES body (id)');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A363C318021 FOREIGN KEY (wielded_id) REFERENCES inventory_items (id)');
        $this->addSql('ALTER TABLE inventory_items ADD CONSTRAINT FK_3D82424D9EEA759 FOREIGN KEY (inventory_id) REFERENCES inventory (id)');
        $this->addSql('ALTER TABLE megaman ADD CONSTRAINT FK_115F19439B621D84 FOREIGN KEY (body_id) REFERENCES body (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bodypart DROP FOREIGN KEY FK_85FE248B9B621D84');
        $this->addSql('ALTER TABLE megaman DROP FOREIGN KEY FK_115F19439B621D84');
        $this->addSql('ALTER TABLE body DROP FOREIGN KEY FK_DBA80BB29EEA759');
        $this->addSql('ALTER TABLE inventory_items DROP FOREIGN KEY FK_3D82424D9EEA759');
        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A363C318021');
        $this->addSql('DROP TABLE body');
        $this->addSql('DROP TABLE bodypart');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE inventory_items');
        $this->addSql('DROP TABLE megaman');
    }
}
