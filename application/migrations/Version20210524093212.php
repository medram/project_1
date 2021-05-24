<?php

declare(strict_types=1);

namespace ADLinker\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Table;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524093212 extends AbstractMigration
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

        return '';
    }

    public function up(Schema $schema): void
    {
        // get user table
        $sm = $this->connection->getSchemaManager();

        $user = $sm->listTableDetails($this->db_prefix.'users');
        $this->addSql("ALTER TABLE `".$this->db_prefix."users` ADD `balance` FLOAT(6) DEFAULT 0");
        //$user->addColumn('balance', 'float', ['default' => 0]);

        // payment_methods table
        $methods = $schema->createTable($this->db_prefix.'payment_methods');
        $methods->addColumn('id', 'integer', [
            'autoincrement' => true
        ]);

        $methods->addColumn('name', 'string');
        $methods->addColumn('min_amount', 'float', ['default' => 0]);
        $methods->addColumn('status', 'integer', ['default' => 0]);

        $methods->setPrimaryKey(['id']);

        // payment_methods table
        $withdraw = $schema->createTable($this->db_prefix.'withdraw_reqs');
        $withdraw->addColumn('id', 'integer', [
            'autoincrement' => true
        ]);
        $withdraw->addColumn('user_id', 'integer');
        $withdraw->addColumn('payment_method_id', 'integer', ['default' => 0]);
        $withdraw->addColumn('amount', 'float', ['default' => 0]);
        $withdraw->addColumn('created', 'datetime');

        $withdraw->setPrimaryKey(['id']);
        $withdraw->addForeignKeyConstraint($user, ['user_id'], ['id'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'CASCADE',
        ]);
        $withdraw->addForeignKeyConstraint($methods, ['payment_method_id'], ['id'], [
            'onUpdate' => 'CASCADE',
            'onDelete' => 'SET DEFAULT',
        ]);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS '.$this->db_prefix.'withdraw_reqs');
        $this->addSql('DROP TABLE IF EXISTS '.$this->db_prefix.'payment_methods');
        $this->addSql('ALTER TABLE '.$this->db_prefix.'users DROP COLUMN balance');
    }

    public function postUp(Schema $schema): void
    {
        $payment_methods_table = $this->db_prefix.'payment_methods';
        $methods = [
            ['name' => 'PayPal', 'min_amount' => 50, 'status' => 0],
            ['name' => 'Stripe', 'min_amount' => 50, 'status' => 0],
            ['name' => 'Bank Account', 'min_amount' => 50, 'status' => 0]
        ];

        foreach($methods as $method)
        {
            $this->connection->insert($payment_methods_table, $method);
        }
    }
}
