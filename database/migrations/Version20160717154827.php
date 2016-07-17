<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160717154827 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {

        $this->addSql(
            'INSERT INTO ebay_listings(item_id, `value`, seller_account_name, should_monitor, created_at, updated_at) VALUES (\'110181384286\', 5, \'testuser_itctseller2014\', 1, CURRENT_TIMESTAMP ,CURRENT_TIMESTAMP )'
        );

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql(
            'DELETE FROM ebay_listings WHERE item_id = \'110181384286\''
        );
    }
}
