<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190220134022 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_code DROP FOREIGN KEY FK_D947C51A76ED395');
        $this->addSql('ALTER TABLE user_code DROP FOREIGN KEY FK_D947C51C8B2BD81');
        $this->addSql('ALTER TABLE user_code CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_code ADD CONSTRAINT FK_D947C51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_code ADD CONSTRAINT FK_D947C51C8B2BD81 FOREIGN KEY (coupon_code_id) REFERENCES coupon_code (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_code DROP FOREIGN KEY FK_D947C51A76ED395');
        $this->addSql('ALTER TABLE user_code DROP FOREIGN KEY FK_D947C51C8B2BD81');
        $this->addSql('ALTER TABLE user_code CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_code ADD CONSTRAINT FK_D947C51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_code ADD CONSTRAINT FK_D947C51C8B2BD81 FOREIGN KEY (coupon_code_id) REFERENCES coupon_code (id) ON DELETE SET NULL');
    }
}
