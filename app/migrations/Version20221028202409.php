<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028202409 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Changes the users.id column to a uuid generated column';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4A76ED395');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF471F7E88B');
        $this->addSql('ALTER TABLE tickets CHANGE user_id user_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', CHANGE checked_in_quantity checked_in_quantity INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE users CHANGE id id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF471F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4A76ED395');
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF471F7E88B');
        $this->addSql('ALTER TABLE tickets CHANGE user_id user_id INT DEFAULT NULL, CHANGE checked_in_quantity checked_in_quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF471F7E88B FOREIGN KEY (event_id) REFERENCES events (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
