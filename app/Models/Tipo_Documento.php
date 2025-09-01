<?php namespace App\Models;

use CodeIgniter\Model;

class Tipo_Documento extends Model
{
    protected $table = 'tipo_documento';
    protected $primaryKey = 'idTipo_Documento';
    
    protected $allowedFields = [
        'Prefijo', 'Nombre'] ; 
    
    protected $useTimestamps = false;
    
}