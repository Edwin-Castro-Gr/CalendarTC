<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'=> true,
                'auto_increment' => true,
            ],
            'usuario' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'apellido' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'unique' => true,
            ],
            'correo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],            
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'rol' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'usuario'],
                'default' => 'usuario',
            ],
            'estado' => [
                'type' => 'ENUM',
                'constraint' => ['activo', 'inactivo'],
                'default' => 'activo',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);
        $this->forge->addKey('id', true ); // Primary key
        $this->forge->createTable('usuarios', true); // Create the table
    }

    public function down()
    {
        $this->forge->dropTable('usuarios', true); // Drop the table if it exists
    }
}
