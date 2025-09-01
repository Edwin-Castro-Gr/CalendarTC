<?php namespace App\Models;

use CodeIgniter\Model;

class Estado_Declaracion extends Model
{
    protected $table = 'estado_declaracion';
    protected $primaryKey = 'idEstado_Declaracion';
    
    protected $allowedFields = [
       'Nombre'];
    
    protected $useTimestamps = false;
    
}