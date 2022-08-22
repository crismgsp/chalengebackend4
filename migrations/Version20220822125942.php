<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220822125942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE despesas CHANGE descricao descricao VARCHAR(255) NOT NULL, CHANGE categoria categoria VARCHAR(255) NOT NULL, CHANGE mesano mesano VARCHAR(255) NOT NULL, CHANGE data data VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE receitas CHANGE descricao descricao VARCHAR(255) NOT NULL, CHANGE mesano mesano VARCHAR(255) NOT NULL, CHANGE data data VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE despesas CHANGE descricao descricao VARCHAR(150) NOT NULL, CHANGE data data VARCHAR(10) NOT NULL, CHANGE categoria categoria VARCHAR(15) NOT NULL, CHANGE mesano mesano VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE receitas CHANGE descricao descricao VARCHAR(150) NOT NULL, CHANGE data data VARCHAR(10) NOT NULL, CHANGE mesano mesano VARCHAR(10) NOT NULL');
    }
}
