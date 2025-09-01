<?php namespace App\Models;

use CodeIgniter\Model;

class Responsables_Fiscales extends Model
{
    protected $table = 'responsables_fiscales';
    protected $primaryKey = 'idResponsables_Fiscales';
    
    protected $allowedFields = [
        'Nombre_Apellidos_R_Legal', 'Nombres_Apellidos_Contador', 'Correo_Electronico_Contador', 'Nombres_Apellidos_R.Fiscal', 'Correo_Electronico_R.Fiscal'] ; 
    
    protected $useTimestamps = false;
    
}