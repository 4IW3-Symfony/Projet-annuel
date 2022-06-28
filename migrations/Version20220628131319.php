<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220628131319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE reset_password_request_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ad (id INT NOT NULL, motorcycle_id INT DEFAULT NULL, status VARCHAR(255) NOT NULL, description TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_77E0ED58CCE1540F ON ad (motorcycle_id)');
        $this->addSql('ALTER TABLE ad ADD CONSTRAINT FK_77E0ED58CCE1540F FOREIGN KEY (motorcycle_id) REFERENCES motorcycle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE brand DROP created_at');
        $this->addSql('ALTER TABLE brand DROP updated_at');
        $this->addSql('DROP INDEX uniq_21e380e1989d9b62');
        $this->addSql('ALTER TABLE motorcycle ADD localisation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE motorcycle ADD ville VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE motorcycle DROP slug');
        $this->addSql('ALTER TABLE motorcycle DROP created_at');
        $this->addSql('ALTER TABLE motorcycle DROP updated_at');
        $this->addSql('ALTER TABLE motorcycle RENAME COLUMN status TO cp');
        $this->addSql('ALTER TABLE motorcycle_image DROP CONSTRAINT fk_debe5277cce1540f');
        $this->addSql('DROP INDEX idx_debe5277cce1540f');
        $this->addSql('ALTER TABLE motorcycle_image ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE motorcycle_image DROP image_name');
        $this->addSql('ALTER TABLE motorcycle_image DROP created_at');
        $this->addSql('ALTER TABLE motorcycle_image DROP updated_at');
        $this->addSql('ALTER TABLE motorcycle_image RENAME COLUMN motorcycle_id TO ad_id');
        $this->addSql('ALTER TABLE motorcycle_image ADD CONSTRAINT FK_DEBE52774F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_DEBE52774F34D596 ON motorcycle_image (ad_id)');
        $this->addSql('ALTER TABLE rental DROP CONSTRAINT fk_1619c27dcce1540f');
        $this->addSql('ALTER TABLE rental DROP CONSTRAINT FK_1619C27DA76ED395');
        $this->addSql('DROP INDEX idx_1619c27dcce1540f');
        $this->addSql('ALTER TABLE rental ADD ad_id INT NOT NULL');
        $this->addSql('ALTER TABLE rental ADD date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE rental DROP motorcycle_id');
        $this->addSql('ALTER TABLE rental DROP created_at');
        $this->addSql('ALTER TABLE rental DROP updated_at');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27D4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT FK_1619C27DA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1619C27D4F34D596 ON rental (ad_id)');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT FK_794381C69395C3F3');
        $this->addSql('ALTER TABLE review DROP created_at');
        $this->addSql('ALTER TABLE review DROP updated_at');
        $this->addSql('ALTER TABLE review ALTER customer_id SET NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C69395C3F3 FOREIGN KEY (customer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP created_at');
        $this->addSql('ALTER TABLE "user" DROP updated_at');
        $this->addSql('ALTER TABLE "user" DROP avatar');
        $this->addSql('ALTER TABLE "user" ALTER firstname SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER lastname SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER date_of_birth SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER address SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER city SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER zip SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE motorcycle_image DROP CONSTRAINT FK_DEBE52774F34D596');
        $this->addSql('ALTER TABLE rental DROP CONSTRAINT FK_1619C27D4F34D596');
        $this->addSql('DROP SEQUENCE ad_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE reset_password_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reset_password_request (id INT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7ce748aa76ed395 ON reset_password_request (user_id)');
        $this->addSql('COMMENT ON COLUMN reset_password_request.requested_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reset_password_request.expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT fk_7ce748aa76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE ad');
        $this->addSql('DROP INDEX IDX_DEBE52774F34D596');
        $this->addSql('ALTER TABLE motorcycle_image ADD image_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE motorcycle_image ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE motorcycle_image ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE motorcycle_image DROP image');
        $this->addSql('ALTER TABLE motorcycle_image RENAME COLUMN ad_id TO motorcycle_id');
        $this->addSql('ALTER TABLE motorcycle_image ADD CONSTRAINT fk_debe5277cce1540f FOREIGN KEY (motorcycle_id) REFERENCES motorcycle (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_debe5277cce1540f ON motorcycle_image (motorcycle_id)');
        $this->addSql('ALTER TABLE motorcycle ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE motorcycle ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE motorcycle ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE motorcycle DROP localisation');
        $this->addSql('ALTER TABLE motorcycle DROP ville');
        $this->addSql('ALTER TABLE motorcycle RENAME COLUMN cp TO status');
        $this->addSql('CREATE UNIQUE INDEX uniq_21e380e1989d9b62 ON motorcycle (slug)');
        $this->addSql('ALTER TABLE rental DROP CONSTRAINT fk_1619c27da76ed395');
        $this->addSql('DROP INDEX IDX_1619C27D4F34D596');
        $this->addSql('ALTER TABLE rental ADD motorcycle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rental ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE rental DROP ad_id');
        $this->addSql('ALTER TABLE rental RENAME COLUMN date TO created_at');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT fk_1619c27dcce1540f FOREIGN KEY (motorcycle_id) REFERENCES motorcycle (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rental ADD CONSTRAINT fk_1619c27da76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1619c27dcce1540f ON rental (motorcycle_id)');
        $this->addSql('ALTER TABLE review DROP CONSTRAINT fk_794381c69395c3f3');
        $this->addSql('ALTER TABLE review ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE review ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE review ALTER customer_id DROP NOT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT fk_794381c69395c3f3 FOREIGN KEY (customer_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE brand ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE brand ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ALTER firstname DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER lastname DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER date_of_birth DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER address DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER city DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER zip DROP NOT NULL');
    }
}
