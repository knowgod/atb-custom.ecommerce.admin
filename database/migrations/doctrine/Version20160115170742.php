<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160115170742 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE dusers (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, email VARCHAR(32) NOT NULL, register_source VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, google_avatar_img VARCHAR(255) DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_F006BE1BE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE migrations');
        $this->addSql('DROP TABLE some_test_table');
        $this->addSql('DROP INDEX password_resets_email_index ON password_resets');
        $this->addSql('DROP INDEX password_resets_token_index ON password_resets');
        $this->addSql('ALTER TABLE password_resets ADD PRIMARY KEY (email)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE migrations (migration VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, batch INT NOT NULL) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE some_test_table (id INT AUTO_INCREMENT NOT NULL, `key` VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, value VARCHAR(255) DEFAULT NULL COLLATE utf8_general_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT UNSIGNED AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, lastname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, password VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, user_group VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, register_source VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, permission_group_id BIGINT NOT NULL, remember_token VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, google_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, google_avatar_img VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, fullname VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX users_email_unique (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE dusers');
        $this->addSql('ALTER TABLE password_resets DROP INDEX primary, ADD INDEX password_resets_email_index (email)');
        $this->addSql('CREATE INDEX password_resets_token_index ON password_resets (token)');
    }
}
