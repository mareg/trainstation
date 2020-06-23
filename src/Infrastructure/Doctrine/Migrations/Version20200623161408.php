<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200623161408 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create the db';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE stations (
                uuid VARCHAR(36) NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY(uuid)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            CREATE TABLE tracks (
                uuid VARCHAR(36) NOT NULL,
                station_id VARCHAR(36) NOT NULL,
                track_number INT NOT NULL,
                platform VARCHAR(10) DEFAULT NULL,
                train VARCHAR(255) DEFAULT NULL,
                INDEX IDX_246D2A2E21BDB235 (station_id),
                PRIMARY KEY(uuid)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');

        $this->addSql('
            ALTER TABLE tracks ADD CONSTRAINT FK_246D2A2E21BDB235 FOREIGN KEY (station_id) REFERENCES stations (uuid)
        ');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('
            ALTER TABLE tracks DROP FOREIGN KEY FK_246D2A2E21BDB235
        ');

        $this->addSql('
            DROP TABLE tracks
        ');

        $this->addSql('
            DROP TABLE stations
        ');
    }
}
