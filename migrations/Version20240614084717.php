<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614084717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, contact VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, produit_id INT NOT NULL, utilisateur_id INT NOT NULL, date DATETIME NOT NULL, prix_unitaire DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, INDEX IDX_EDBFD5EC19EB6921 (client_id), INDEX IDX_EDBFD5ECF347EFB (produit_id), INDEX IDX_EDBFD5ECFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, nombre INT NOT NULL, codebarre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', image VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5EC19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5EC19EB6921');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECF347EFB');
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECFB88E14F');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
