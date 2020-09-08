<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200908110420 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B07A45358C');
        $this->addSql('CREATE TABLE option_group (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE option_groupe');
        $this->addSql('DROP INDEX IDX_5A8600B07A45358C ON `option`');
        $this->addSql('ALTER TABLE `option` CHANGE groupe_id group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B0FE54D947 FOREIGN KEY (group_id) REFERENCES option_group (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B0FE54D947 ON `option` (group_id)');
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114A7C41D6F');
        $this->addSql('ALTER TABLE product_option ADD option_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114DE23A8E3 FOREIGN KEY (option_group_id) REFERENCES option_group (id)');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114A7C41D6F FOREIGN KEY (option_id) REFERENCES `option` (id)');
        $this->addSql('CREATE INDEX IDX_38FA4114DE23A8E3 ON product_option (option_group_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `option` DROP FOREIGN KEY FK_5A8600B0FE54D947');
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114DE23A8E3');
        $this->addSql('CREATE TABLE option_groupe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE option_group');
        $this->addSql('DROP INDEX IDX_5A8600B0FE54D947 ON `option`');
        $this->addSql('ALTER TABLE `option` CHANGE group_id groupe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `option` ADD CONSTRAINT FK_5A8600B07A45358C FOREIGN KEY (groupe_id) REFERENCES option_groupe (id)');
        $this->addSql('CREATE INDEX IDX_5A8600B07A45358C ON `option` (groupe_id)');
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114A7C41D6F');
        $this->addSql('DROP INDEX IDX_38FA4114DE23A8E3 ON product_option');
        $this->addSql('ALTER TABLE product_option DROP option_group_id');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114A7C41D6F FOREIGN KEY (option_id) REFERENCES product (id)');
    }
}
