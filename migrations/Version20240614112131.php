<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240614112131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier_produit DROP FOREIGN KEY FK_D31F28A6F77D927C');
        $this->addSql('ALTER TABLE panier_produit DROP FOREIGN KEY FK_D31F28A6F347EFB');
        $this->addSql('DROP TABLE panier_produit');
        $this->addSql('ALTER TABLE panier ADD produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF2F347EFB ON panier (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier_produit (panier_id INT NOT NULL, produit_id INT NOT NULL, INDEX IDX_D31F28A6F347EFB (produit_id), INDEX IDX_D31F28A6F77D927C (panier_id), PRIMARY KEY(panier_id, produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE panier_produit ADD CONSTRAINT FK_D31F28A6F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier_produit ADD CONSTRAINT FK_D31F28A6F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2F347EFB');
        $this->addSql('DROP INDEX IDX_24CC0DF2F347EFB ON panier');
        $this->addSql('ALTER TABLE panier DROP produit_id');
    }
}
