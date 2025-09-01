<?php namespace App\Models;

use CodeIgniter\Model;

class Gestion_Clientes extends Model
{
    protected $table = 'gestion_clientes';
    protected $primaryKey = 'idclientes';
    
    protected $allowedFields = [
       'Tipo_Persona', 'idTipo_Documento', 'N_Documento', 'Nombre_Empresa', 'Nombres_P_Natural','IdTipo_de_Contribuyente', 'idObligaciones_Tributarias', 'Direccion', 'Telefono', 'idCiudad'
    ];
    
    protected $useTimestamps = false;
    
}