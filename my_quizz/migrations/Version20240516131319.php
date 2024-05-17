<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516131319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE LastLogin');
        $this->addSql('ALTER TABLE quizz_passed DROP FOREIGN KEY FK_3925375679F37AE5');
        $this->addSql('ALTER TABLE quizz_passed DROP FOREIGN KEY FK_39253756EA48A758');
        $this->addSql('DROP INDEX IDX_3925375679F37AE5 ON quizz_passed');
        $this->addSql('DROP INDEX IDX_39253756EA48A758 ON quizz_passed');
        $this->addSql('ALTER TABLE quizz_passed ADD user_id INT NOT NULL, ADD categorie_name VARCHAR(255) NOT NULL, DROP id_user_id, DROP id_quizz_id');
        $this->addSql('ALTER TABLE quizz_passed ADD CONSTRAINT FK_39253756A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_39253756A76ED395 ON quizz_passed (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE LastLogin (UserID INT NOT NULL, Username VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_0900_ai_ci`, LastLoggedInAt DATETIME DEFAULT NULL, PRIMARY KEY(UserID)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quizz_passed DROP FOREIGN KEY FK_39253756A76ED395');
        $this->addSql('DROP INDEX IDX_39253756A76ED395 ON quizz_passed');
        $this->addSql('ALTER TABLE quizz_passed ADD id_quizz_id INT NOT NULL, DROP categorie_name, CHANGE user_id id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE quizz_passed ADD CONSTRAINT FK_3925375679F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE quizz_passed ADD CONSTRAINT FK_39253756EA48A758 FOREIGN KEY (id_quizz_id) REFERENCES categorie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3925375679F37AE5 ON quizz_passed (id_user_id)');
        $this->addSql('CREATE INDEX IDX_39253756EA48A758 ON quizz_passed (id_quizz_id)');
    }
}
