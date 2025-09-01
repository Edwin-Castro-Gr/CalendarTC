<?php namespace App\Models;

use CodeIgniter\Model;

class Ciudades extends Model
{
    protected $table = 'ciudades';
    protected $primaryKey = 'idciudad';
    
    protected $allowedFields = [
       'Codigo_Dane', 'Nombre','Nombre_Pais'];
    
    protected $useTimestamps = false;
    
}