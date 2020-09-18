<?php namespace App\Controllers\Setup\Database\Migrations;


class UserTable
{
    public function up($forge)
    {
        $fields = [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ],
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => FALSE,
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => FALSE,
            ],
            'user_email' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => FALSE,
            ],
            'last_login_date' => [
                'type' => 'DATETIME',
                'null' => FALSE,
            ],
            'email_status' => [
                'type' => 'TINYINT',
                'constraint' => '4',
                'default' => 0,
                'null' => FALSE,
            ],
            'activation_code'=>[
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'suspended'=>[
                'type' => 'TINYINT',
                'null' => FALSE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'user_password' => [
                'type' => 'TEXT',
                'constraint' => '225',
                'null' => FALSE,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'default' => 'user',
                'null' => FALSE,
            ],
            'icon_name' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'blank.svg',
                'null' => FALSE,
            ],
        ];
        $forge->addField($fields);
       // $attributes = ['ENGINE' => 'InnoDB DEFAULT CHARSET=utf8_general_ci'];
        $forge->addKey('user_id', TRUE);
        $forge->addField("created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $forge->createTable('users', TRUE);
    }
}