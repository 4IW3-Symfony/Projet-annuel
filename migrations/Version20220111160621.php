<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111160621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_contact (user_id INT NOT NULL, contact_id INT NOT NULL, PRIMARY KEY(user_id, contact_id))');
        $this->addSql('CREATE INDEX IDX_146FF832A76ED395 ON user_contact (user_id)');
        $this->addSql('CREATE INDEX IDX_146FF832E7A1254A ON user_contact (contact_id)');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_contact ADD CONSTRAINT FK_146FF832E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contact_message ADD contact_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FEE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2C9211FEE7A1254A ON contact_message (contact_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE user_contact');
        $this->addSql('ALTER TABLE contact_message DROP CONSTRAINT FK_2C9211FEE7A1254A');
        $this->addSql('DROP INDEX IDX_2C9211FEE7A1254A');
        $this->addSql('ALTER TABLE contact_message DROP contact_id');
    }
}
