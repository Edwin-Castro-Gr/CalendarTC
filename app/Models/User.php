<?php namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'usuario', 'identificacion', 'nombre_usuario', 'apellido_usuario',
        'correo_usuario', 'password', 'rol', 'estado'  
    ];
    
    protected $useTimestamps = true; // Cambia a true para usar created_at y updated_at
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}