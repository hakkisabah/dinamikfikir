<?php namespace App\Controllers\Setup\Database\Migrations;


class IpTables
{
    public function up($forge)
    {
        $fields = [
            'ip_id' => [
                'type' => 'INT',
                'constraint' => 50,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'ip_address' => [
                'type' => 'VARBINARY',
                'constraint' => 16,
                'null' => FALSE,
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => TRUE,
            ],
            'user_device_info' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => TRUE,
            ],
            'end_point' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => FALSE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'cookie_consent' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ],
        ];
        $forge->addField($fields);
        $attributes = ['ENGINE' => 'InnoDB'];
        $forge->addKey('ip_id', TRUE);
        $forge->addField("created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $forge->createTable('ip_tables', TRUE,$attributes);
    }

}
