<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314204725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE condition_comic (id INT AUTO_INCREMENT NOT NULL, condition_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_comic_comics (condition_comic_id INT NOT NULL, comics_id INT NOT NULL, INDEX IDX_84B46208F125DB53 (condition_comic_id), INDEX IDX_84B4620871AE76A2 (comics_id), PRIMARY KEY(condition_comic_id, comics_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE condition_comic_comics ADD CONSTRAINT FK_84B46208F125DB53 FOREIGN KEY (condition_comic_id) REFERENCES condition_comic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE condition_comic_comics ADD CONSTRAINT FK_84B4620871AE76A2 FOREIGN KEY (comics_id) REFERENCES comics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE status CHANGE comic_id comic_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE condition_comic_comics DROP FOREIGN KEY FK_84B46208F125DB53');
        $this->addSql('DROP TABLE condition_comic');
        $this->addSql('DROP TABLE condition_comic_comics');
        $this->addSql('ALTER TABLE status CHANGE comic_id comic_id INT NOT NULL');
    }
}
