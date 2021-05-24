<?php

declare(strict_types=1);

namespace ADLinker\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520000123 extends AbstractMigration
{
    public function getDescription(): string
    {
        $this->site_name      = trim(_addslashes(strip_tags(getenv('SITE_NAME'))));
        $this->support_email  = trim(strtolower(_addslashes(strip_tags(getenv('SITE_CONTACT_US_EMAIL')))));
        $this->sub_folder     = get_sub_folder();
        $this->time           = time();

        $this->admin_name     = trim(_addslashes(strip_tags(getenv('USER_USERNAME'))));
        $this->admin_email    = trim(strtolower(_addslashes(strip_tags(getenv('USER_EMAIL')))));
        $this->admin_pass     = trim(_addslashes(strip_tags(getenv('USER_PASSWORD'))));

        $this->db_prefix      = trim(strtolower(_addslashes(strip_tags(getenv('DB_PREFIX')))));
        $this->db_hostname    = trim(_addslashes(strip_tags(getenv('DB_HOSTNAME'))));
        $this->db_name        = trim(_addslashes(strip_tags(getenv('DB_NAME'))));
        $this->db_username    = trim(_addslashes(strip_tags(getenv('DB_USER'))));
        $this->db_password    = trim(_addslashes(strip_tags(getenv('DB_PASSWORD'))));

        return 'Creating Countries & Publisher_rates tables.';
    }

    public function up(Schema $schema): void
    {
        // Countries table
        $countries = $schema->createTable($this->db_prefix.'countries');
        $countries->addColumn('id', 'integer', [
            'autoincrement' => true
        ]);
        $countries->addColumn('name', 'string', [
            'notnull' => true
        ]);
        $countries->addColumn('code', 'string', [
            'notnull' => true
        ]);

        $countries->setPrimaryKey(['id']);

        // Publishers table
        $pub_table = $schema->createTable($this->db_prefix.'publisher_rates');
        $pub_table->addColumn('id', 'integer', [
            'autoincrement' => true,
        ]);
        $pub_table->addColumn('country_id', 'integer');
        $pub_table->addColumn('price', 'float', [
            'default' => 0
        ]);
        $pub_table->addColumn('active', 'boolean', ['default' => true]);

        $pub_table->setPrimaryKey(['id']);
        $pub_table->addForeignKeyConstraint($countries, ['country_id'], ['id'], [
            'onUpdate' => 'CASCADE'
        ]);
    }

    public function down(Schema $schema): void
    {
        if ($schema->tablesExist($this->db_prefix.'publisher_rates'))
            $schema->dropTable($this->db_prefix.'publisher_rates');

        if ($schema->tablesExist($this->db_prefix.'countries'))
            $schema->dropTable($this->db_prefix.'countries');
    }

    public function postUp(Schema $schema): void
    {
        // insert some default countries
        $this->write('Inserting countries...');
        $i = 1;
        foreach(get_default_countries() as $country)
        {
            // inserting countries.
            $this->connection->insert($this->db_prefix.'countries', [
                'name' => $country['name'],
                'code' => $country['code']
            ]);

            // setting default values.
            $this->connection->insert($this->db_prefix.'publisher_rates', [
                'country_id' => $i,
                'price' => 0.4
            ]);
            $i++;
        }
    }
}
