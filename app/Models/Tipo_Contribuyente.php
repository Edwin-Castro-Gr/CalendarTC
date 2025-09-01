<?php namespace App\Models;

use CodeIgniter\Model;

class Tipo_Contribuyente extends Model
{
    protected $table = 'tipo_contribuyente';
    protected $primaryKey = 'idTipo_Contribuyente';
    
    protected $allowedFields = [
        'Nombre'] ; 
    
    protected $useTimestamps = false;
    
}