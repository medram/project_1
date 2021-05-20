<?php

declare(strict_types=1);

namespace ADLinker\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

require_once 'data/utils.php';


/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519233108 extends AbstractMigration
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

        return 'Initial migration.';
    }

    public function up(Schema $schema): void
    {
        // load all SQL queries & execut them here.
        $this->data_validation();
        $this->install_db($schema);
        $this->create_admin_account($schema);
        $this->update_site_settings($schema);
        $this->file_configuration($schema);
    }

    public function down(Schema $schema): void
    {
        // Drop all Database tables.
        $tables = get_tables($this->db_prefix);

        $this->write('Dropping database tables...');
        foreach ($tables as $key => $table_name)
        {
            $this->addSql('DROP TABLE IF EXISTS '.$table_name);
        }
    }

    public function postDown(Schema $schema) : void
    {
        $this->write('Database dropped successfully.');
    }

    public function postUp(Schema $schema): void
    {
        $this->write('Installed successfully.');
        $this->write("
============ Dashboard admin login info ============
URL: http://my-domain.com/adminpanel
Username: ".$this->admin_name."
Email: ".$this->admin_email."
Password: use the inserted passwrod.
        ");
    }

    private function server_validation()
    {
        // require_once 'data/check_the_server_environment.php'
    }

    private function data_validation()
    {
        $this->abortIf(!$this->site_name, "'SITE_NAME' shouldn't be empty, please enter a string value (from .env file).");

        $this->abortIf(!filter_var($this->admin_email, FILTER_VALIDATE_EMAIL), "'USER_EMAIL' is not a valid email (from .env file).");

        if ($this->support_email)
        {
            $this->abortIf(!filter_var($this->support_email, FILTER_VALIDATE_EMAIL), "'SITE_CONTACT_US_EMAIL' is not a valid email (from .env file).");
        }
    }

    private function file_configuration(Schema $schema)
    {
        $this->write('Configuring files...');

        $file1  = __DIR__.'/data/tmps/tmp.htaccess';
        $content1   = @file_get_contents($file1);
        $content1   = @str_replace("%FOLDER%",($this->sub_folder=='')?'/':$this->sub_folder,$content1);
        $creat1     = @file_put_contents('.htaccess',$content1);

        $file2  = __DIR__.'/data/tmps/config.tmp.php';
        $content2   = @file_get_contents($file2);
        $content2   = @str_replace("%FOLDER%",$this->sub_folder,$content2);
        $content2   = @str_replace("%ENC_KEY%", sha1((string)time()),$content2);
        $creat2     = @file_put_contents('application/config/config.php',$content2);

        $file3  = __DIR__.'/data/tmps/database.tmp.php';
        $content3   = @file_get_contents($file3);
        $content3   = @str_replace("%DB_HOST%",$this->db_hostname,$content3);
        $content3   = @str_replace("%DB_USERNAME%",$this->db_username,$content3);
        $content3   = @str_replace("%DB_PASSWORD%",$this->db_password,$content3);
        $content3   = @str_replace("%DB%",$this->db_name,$content3);
        $content3   = @str_replace("%PREFIX%",$this->db_prefix,$content3);
        $creat3     = @file_put_contents('application/config/database.php',$content3);

        $file4 = __DIR__.'/data/tmps/index.tmp.php';
        $content4   = @file_get_contents($file4);
        $creat4     = @file_put_contents('index.php', $content4);

    }

    private function update_site_settings(Schema $schema)
    {
        $settings = [
            ['option_name' => 'sitename', 'option_value' => $this->site_name],
            ['option_name' => 'email_from', 'option_value' => $this->support_email],
        ];

        foreach($settings as $setting)
        {
            $query = "UPDATE `".$this->db_prefix."settings` SET option_value=:option_value WHERE option_name=:option_name";
            $this->addSql($query, $setting);
        }
    }

    private function create_admin_account(Schema $schema)
    {
        $this->write('Creating Admin account...');
        $admin_pass_hashed  = password_hash($this->admin_pass, PASSWORD_DEFAULT);
        $user_token         = sha1(md5((string)time()));

        $admin_query = "INSERT INTO `".$this->db_prefix."users`
                    (id,username,email,password,gender,user_joined,user_status,user_token,user_verified,account_status)
                    VALUES (1,'$this->admin_name','$this->admin_email','$admin_pass_hashed',0,'$this->time',1,'$user_token','1',0)";

        $this->addSql($admin_query);
    }

    private function install_db(Schema $schema)
    {
        $this->write('Installing database...');

        $lines = file(__DIR__.'/data/db_tpl.sql');
        $SQL_queries = [];
        $tmp_query = '';

        $this->write('Parsing SQL queries...');
        foreach ($lines as $line)
        {
            $start = substr(trim($line), 0, 2);
            $end = substr(trim($line), -1, 1);

            if ($start == '--' || $start == ' ')
                continue;
            else
                $tmp_query .= $line;

            if ($end == ';')
            {
                $tmp_query = str_replace("{DBP}", $this->db_prefix, $tmp_query);
                $SQL_queries[] = $tmp_query;
                // clear tmp_query
                $tmp_query = '';
            }
        }

        $this->write('Executing SQL queries...');
        foreach($SQL_queries as $query)
        {
            $this->addSql($query);
        }
    }
}
