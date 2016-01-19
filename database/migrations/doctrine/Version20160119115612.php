<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160119115612 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, increment_id VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, customer_name VARCHAR(255) DEFAULT NULL, email VARCHAR(32) NOT NULL, grand_total NUMERIC(4, 0) DEFAULT NULL, total_paid NUMERIC(4, 0) DEFAULT NULL, payment_method VARCHAR(55) DEFAULT NULL, discount_amount NUMERIC(4, 0) DEFAULT NULL, shipping_country_code VARCHAR(32) DEFAULT NULL, coupon_code VARCHAR(32) NOT NULL, qty INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE orders');
    }
}
