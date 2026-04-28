<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260428135731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE presence (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(20) NOT NULL, date DATETIME NOT NULL, player_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_6977C7A599E6F5DF (player_id), INDEX IDX_6977C7A571F7E88B (event_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A599E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE presence ADD CONSTRAINT FK_6977C7A571F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A599E6F5DF');
        $this->addSql('ALTER TABLE presence DROP FOREIGN KEY FK_6977C7A571F7E88B');
        $this->addSql('DROP TABLE presence');
    }
}
