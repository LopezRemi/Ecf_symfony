<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220201150418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historical (id INT AUTO_INCREMENT NOT NULL, date_loan DATETIME DEFAULT NULL, date_return DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historical_books (historical_id INT NOT NULL, books_id INT NOT NULL, INDEX IDX_EBC4E014C75EAE06 (historical_id), INDEX IDX_EBC4E0147DD8AC20 (books_id), PRIMARY KEY(historical_id, books_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE historical_user (historical_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_83CA2EE8C75EAE06 (historical_id), INDEX IDX_83CA2EE8A76ED395 (user_id), PRIMARY KEY(historical_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historical_books ADD CONSTRAINT FK_EBC4E014C75EAE06 FOREIGN KEY (historical_id) REFERENCES historical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historical_books ADD CONSTRAINT FK_EBC4E0147DD8AC20 FOREIGN KEY (books_id) REFERENCES books (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historical_user ADD CONSTRAINT FK_83CA2EE8C75EAE06 FOREIGN KEY (historical_id) REFERENCES historical (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE historical_user ADD CONSTRAINT FK_83CA2EE8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historical_books DROP FOREIGN KEY FK_EBC4E014C75EAE06');
        $this->addSql('ALTER TABLE historical_user DROP FOREIGN KEY FK_83CA2EE8C75EAE06');
        $this->addSql('DROP TABLE historical');
        $this->addSql('DROP TABLE historical_books');
        $this->addSql('DROP TABLE historical_user');
        $this->addSql('ALTER TABLE books CHANGE title title VARCHAR(100) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE author author VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE summary summary VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE category category VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE book_condition book_condition VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE editor editor VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE first_name first_name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(60) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE loan loan LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
    }
}
