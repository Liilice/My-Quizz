<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513210834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quizz_passed (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, id_quizz_id INT NOT NULL, note INT NOT NULL, passed_time DATETIME NOT NULL, INDEX IDX_3925375679F37AE5 (id_user_id), INDEX IDX_39253756EA48A758 (id_quizz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quizz_passed ADD CONSTRAINT FK_3925375679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quizz_passed ADD CONSTRAINT FK_39253756EA48A758 FOREIGN KEY (id_quizz_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quizz_passed DROP FOREIGN KEY FK_3925375679F37AE5');
        $this->addSql('ALTER TABLE quizz_passed DROP FOREIGN KEY FK_39253756EA48A758');
        $this->addSql('DROP TABLE quizz_passed');
    }
}