<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241222120336 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE avis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE cinemas_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE films_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE incidents_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE salles_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE seance_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sieges_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE avis (id INT NOT NULL, film_id INT DEFAULT NULL, user_id INT DEFAULT NULL, commentaire TEXT DEFAULT NULL, note INT NOT NULL, approuve BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8F91ABF0567F5183 ON avis (film_id)');
        $this->addSql('CREATE INDEX IDX_8F91ABF0A76ED395 ON avis (user_id)');
        $this->addSql('CREATE TABLE cinemas (id INT NOT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, adresse TEXT NOT NULL, horaire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cinemas_films (cinemas_id INT NOT NULL, films_id INT NOT NULL, PRIMARY KEY(cinemas_id, films_id))');
        $this->addSql('CREATE INDEX IDX_A5215F8FC5C76018 ON cinemas_films (cinemas_id)');
        $this->addSql('CREATE INDEX IDX_A5215F8F939610EE ON cinemas_films (films_id)');
        $this->addSql('CREATE TABLE films (id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT NOT NULL, age_minimum INT NOT NULL, coup_de_coeur BOOLEAN NOT NULL, note DOUBLE PRECISION NOT NULL, qualite VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_size INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE incidents (id INT NOT NULL, salle_id INT DEFAULT NULL, employes_id INT DEFAULT NULL, description TEXT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E65135D0DC304035 ON incidents (salle_id)');
        $this->addSql('CREATE INDEX IDX_E65135D0F971F91F ON incidents (employes_id)');
        $this->addSql('CREATE TABLE reservations (id INT NOT NULL, cinemas_id INT DEFAULT NULL, seances_id INT DEFAULT NULL, films_id INT DEFAULT NULL, user_id INT DEFAULT NULL, nombre_places INT NOT NULL, prix_total DOUBLE PRECISION NOT NULL, status VARCHAR(255) DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4DA239C5C76018 ON reservations (cinemas_id)');
        $this->addSql('CREATE INDEX IDX_4DA23910F09302 ON reservations (seances_id)');
        $this->addSql('CREATE INDEX IDX_4DA239939610EE ON reservations (films_id)');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
        $this->addSql('CREATE TABLE salles (id INT NOT NULL, numero_salle INT NOT NULL, nombre_siege INT NOT NULL, nombre_siege_pmr INT NOT NULL, type_qualite VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE seance (id INT NOT NULL, films_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, cinemas_id INT DEFAULT NULL, heure_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, heure_fin TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, qualite VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DF7DFD0E939610EE ON seance (films_id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EDC304035 ON seance (salle_id)');
        $this->addSql('CREATE INDEX IDX_DF7DFD0EC5C76018 ON seance (cinemas_id)');
        $this->addSql('COMMENT ON COLUMN seance.heure_debut IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE sieges (id INT NOT NULL, reservation_id INT DEFAULT NULL, numero_siege INT NOT NULL, siege_pmr BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_38B0AE00B83297E7 ON sieges (reservation_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0567F5183 FOREIGN KEY (film_id) REFERENCES films (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cinemas_films ADD CONSTRAINT FK_A5215F8FC5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cinemas_films ADD CONSTRAINT FK_A5215F8F939610EE FOREIGN KEY (films_id) REFERENCES films (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D0DC304035 FOREIGN KEY (salle_id) REFERENCES salles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE incidents ADD CONSTRAINT FK_E65135D0F971F91F FOREIGN KEY (employes_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239C5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23910F09302 FOREIGN KEY (seances_id) REFERENCES seance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239939610EE FOREIGN KEY (films_id) REFERENCES films (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E939610EE FOREIGN KEY (films_id) REFERENCES films (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EDC304035 FOREIGN KEY (salle_id) REFERENCES salles (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0EC5C76018 FOREIGN KEY (cinemas_id) REFERENCES cinemas (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sieges ADD CONSTRAINT FK_38B0AE00B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE avis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE cinemas_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE films_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE incidents_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE salles_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE seance_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sieges_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF0567F5183');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF0A76ED395');
        $this->addSql('ALTER TABLE cinemas_films DROP CONSTRAINT FK_A5215F8FC5C76018');
        $this->addSql('ALTER TABLE cinemas_films DROP CONSTRAINT FK_A5215F8F939610EE');
        $this->addSql('ALTER TABLE incidents DROP CONSTRAINT FK_E65135D0DC304035');
        $this->addSql('ALTER TABLE incidents DROP CONSTRAINT FK_E65135D0F971F91F');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA239C5C76018');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA23910F09302');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA239939610EE');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0E939610EE');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EDC304035');
        $this->addSql('ALTER TABLE seance DROP CONSTRAINT FK_DF7DFD0EC5C76018');
        $this->addSql('ALTER TABLE sieges DROP CONSTRAINT FK_38B0AE00B83297E7');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE cinemas');
        $this->addSql('DROP TABLE cinemas_films');
        $this->addSql('DROP TABLE films');
        $this->addSql('DROP TABLE incidents');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE salles');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE sieges');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
