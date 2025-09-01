<?php namespace App\Models;

use CodeIgniter\Model;

class Gestion_Perfil extends Model
{
    protected $table = 'gestion_perfil';
    protected $primaryKey = 'idGestion_Perfil';
    
    protected $allowedFields = [
       'Nombre'];
    
    protected $useTimestamps = false;
    
}