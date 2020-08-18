<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200817233255 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE body DROP items');
        $this->addSql('ALTER TABLE bodypart ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE inventory ADD items LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE megaman CHANGE health body_id INT NOT NULL');
        $this->addSql('ALTER TABLE megaman ADD CONSTRAINT FK_115F19439B621D84 FOREIGN KEY (body_id) REFERENCES body (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_115F19439B621D84 ON megaman (body_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE body ADD items LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE bodypart DROP name');
        $this->addSql('ALTER TABLE inventory DROP items');
        $this->addSql('ALTER TABLE megaman DROP FOREIGN KEY FK_115F19439B621D84');
        $this->addSql('DROP INDEX UNIQ_115F19439B621D84 ON megaman');
        $this->addSql('ALTER TABLE megaman CHANGE body_id health INT NOT NULL');
    }
}
