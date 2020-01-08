<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200104225959 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE agglomeration (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, size INT NOT NULL, leader VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agglomeration_map (agglomeration_id INT NOT NULL, map_id INT NOT NULL, INDEX IDX_974C5AE885EF21D6 (agglomeration_id), INDEX IDX_974C5AE853C55F64 (map_id), PRIMARY KEY(agglomeration_id, map_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, function VARCHAR(255) NOT NULL, size INT NOT NULL, leader VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE building_agglomeration (building_id INT NOT NULL, agglomeration_id INT NOT NULL, INDEX IDX_5745562D4D2A7E12 (building_id), INDEX IDX_5745562D85EF21D6 (agglomeration_id), PRIMARY KEY(building_id, agglomeration_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE map (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, biomes LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', universe_type INT DEFAULT NULL, interest_points LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_93ADAABBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agglomeration_map ADD CONSTRAINT FK_974C5AE885EF21D6 FOREIGN KEY (agglomeration_id) REFERENCES agglomeration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agglomeration_map ADD CONSTRAINT FK_974C5AE853C55F64 FOREIGN KEY (map_id) REFERENCES map (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE building_agglomeration ADD CONSTRAINT FK_5745562D4D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE building_agglomeration ADD CONSTRAINT FK_5745562D85EF21D6 FOREIGN KEY (agglomeration_id) REFERENCES agglomeration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE map ADD CONSTRAINT FK_93ADAABBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE agglomeration_map DROP FOREIGN KEY FK_974C5AE885EF21D6');
        $this->addSql('ALTER TABLE building_agglomeration DROP FOREIGN KEY FK_5745562D85EF21D6');
        $this->addSql('ALTER TABLE building_agglomeration DROP FOREIGN KEY FK_5745562D4D2A7E12');
        $this->addSql('ALTER TABLE agglomeration_map DROP FOREIGN KEY FK_974C5AE853C55F64');
        $this->addSql('ALTER TABLE map DROP FOREIGN KEY FK_93ADAABBA76ED395');
        $this->addSql('DROP TABLE agglomeration');
        $this->addSql('DROP TABLE agglomeration_map');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP TABLE building_agglomeration');
        $this->addSql('DROP TABLE map');
        $this->addSql('DROP TABLE user');
    }
}
