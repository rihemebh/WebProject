<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712111905 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE livre CHANGE language_id language_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE activation_token activation_token VARCHAR(50) DEFAULT NULL, CHANGE reset_token reset_token VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE categorie CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment CHANGE avatar avatar VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE livre CHANGE language_id language_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE description description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE address address VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE activation_token activation_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE reset_token reset_token VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
