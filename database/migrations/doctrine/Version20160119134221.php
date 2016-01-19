<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160119134221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders CHANGE grand_total grand_total NUMERIC(12, 4) DEFAULT NULL, CHANGE total_paid total_paid NUMERIC(12, 4) DEFAULT NULL, CHANGE discount_amount discount_amount NUMERIC(12, 4) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE orders CHANGE grand_total grand_total NUMERIC(4, 0) DEFAULT NULL, CHANGE total_paid total_paid NUMERIC(4, 0) DEFAULT NULL, CHANGE discount_amount discount_amount NUMERIC(4, 0) DEFAULT NULL');
    }
}
