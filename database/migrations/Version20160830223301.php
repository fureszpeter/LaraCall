<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160830223301 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE api_cron_logs');
        $this->addSql('DROP INDEX UNIQ_B52346232FC0CB0F');
        $this->addSql('DROP INDEX IDX_B5234623FA50C422');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ebay_transaction_logs AS SELECT transaction_id, sync_id, item_id, quantity, sold_price_per_item, amount_payed, transaction_date, transaction_data, order_status, created_at, updated_at FROM ebay_transaction_logs');
        $this->addSql('DROP TABLE ebay_transaction_logs');
        $this->addSql('CREATE TABLE ebay_transaction_logs (transaction_id VARCHAR(255) NOT NULL COLLATE BINARY, sync_id INTEGER DEFAULT NULL, item_id VARCHAR(32) DEFAULT NULL COLLATE BINARY, quantity INTEGER DEFAULT NULL, sold_price_per_item VARCHAR(255) DEFAULT NULL COLLATE BINARY, amount_payed VARCHAR(255) DEFAULT NULL COLLATE BINARY, transaction_date DATETIME NOT NULL, transaction_data CLOB NOT NULL COLLATE BINARY, order_status VARCHAR(64) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(transaction_id), CONSTRAINT FK_B5234623FA50C422 FOREIGN KEY (sync_id) REFERENCES ebay_sync_logs (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO ebay_transaction_logs (transaction_id, sync_id, item_id, quantity, sold_price_per_item, amount_payed, transaction_date, transaction_data, order_status, created_at, updated_at) SELECT transaction_id, sync_id, item_id, quantity, sold_price_per_item, amount_payed, transaction_date, transaction_data, order_status, created_at, updated_at FROM __temp__ebay_transaction_logs');
        $this->addSql('DROP TABLE __temp__ebay_transaction_logs');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B52346232FC0CB0F ON ebay_transaction_logs (transaction_id)');
        $this->addSql('CREATE INDEX IDX_B5234623FA50C422 ON ebay_transaction_logs (sync_id)');
        $this->addSql('DROP INDEX UNIQ_4778A01A76ED395');
        $this->addSql('DROP INDEX UNIQ_4778A01BF396750');
        $this->addSql('DROP INDEX UNIQ_4778A01B5852DF3');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subscriptions AS SELECT id, user_id, pin, subscription_creation_date, expiration_date, last_refill_date, last_refill_amount, created_at, updated_at FROM subscriptions');
        $this->addSql('DROP TABLE subscriptions');
        $this->addSql('CREATE TABLE subscriptions (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, pin VARCHAR(10) NOT NULL COLLATE BINARY, subscription_creation_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, last_refill_date DATETIME DEFAULT NULL, last_refill_amount NUMERIC(19, 4) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4778A01A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO subscriptions (id, user_id, pin, subscription_creation_date, expiration_date, last_refill_date, last_refill_amount, created_at, updated_at) SELECT id, user_id, pin, subscription_creation_date, expiration_date, last_refill_date, last_refill_amount, created_at, updated_at FROM __temp__subscriptions');
        $this->addSql('DROP TABLE __temp__subscriptions');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01A76ED395 ON subscriptions (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01BF396750 ON subscriptions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01B5852DF3 ON subscriptions (pin)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE api_cron_logs (id INTEGER NOT NULL, range_from DATETIME NOT NULL, range_to DATETIME NOT NULL, command VARCHAR(254) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34CE8925BF396750 ON api_cron_logs (id)');
        $this->addSql('DROP INDEX UNIQ_B52346232FC0CB0F');
        $this->addSql('DROP INDEX IDX_B5234623FA50C422');
        $this->addSql('CREATE TEMPORARY TABLE __temp__ebay_transaction_logs AS SELECT transaction_id, sync_id, item_id, quantity, sold_price_per_item, amount_payed, transaction_date, transaction_data, order_status, created_at, updated_at FROM ebay_transaction_logs');
        $this->addSql('DROP TABLE ebay_transaction_logs');
        $this->addSql('CREATE TABLE ebay_transaction_logs (transaction_id VARCHAR(255) NOT NULL, sync_id INTEGER DEFAULT NULL, item_id VARCHAR(32) DEFAULT NULL, quantity INTEGER DEFAULT NULL, sold_price_per_item VARCHAR(255) DEFAULT NULL, amount_payed VARCHAR(255) DEFAULT NULL, transaction_date DATETIME NOT NULL, transaction_data CLOB NOT NULL, order_status VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(transaction_id))');
        $this->addSql('INSERT INTO ebay_transaction_logs (transaction_id, sync_id, item_id, quantity, sold_price_per_item, amount_payed, transaction_date, transaction_data, order_status, created_at, updated_at) SELECT transaction_id, sync_id, item_id, quantity, sold_price_per_item, amount_payed, transaction_date, transaction_data, order_status, created_at, updated_at FROM __temp__ebay_transaction_logs');
        $this->addSql('DROP TABLE __temp__ebay_transaction_logs');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B52346232FC0CB0F ON ebay_transaction_logs (transaction_id)');
        $this->addSql('CREATE INDEX IDX_B5234623FA50C422 ON ebay_transaction_logs (sync_id)');
        $this->addSql('DROP INDEX UNIQ_4778A01B5852DF3');
        $this->addSql('DROP INDEX UNIQ_4778A01BF396750');
        $this->addSql('DROP INDEX UNIQ_4778A01A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__subscriptions AS SELECT id, user_id, pin, subscription_creation_date, expiration_date, last_refill_date, last_refill_amount, created_at, updated_at FROM subscriptions');
        $this->addSql('DROP TABLE subscriptions');
        $this->addSql('CREATE TABLE subscriptions (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, pin VARCHAR(10) NOT NULL, subscription_creation_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, last_refill_date DATETIME DEFAULT NULL, last_refill_amount NUMERIC(19, 4) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO subscriptions (id, user_id, pin, subscription_creation_date, expiration_date, last_refill_date, last_refill_amount, created_at, updated_at) SELECT id, user_id, pin, subscription_creation_date, expiration_date, last_refill_date, last_refill_amount, created_at, updated_at FROM __temp__subscriptions');
        $this->addSql('DROP TABLE __temp__subscriptions');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01B5852DF3 ON subscriptions (pin)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01BF396750 ON subscriptions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4778A01A76ED395 ON subscriptions (user_id)');
    }
}
