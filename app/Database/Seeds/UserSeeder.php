<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            
                'usuario' => 'usuario_admin1',
                'identificacion' => '1234567890',
                'nombre_usuario' => 'Admin',
                'apellido_usuario' => 'Sistemas',
                'correo_usuario' => 'castonino17@gmail.com',                
                'password' => password_hash('Admin123', PASSWORD_DEFAULT),
                'rol' => '1',
                'estado' => '1',
                 
        ]; 
        
        $this->db->table('usuarios')->insert($data);
    }
}
