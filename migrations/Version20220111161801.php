<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220111161801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE models_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rentals_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE model_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rental_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE model (id INT NOT NULL, brand_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('CREATE TABLE rental (id INT NOT NULL, users_id INT DEFAULT NULL, review_id INT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_start INT DEFAULT NULL, date_end INT DEFAULT NULL, status INT NOT NULL, km_start INT NOT NULL, km_end INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1619C27D67B3B43D ON rental (users_id)');
        $this->addSql('CREATE INDEX IDX_1619C27D3E2E969B ON rental (review_id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D67B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D3E2E969B FOREIGN KEY (review_id) REFERENCES review (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE models');
        $this->addSql('DROP TABLE rentals');
        $this->addSql('ALTER TABLE ads ADD motorcycle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ads ADD CONSTRAINT FK_7EC9F620CCE1540F FOREIGN KEY (motorcycle_id) REFERENCES motoclycle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7EC9F620CCE1540F ON ads (motorcycle_id)');
        $this->addSql('ALTER TABLE motoclycle ADD licence_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motoclycle ADD users_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motoclycle ADD model_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motoclycle ADD CONSTRAINT FK_6B39C60EBFB4620 FOREIGN KEY (licence_type_id) REFERENCES licence_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motoclycle ADD CONSTRAINT FK_6B39C60E67B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE motoclycle ADD CONSTRAINT FK_6B39C60E7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6B39C60EBFB4620 ON motoclycle (licence_type_id)');
        $this->addSql('CREATE INDEX IDX_6B39C60E67B3B43D ON motoclycle (users_id)');
        $this->addSql('CREATE INDEX IDX_6B39C60E7975B7E7 ON motoclycle (model_id)');
        $this->addSql('ALTER TABLE motorcycle_image ADD ads_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE motorcycle_image ADD CONSTRAINT FK_DEBE5277FE52BF81 FOREIGN KEY (ads_id) REFERENCES ads (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DEBE5277FE52BF81 ON motorcycle_image (ads_id)');
        $this->addSql('ALTER TABLE "user" ADD licence_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649BFB4620 FOREIGN KEY (licence_type_id) REFERENCES licence_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649BFB4620 ON "user" (licence_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE motoclycle DROP CONSTRAINT FK_6B39C60E7975B7E7');
        $this->addSql('DROP SEQUENCE model_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rental_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE models_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rentals_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE models (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rentals (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, status INT NOT NULL, km_start INT DEFAULT NULL, km_end INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE rental');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649BFB4620');
        $this->addSql('DROP INDEX IDX_8D93D649BFB4620');
        $this->addSql('ALTER TABLE "user" DROP licence_type_id');
        $this->addSql('ALTER TABLE ads DROP CONSTRAINT FK_7EC9F620CCE1540F');
        $this->addSql('DROP INDEX IDX_7EC9F620CCE1540F');
        $this->addSql('ALTER TABLE ads DROP motorcycle_id');
        $this->addSql('ALTER TABLE motoclycle DROP CONSTRAINT FK_6B39C60EBFB4620');
        $this->addSql('ALTER TABLE motoclycle DROP CONSTRAINT FK_6B39C60E67B3B43D');
        $this->addSql('DROP INDEX IDX_6B39C60EBFB4620');
        $this->addSql('DROP INDEX IDX_6B39C60E67B3B43D');
        $this->addSql('DROP INDEX IDX_6B39C60E7975B7E7');
        $this->addSql('ALTER TABLE motoclycle DROP licence_type_id');
        $this->addSql('ALTER TABLE motoclycle DROP users_id');
        $this->addSql('ALTER TABLE motoclycle DROP model_id');
        $this->addSql('ALTER TABLE motorcycle_image DROP CONSTRAINT FK_DEBE5277FE52BF81');
        $this->addSql('DROP INDEX IDX_DEBE5277FE52BF81');
        $this->addSql('ALTER TABLE motorcycle_image DROP ads_id');
    }
}
