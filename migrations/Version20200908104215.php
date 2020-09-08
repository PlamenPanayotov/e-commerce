<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908104215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option ADD option_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114A7C41D6F FOREIGN KEY (option_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_38FA4114A7C41D6F ON product_option (option_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114A7C41D6F');
        $this->addSql('DROP INDEX IDX_38FA4114A7C41D6F ON product_option');
        $this->addSql('ALTER TABLE product_option DROP option_id');
    }
}
