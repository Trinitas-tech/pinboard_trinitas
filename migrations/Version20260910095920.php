<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260910095920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Use InnoDB tables and add the pin owner foreign key.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE users ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pins ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pins ADD CONSTRAINT FK_3F0FE980A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pins DROP FOREIGN KEY FK_3F0FE980A76ED395');
    }
}
