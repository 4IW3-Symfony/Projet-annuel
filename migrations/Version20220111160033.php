<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111160033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_message ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FE79F37AE5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2C9211FE79F37AE5 ON contact_message (id_user_id)');
        $this->addSql('ALTER TABLE rentals ALTER date_end DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contact_message DROP CONSTRAINT FK_2C9211FE79F37AE5');
        $this->addSql('DROP INDEX IDX_2C9211FE79F37AE5');
        $this->addSql('ALTER TABLE contact_message DROP id_user_id');
        $this->addSql('ALTER TABLE rentals ALTER date_end SET NOT NULL');
    }
}
