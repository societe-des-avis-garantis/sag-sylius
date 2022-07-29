<?php

declare(strict_types=1);

namespace Dedi\SyliusSAGPlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20220622082957 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dedi_sag_plugin_api_key_config (id INT AUTO_INCREMENT NOT NULL, api_key VARCHAR(255) NOT NULL, certificate_of_truth_url VARCHAR(255) DEFAULT NULL, order_states_to_export LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', order_payment_states_to_export LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', order_shipping_states_to_export LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dedi_sag_plugin_api_key_config_locales (config_id INT NOT NULL, locale_id INT NOT NULL, INDEX IDX_7DAC0ED524DB0683 (config_id), INDEX IDX_7DAC0ED5E559DFD1 (locale_id), PRIMARY KEY(config_id, locale_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dedi_sag_plugin_api_key_config_channels (config_id INT NOT NULL, channel_id INT NOT NULL, INDEX IDX_598699B324DB0683 (config_id), INDEX IDX_598699B372F5A1AA (channel_id), PRIMARY KEY(config_id, channel_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dedi_sag_plugin_repartition_of_scores (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, one_star_count INT DEFAULT 0 NOT NULL, two_star_count INT DEFAULT 0 NOT NULL, three_star_count INT DEFAULT 0 NOT NULL, four_star_count INT DEFAULT 0 NOT NULL, five_star_count INT DEFAULT 0 NOT NULL, country_code VARCHAR(255) NOT NULL, INDEX IDX_57CA864A4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_reviewer (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dedi_sag_plugin_api_key_config_locales ADD CONSTRAINT FK_7DAC0ED524DB0683 FOREIGN KEY (config_id) REFERENCES dedi_sag_plugin_api_key_config (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dedi_sag_plugin_api_key_config_locales ADD CONSTRAINT FK_7DAC0ED5E559DFD1 FOREIGN KEY (locale_id) REFERENCES sylius_locale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dedi_sag_plugin_api_key_config_channels ADD CONSTRAINT FK_598699B324DB0683 FOREIGN KEY (config_id) REFERENCES dedi_sag_plugin_api_key_config (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dedi_sag_plugin_api_key_config_channels ADD CONSTRAINT FK_598699B372F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dedi_sag_plugin_repartition_of_scores ADD CONSTRAINT FK_57CA864A4584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_channel ADD sag_show_javascript_widget TINYINT(1) DEFAULT \'1\' NOT NULL, ADD sag_show_iframe_widget TINYINT(1) DEFAULT \'1\' NOT NULL, ADD sag_show_footer_certificate_link TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE sylius_product ADD sag_ean13 VARCHAR(255) DEFAULT NULL, ADD sag_upc VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product_review DROP FOREIGN KEY FK_C7056A99F675F31B');
        $this->addSql('ALTER TABLE sylius_product_review ADD sag_id VARCHAR(255) DEFAULT NULL, ADD sag_answer_comment LONGTEXT DEFAULT NULL, ADD sag_answer_created_at DATETIME DEFAULT NULL, ADD sag_ordered_at DATETIME DEFAULT NULL, ADD sag_country_code VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sylius_product_review ADD CONSTRAINT FK_C7056A99F675F31B FOREIGN KEY (author_id) REFERENCES sylius_reviewer (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7056A99A7D753A9 ON sylius_product_review (sag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dedi_sag_plugin_api_key_config_locales DROP FOREIGN KEY FK_7DAC0ED524DB0683');
        $this->addSql('ALTER TABLE dedi_sag_plugin_api_key_config_channels DROP FOREIGN KEY FK_598699B324DB0683');
        $this->addSql('ALTER TABLE sylius_product_review DROP FOREIGN KEY FK_C7056A99F675F31B');
        $this->addSql('DROP TABLE dedi_sag_plugin_api_key_config');
        $this->addSql('DROP TABLE dedi_sag_plugin_api_key_config_locales');
        $this->addSql('DROP TABLE dedi_sag_plugin_api_key_config_channels');
        $this->addSql('DROP TABLE dedi_sag_plugin_repartition_of_scores');
        $this->addSql('DROP TABLE sylius_reviewer');
        $this->addSql('ALTER TABLE sylius_channel DROP sag_show_javascript_widget, DROP sag_show_iframe_widget, DROP sag_show_footer_certificate_link');
        $this->addSql('ALTER TABLE sylius_product DROP sag_ean13, DROP sag_upc');
        $this->addSql('ALTER TABLE sylius_product_review DROP FOREIGN KEY FK_C7056A99F675F31B');
        $this->addSql('DROP INDEX UNIQ_C7056A99A7D753A9 ON sylius_product_review');
        $this->addSql('ALTER TABLE sylius_product_review DROP sag_id, DROP sag_answer_comment, DROP sag_answer_created_at, DROP sag_ordered_at, DROP sag_country_code');
        $this->addSql('ALTER TABLE sylius_product_review ADD CONSTRAINT FK_C7056A99F675F31B FOREIGN KEY (author_id) REFERENCES sylius_customer (id) ON DELETE CASCADE');
    }
}
