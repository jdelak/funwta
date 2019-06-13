<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190404111216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE archive (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, player_id INT NOT NULL, position INT NOT NULL, points INT NOT NULL, INDEX IDX_D5FC5D9C4EC001D1 (season_id), INDEX IDX_D5FC5D9C99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, flag VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, tournament_id INT DEFAULT NULL, player_one_id INT NOT NULL, player_two_id INT NOT NULL, winner_id INT NOT NULL, round VARCHAR(255) NOT NULL, player_one_set_one INT NOT NULL, player_one_set_two INT NOT NULL, player_one_set_three INT DEFAULT NULL, player_two_set_one INT NOT NULL, player_two_set_two INT NOT NULL, player_two_set_three INT DEFAULT NULL, INDEX IDX_232B318C33D1A3E7 (tournament_id), INDEX IDX_232B318C649A58CD (player_one_id), INDEX IDX_232B318CFC6BF02 (player_two_id), INDEX IDX_232B318C5DFCD4B8 (winner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, height INT NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, montee_filet INT NOT NULL, puissance INT NOT NULL, reflexes INT NOT NULL, vitesse_service INT NOT NULL, endurance INT NOT NULL, vitesse INT NOT NULL, service_plat INT NOT NULL, service_lift INT NOT NULL, service_slice INT NOT NULL, droit_plat INT NOT NULL, droit_lift INT NOT NULL, droit_slice INT NOT NULL, revers_plat INT NOT NULL, revers_lift INT NOT NULL, revers_slice INT NOT NULL, volee INT NOT NULL, volee_amorti INT NOT NULL, lob INT NOT NULL, victory INT NOT NULL, trophy INT NOT NULL, INDEX IDX_98197A65F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ranking (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, player_id INT NOT NULL, position INT NOT NULL, points INT NOT NULL, INDEX IDX_80B839D04EC001D1 (season_id), INDEX IDX_80B839D099E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE season (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament (id INT AUTO_INCREMENT NOT NULL, season_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_BD5FB8D94EC001D1 (season_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tournament_ranking (id INT AUTO_INCREMENT NOT NULL, tournament_id INT NOT NULL, player_id INT NOT NULL, points INT NOT NULL, INDEX IDX_EBB7C2DA33D1A3E7 (tournament_id), INDEX IDX_EBB7C2DA99E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', reset_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, match_id_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7CC7DA2CC12EE1F6 (match_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9C4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE archive ADD CONSTRAINT FK_D5FC5D9C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C649A58CD FOREIGN KEY (player_one_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CFC6BF02 FOREIGN KEY (player_two_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5DFCD4B8 FOREIGN KEY (winner_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D04EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE ranking ADD CONSTRAINT FK_80B839D099E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE tournament ADD CONSTRAINT FK_BD5FB8D94EC001D1 FOREIGN KEY (season_id) REFERENCES season (id)');
        $this->addSql('ALTER TABLE tournament_ranking ADD CONSTRAINT FK_EBB7C2DA33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id)');
        $this->addSql('ALTER TABLE tournament_ranking ADD CONSTRAINT FK_EBB7C2DA99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CC12EE1F6 FOREIGN KEY (match_id_id) REFERENCES game (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65F92F3E70');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CC12EE1F6');
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9C99E6F5DF');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C649A58CD');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CFC6BF02');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5DFCD4B8');
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D099E6F5DF');
        $this->addSql('ALTER TABLE tournament_ranking DROP FOREIGN KEY FK_EBB7C2DA99E6F5DF');
        $this->addSql('ALTER TABLE archive DROP FOREIGN KEY FK_D5FC5D9C4EC001D1');
        $this->addSql('ALTER TABLE ranking DROP FOREIGN KEY FK_80B839D04EC001D1');
        $this->addSql('ALTER TABLE tournament DROP FOREIGN KEY FK_BD5FB8D94EC001D1');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C33D1A3E7');
        $this->addSql('ALTER TABLE tournament_ranking DROP FOREIGN KEY FK_EBB7C2DA33D1A3E7');
        $this->addSql('DROP TABLE archive');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE ranking');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE tournament');
        $this->addSql('DROP TABLE tournament_ranking');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE video');
    }
}
