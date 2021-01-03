<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211140115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, style VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, creation_year DATE DEFAULT NULL, last_album_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE concert_hall (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, total_capacity INT DEFAULT NULL, presentation LONGTEXT NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hall (id INT AUTO_INCREMENT NOT NULL, concert_hall_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, capacity INT NOT NULL, available TINYINT(1) NOT NULL, INDEX IDX_1B8FA83FC8B57370 (concert_hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, job VARCHAR(255) NOT NULL, birth_date DATE DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, INDEX IDX_70E4FA7849ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `concert` (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, date DATE NOT NULL, tour_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_320ED90152AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE show_band (show_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_94287428D0C1FC64 (show_id), INDEX IDX_9428742849ABEB17 (band_id), PRIMARY KEY(show_id, band_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83FC8B57370 FOREIGN KEY (concert_hall_id) REFERENCES concert_hall (id)');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7849ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_320ED90152AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE concert_band ADD CONSTRAINT FK_94287428D0C1FC64 FOREIGN KEY (show_id) REFERENCES concert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE concert_band ADD CONSTRAINT FK_9428742849ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7849ABEB17');
        $this->addSql('ALTER TABLE concert_band DROP FOREIGN KEY FK_9428742849ABEB17');
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FC8B57370');
        $this->addSql('ALTER TABLE concert DROP FOREIGN KEY FK_320ED90152AFCFD6');
        $this->addSql('ALTER TABLE concert_band DROP FOREIGN KEY FK_94287428D0C1FC64');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE concert_hall');
        $this->addSql('DROP TABLE hall');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE concert');
        $this->addSql('DROP TABLE concert_band');
    }
}
