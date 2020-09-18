<?php namespace App\Controllers\Setup\Database\Migrations;



class Comments
{
    public function up($forge)
    {
        $fields = [
            'comment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => FALSE
            ],
            'content_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => TRUE,
            ],
            'deleted_comment' => [
                'type' => 'TEXT',
                'null' => TRUE
            ],
        ];
        $forge->addField($fields);
        $attributes = ['ENGINE' => 'InnoDB'];
        $forge->addKey('comment_id', TRUE);
        $forge->addField("created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
        $forge->createTable('comments', TRUE,$attributes);
    }

}
