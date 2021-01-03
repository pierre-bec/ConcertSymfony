<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201211135433 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert_band DROP FOREIGN KEY FK_94287428D0C1FC64');
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EBEE45BDBF');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA78EE45BDBF');
        $this->addSql('CREATE TABLE `concert` (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, date DATE NOT NULL, tour_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_320ED90152AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concert ADD CONSTRAINT FK_320ED90152AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('DROP TABLE concert_show');
        $this->addSql('DROP TABLE member_band');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP INDEX IDX_48DFA2EBEE45BDBF ON band');
        $this->addSql('ALTER TABLE band ADD picture VARCHAR(255) DEFAULT NULL, ADD creation_year DATE DEFAULT NULL, DROP picture_id, DROP year_of_creation, CHANGE last_album_name last_album_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE concert_hall DROP FOREIGN KEY FK_BE329CF852AFCFD6');
        $this->addSql('DROP INDEX IDX_BE329CF852AFCFD6 ON concert_hall');
        $this->addSql('ALTER TABLE concert_hall ADD total_capacity INT DEFAULT NULL, DROP hall_id, DROP total_places, CHANGE presentation presentation LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE hall ADD concert_hall_id INT DEFAULT NULL, CHANGE available available TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE hall ADD CONSTRAINT FK_1B8FA83FC8B57370 FOREIGN KEY (concert_hall_id) REFERENCES concert_hall (id)');
        $this->addSql('CREATE INDEX IDX_1B8FA83FC8B57370 ON hall (concert_hall_id)');
        $this->addSql('DROP INDEX IDX_70E4FA78EE45BDBF ON member');
        $this->addSql('ALTER TABLE member ADD band_id INT DEFAULT NULL, ADD picture VARCHAR(255) DEFAULT NULL, DROP picture_id, CHANGE birth_date birth_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA7849ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA7849ABEB17 ON member (band_id)');
        $this->addSql('ALTER TABLE concert_band DROP FOREIGN KEY FK_94287428D0C1FC64');
        $this->addSql('ALTER TABLE concert_band ADD CONSTRAINT FK_94287428D0C1FC64 FOREIGN KEY (show_id) REFERENCES concert (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concert_band DROP FOREIGN KEY FK_94287428D0C1FC64');
        $this->addSql('CREATE TABLE concert_show (id INT AUTO_INCREMENT NOT NULL, hall_id INT NOT NULL, date DATE NOT NULL, tourname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_320ED90152AFCFD6 (hall_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE member_band (member_id INT NOT NULL, band_id INT NOT NULL, INDEX IDX_B4578EB77597D3FE (member_id), INDEX IDX_B4578EB749ABEB17 (band_id), PRIMARY KEY(member_id, band_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, picture VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE concert_show ADD CONSTRAINT FK_320ED90152AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('ALTER TABLE member_band ADD CONSTRAINT FK_B4578EB749ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE member_band ADD CONSTRAINT FK_B4578EB77597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE concert');
        $this->addSql('ALTER TABLE band ADD picture_id INT NOT NULL, ADD year_of_creation DATE NOT NULL, DROP picture, DROP creation_year, CHANGE last_album_name last_album_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EBEE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('CREATE INDEX IDX_48DFA2EBEE45BDBF ON band (picture_id)');
        $this->addSql('ALTER TABLE concert_hall ADD hall_id INT NOT NULL, ADD total_places INT NOT NULL, DROP total_capacity, CHANGE presentation presentation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE concert_hall ADD CONSTRAINT FK_BE329CF852AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id)');
        $this->addSql('CREATE INDEX IDX_BE329CF852AFCFD6 ON concert_hall (hall_id)');
        $this->addSql('ALTER TABLE hall DROP FOREIGN KEY FK_1B8FA83FC8B57370');
        $this->addSql('DROP INDEX IDX_1B8FA83FC8B57370 ON hall');
        $this->addSql('ALTER TABLE hall DROP concert_hall_id, CHANGE available available VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE member DROP FOREIGN KEY FK_70E4FA7849ABEB17');
        $this->addSql('DROP INDEX IDX_70E4FA7849ABEB17 ON member');
        $this->addSql('ALTER TABLE member ADD picture_id INT NOT NULL, DROP band_id, DROP picture, CHANGE birth_date birth_date DATE NOT NULL');
        $this->addSql('ALTER TABLE member ADD CONSTRAINT FK_70E4FA78EE45BDBF FOREIGN KEY (picture_id) REFERENCES picture (id)');
        $this->addSql('CREATE INDEX IDX_70E4FA78EE45BDBF ON member (picture_id)');
        $this->addSql('ALTER TABLE concert_band DROP FOREIGN KEY FK_94287428D0C1FC64');
        $this->addSql('ALTER TABLE concert_band ADD CONSTRAINT FK_94287428D0C1FC64 FOREIGN KEY (show_id) REFERENCES concert_show (id) ON DELETE CASCADE');
    }
}
