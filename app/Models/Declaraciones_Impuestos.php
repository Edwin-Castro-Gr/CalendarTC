<?php namespace App\Models;

use CodeIgniter\Model;

class Declaraciones_Impuestos extends Model
{
    protected $table = 'declaraciones_impuestos';
    protected $primaryKey = 'idDeclaracion';
    
    protected $allowedFields = [
       'Nombre'];
    
    protected $useTimestamps = false;
    
}