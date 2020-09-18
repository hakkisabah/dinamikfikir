<?php namespace App\Controllers\Setup\Database\Migrations;


class UserNotifications
{
    public function up($forge)
    {
        //
        $fields = [
            'notification_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'owner_user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'user_name' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'notification_where' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ],
            'notification_where_id' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ],
            'notification_field' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ],

            'notification_field_id' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ],
            'unread' => [
                'type' => 'TINYINT',
                'constraint' => '4',
                'default' => 1,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ];
        $forge->addField($fields);
        $attributes = ['ENGINE' => 'InnoDB'];
        $forge->addKey('notification_id', TRUE);
        $forge->addField("created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $forge->createTable('user_notifications', TRUE,$attributes);
    }

}
