<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518201143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE last_login DROP INDEX UNIQ_C843FD0BA76ED395, ADD INDEX IDX_C843FD0BA76ED395 (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE last_login DROP INDEX IDX_C843FD0BA76ED395, ADD UNIQUE INDEX UNIQ_C843FD0BA76ED395 (user_id)');
    }
}
