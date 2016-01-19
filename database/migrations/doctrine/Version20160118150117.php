<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160118150117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE password_resets ADD PRIMARY KEY (email)');
        $this->addSql('ALTER TABLE users DROP user_group, DROP permission_group_id, CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE firstname firstname VARCHAR(255) DEFAULT NULL, CHANGE lastname lastname VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(32) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE register_source register_source VARCHAR(255) DEFAULT NULL, CHANGE remember_token remember_token VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE users ADD user_group VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD permission_group_id BIGINT NOT NULL, CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE firstname firstname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE lastname lastname VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE register_source register_source VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE password password VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, CHANGE remember_token remember_token VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
