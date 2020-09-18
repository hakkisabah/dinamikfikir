<?php namespace App\Controllers\Setup\Database\Migrations;

class UserContent
{
	public function up($forge)
	{

        $fields = [
            'content_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE,
            ],
            'old_title' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => TRUE,
            ],
            'title_image' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => FALSE,
            ],
            'content_images' => [
                'type' => 'TEXT',
                'null' => TRUE,
            ],
            'is_local_image' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => FALSE,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '40',
                'null' => FALSE,
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => FALSE,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
        ];
        $forge->addField($fields);
        $attributes = ['ENGINE' => 'InnoDB'];
        $forge->addKey('content_id', TRUE);
        $forge->addField("created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $forge->createTable('contents', TRUE,$attributes);
	}

}
