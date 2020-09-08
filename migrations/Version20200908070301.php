<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908070301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` ADD groupe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B07A45358C FOREIGN KEY (groupe_id) REFERENCES option_groupe (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B07A45358C ON `option` (groupe_id)');
        $this->addSql('ALTER TABLE option_groupe DROP FOREIGN KEY FK_47E98EF6A7C41D6F');
        $this->addSql('DROP INDEX IDX_47E98EF6A7C41D6F ON option_groupe');
        $this->addSql('ALTER TABLE option_groupe DROP option_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B07A45358C');
        $this->addSql('DROP INDEX IDX_5A8600B07A45358C ON `option`');
        $this->addSql('ALTER TABLE `option` DROP groupe_id');
        $this->addSql('ALTER TABLE option_groupe ADD option_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE option_groupe ADD CONSTRAINT FK_47E98EF6A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id)');
        $this->addSql('CREATE INDEX IDX_47E98EF6A7C41D6F ON option_groupe (option_id)');
    }
}
