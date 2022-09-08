<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220908004714 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE events (id INT NOT NULL, event_name VARCHAR(255) NOT NULL, attendance_count INT NOT NULL, attendance_cap INT DEFAULT NULL, ticket_cost_in_cents INT DEFAULT NULL, started_at DATETIME NOT NULL, ended_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_user (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_92589AE2A76ED395 (user_id), INDEX IDX_92589AE271F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, alias VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, subscribed TINYINT(1) NOT NULL, subscribed_at DATETIME DEFAULT NULL, unsubscribed_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE2A76ED395 FOREIGN KEY (user_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE event_user ADD CONSTRAINT FK_92589AE271F7E88B FOREIGN KEY (event_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE2A76ED395');
        $this->addSql('ALTER TABLE event_user DROP FOREIGN KEY FK_92589AE271F7E88B');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE event_user');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
