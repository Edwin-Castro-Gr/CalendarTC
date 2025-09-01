<?php namespace App\Models;

use CodeIgniter\Model;

class Gestion_Vigencia extends Model
{
    protected $table = 'Gestion_Vigencia';
    protected $primaryKey = 'idGestion_Vigencia';
    
    protected $allowedFields = [
       'idDeclaracion', 'Año','Mes','Dia','Ultimo_Digito_NIT' ];
    
    protected $useTimestamps = false;
    
}