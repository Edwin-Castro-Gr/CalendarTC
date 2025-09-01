<?php namespace App\Models;

use CodeIgniter\Model;

class Gestion_Calendario extends Model
{
    protected $table = 'gestion_calendario';
    protected $primaryKey = 'idGestion_Calendario';
    
    protected $allowedFields = [
        'idClientes', 'idDeclaraciones_Impuestos','Correo_Notificacion_1', 'Correo_Notificacion_2' ];
    
    protected $useTimestamps = false;
    
}