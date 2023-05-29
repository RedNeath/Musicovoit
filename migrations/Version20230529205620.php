<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230529205620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE morceau_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE style_id_seq CASCADE');
        $this->addSql('CREATE TABLE ville (id INT NOT NULL, nom VARCHAR(255) NOT NULL, code_postal VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE avis ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8F91ABF0FB88E14F ON avis (utilisateur_id)');
        $this->addSql('ALTER TABLE message ADD utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FD12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B6BD307FFB88E14F ON message (utilisateur_id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CF16F4AC6 FOREIGN KEY (conducteur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CAE02FE4B FOREIGN KEY (depart_id) REFERENCES ville (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CEAF07E42 FOREIGN KEY (arrivee_id) REFERENCES ville (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B34A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_trajet ADD CONSTRAINT FK_4AF69307FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_trajet ADD CONSTRAINT FK_4AF69307D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trajet DROP CONSTRAINT FK_2B5BA98CAE02FE4B');
        $this->addSql('ALTER TABLE trajet DROP CONSTRAINT FK_2B5BA98CEAF07E42');
        $this->addSql('CREATE SEQUENCE morceau_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE style_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B34A4A3511');
        $this->addSql('ALTER TABLE utilisateur DROP roles');
        $this->addSql('ALTER TABLE utilisateur DROP password');
        $this->addSql('ALTER TABLE trajet DROP CONSTRAINT FK_2B5BA98CF16F4AC6');
        $this->addSql('ALTER TABLE trajet DROP CONSTRAINT FK_2B5BA98C4A4A3511');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF0D12A823');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF0FB88E14F');
        $this->addSql('DROP INDEX IDX_8F91ABF0FB88E14F');
        $this->addSql('ALTER TABLE avis DROP utilisateur_id');
        $this->addSql('ALTER TABLE utilisateur_trajet DROP CONSTRAINT FK_4AF69307FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_trajet DROP CONSTRAINT FK_4AF69307D12A823');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FD12A823');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FFB88E14F');
        $this->addSql('DROP INDEX IDX_B6BD307FFB88E14F');
        $this->addSql('ALTER TABLE message DROP utilisateur_id');
    }
}
