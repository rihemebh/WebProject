<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623214822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, publisher VARCHAR(50) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, likes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('ALTER TABLE livre CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE language_id language_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9982F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('CREATE INDEX IDX_AC634F9982F1BAF4 ON livre (language_id)');
        $this->addSql('ALTER TABLE user CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE activation_token activation_token VARCHAR(50) DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, book_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_AC6340B316A2B381 (book_id), INDEX IDX_AC6340B3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B316A2B381 FOREIGN KEY (book_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F9982F1BAF4');
        $this->addSql('DROP INDEX IDX_AC634F9982F1BAF4 ON livre');
        $this->addSql('ALTER TABLE livre CHANGE language_id language_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE activation_token activation_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE reset_token reset_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
