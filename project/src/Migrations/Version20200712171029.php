<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712171029 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, totale DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, publisher VARCHAR(50) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, likes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, date_pub DATE NOT NULL, num_facture INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre (id INT AUTO_INCREMENT NOT NULL, language_id INT DEFAULT NULL, nom_livre VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, type VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, date_pub DATETIME NOT NULL, auteur VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_AC634F9982F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre_categorie (livre_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_E61B069E37D925CB (livre_id), INDEX IDX_E61B069EBCF5E72D (categorie_id), PRIMARY KEY(livre_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livre_user (livre_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_87F42DC437D925CB (livre_id), INDEX IDX_87F42DC4A76ED395 (user_id), PRIMARY KEY(livre_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payement (id INT AUTO_INCREMENT NOT NULL, for_user_id INT NOT NULL, num_payement VARCHAR(255) NOT NULL, date_payement VARCHAR(50) NOT NULL, time_payement VARCHAR(50) NOT NULL, books LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', type_payement VARCHAR(50) NOT NULL, INDEX IDX_B20A78859B5BB4B8 (for_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number INT NOT NULL, user_name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, activation_token VARCHAR(50) DEFAULT NULL, reset_token VARCHAR(50) DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE livre_categorie ADD CONSTRAINT FK_E61B069E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_categorie ADD CONSTRAINT FK_E61B069EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_user ADD CONSTRAINT FK_87F42DC4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A78859B5BB4B8 FOREIGN KEY (for_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livre_categorie DROP FOREIGN KEY FK_E61B069EBCF5E72D');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9982F1BAF4');
        $this->addSql('ALTER TABLE livre_categorie DROP FOREIGN KEY FK_E61B069E37D925CB');
        $this->addSql('ALTER TABLE livre_user DROP FOREIGN KEY FK_87F42DC437D925CB');
        $this->addSql('ALTER TABLE livre_user DROP FOREIGN KEY FK_87F42DC4A76ED395');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A78859B5BB4B8');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE livre_categorie');
        $this->addSql('DROP TABLE livre_user');
        $this->addSql('DROP TABLE payement');
        $this->addSql('DROP TABLE user');
    }
}
