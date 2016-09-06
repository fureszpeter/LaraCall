<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160717154718 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
//        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE users (id INTEGER NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(128) DEFAULT NULL, registration_date DATETIME NOT NULL, subscription_counter INTEGER DEFAULT 0 NOT NULL, pins CLOB NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, contact_first_name VARCHAR(128) DEFAULT NULL, contact_last_name VARCHAR(128) DEFAULT NULL, contact_country VARCHAR(128) DEFAULT NULL, contact_state VARCHAR(128) DEFAULT NULL, contact_zip_code VARCHAR(16) DEFAULT NULL, contact_address1 VARCHAR(254) DEFAULT NULL, contact_address2 VARCHAR(254) DEFAULT NULL, contact_phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9BF396750 ON users (id)');
        $this->addSql('CREATE TABLE subscriptions (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, pin VARCHAR(10) NOT NULL, subscription_creation_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, last_refill_date DATETIME DEFAULT NULL, last_refill_amount NUMERIC(19, 4) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01B5852DF3 ON subscriptions (pin)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01BF396750 ON subscriptions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01A76ED395 ON subscriptions (user_id)');
        $this->addSql('CREATE TABLE api_cron_logs (id INTEGER NOT NULL, range_from DATETIME NOT NULL, range_to DATETIME NOT NULL, command VARCHAR(254) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34CE8925BF396750 ON api_cron_logs (id)');
        $this->addSql('CREATE TABLE ebay_transaction_logs (transaction_id VARCHAR(255) NOT NULL, cron_id INTEGER DEFAULT NULL, item_id VARCHAR(32) DEFAULT NULL, quantity INTEGER DEFAULT NULL, sold_price_per_item VARCHAR(255) DEFAULT NULL, amount_payed VARCHAR(255) DEFAULT NULL, transaction_date DATETIME NOT NULL, transaction_data CLOB NOT NULL, order_status VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(transaction_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B52346232FC0CB0F ON ebay_transaction_logs (transaction_id)');
        $this->addSql('CREATE INDEX IDX_B523462338435942 ON ebay_transaction_logs (cron_id)');
        $this->addSql('CREATE TABLE countries (id INTEGER NOT NULL, countryCode VARCHAR(2) NOT NULL, countryName VARCHAR(45) NOT NULL, currencyCode VARCHAR(3) DEFAULT NULL, isoAlpha3 VARCHAR(3) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5D66EBADBF396750 ON countries (id)');
        $this->addSql('CREATE TABLE ebay_listings (item_id VARCHAR(64) NOT NULL, seller_account_name VARCHAR(64) NOT NULL, should_monitor BOOLEAN DEFAULT \'1\' NOT NULL, value NUMERIC(19, 4) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(item_id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1175B2B2126F525E ON ebay_listings (item_id)');
        $this->addSql('CREATE TABLE states (abbrev VARCHAR(2) NOT NULL, name VARCHAR(40) NOT NULL, PRIMARY KEY(abbrev))');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
//        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE subscriptions');
        $this->addSql('DROP TABLE api_cron_logs');
        $this->addSql('DROP TABLE ebay_transaction_logs');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE ebay_listings');
        $this->addSql('DROP TABLE states');
    }
}
