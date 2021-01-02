<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210101085550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_translation ADD language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_translation ADD CONSTRAINT FK_1846DB7082F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_1846DB7082F1BAF4 ON product_translation (language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_translation DROP FOREIGN KEY FK_1846DB7082F1BAF4');
        $this->addSql('DROP INDEX IDX_1846DB7082F1BAF4 ON product_translation');
        $this->addSql('ALTER TABLE product_translation DROP language_id');
    }
}
