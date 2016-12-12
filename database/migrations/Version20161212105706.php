<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20161212105706 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(128) NOT NULL, password VARCHAR(128) DEFAULT NULL, registration_date DATETIME NOT NULL, subscription_counter INT DEFAULT 0 NOT NULL, pins LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, contact_first_name VARCHAR(128) DEFAULT NULL, contact_last_name VARCHAR(128) DEFAULT NULL, contact_country VARCHAR(128) DEFAULT NULL, contact_state VARCHAR(128) DEFAULT NULL, contact_zip_code VARCHAR(16) DEFAULT NULL, contact_address1 VARCHAR(254) DEFAULT NULL, contact_address2 VARCHAR(254) DEFAULT NULL, contact_phone_number VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E9BF396750 (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscriptions (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, pin VARCHAR(10) NOT NULL, subscription_creation_date DATETIME NOT NULL, expiration_date DATETIME NOT NULL, last_refill_date DATETIME DEFAULT NULL, last_refill_amount NUMERIC(19, 4) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_4778A01B5852DF3 (pin), UNIQUE INDEX UNIQ_4778A01BF396750 (id), UNIQUE INDEX UNIQ_4778A01A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE countries (id INT AUTO_INCREMENT NOT NULL, countryCode VARCHAR(2) NOT NULL, countryName VARCHAR(45) NOT NULL, currencyCode VARCHAR(3) DEFAULT NULL, isoAlpha3 VARCHAR(3) DEFAULT NULL, UNIQUE INDEX UNIQ_5D66EBADBF396750 (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ebay_sync_logs (id INT AUTO_INCREMENT NOT NULL, range_from DATETIME NOT NULL, range_to DATETIME NOT NULL, result LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8DBD18FFBF396750 (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ebay_transaction_logs (transaction_id VARCHAR(255) NOT NULL, sync_id INT DEFAULT NULL, item_id VARCHAR(32) DEFAULT NULL, quantity INT DEFAULT NULL, sold_price_per_item VARCHAR(255) DEFAULT NULL, amount_payed VARCHAR(255) DEFAULT NULL, transaction_date DATETIME NOT NULL, transaction_data LONGTEXT NOT NULL, order_status VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B52346232FC0CB0F (transaction_id), INDEX IDX_B5234623FA50C422 (sync_id), PRIMARY KEY(transaction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items (item_id VARCHAR(64) NOT NULL, seller_account_name VARCHAR(64) NOT NULL, should_monitor TINYINT(1) DEFAULT \'1\' NOT NULL, value NUMERIC(19, 4) DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_E11EE94D126F525E (item_id), PRIMARY KEY(item_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE states (abbrev VARCHAR(2) NOT NULL, name VARCHAR(40) NOT NULL, PRIMARY KEY(abbrev)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subscriptions ADD CONSTRAINT FK_4778A01A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE ebay_transaction_logs ADD CONSTRAINT FK_B5234623FA50C422 FOREIGN KEY (sync_id) REFERENCES ebay_sync_logs (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subscriptions DROP FOREIGN KEY FK_4778A01A76ED395');
        $this->addSql('ALTER TABLE ebay_transaction_logs DROP FOREIGN KEY FK_B5234623FA50C422');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE subscriptions');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE ebay_sync_logs');
        $this->addSql('DROP TABLE ebay_transaction_logs');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE states');
    }
}
