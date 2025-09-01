<?php namespace App\Models;

use CodeIgniter\Model;

class Gestion_Estado_Declaracion extends Model
{
    protected $table = 'gestion_estado_declaracion ';
    protected $primaryKey = 'idGestion_Estado_Declaracion';
    
    protected $allowedFields = [
       'idDeclaraciones_Impuestos', 'Fecha_Presentacion_Con_Pago', 'Fecha_Presentacion_Sin_Pago'];
    
    protected $useTimestamps = false;
    
}