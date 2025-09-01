<?php namespace App\Models;

use CodeIgniter\Model;

class Obligaciones_Tributarias extends Model
{
    protected $table = 'obligaciones_tributarias';
    protected $primaryKey = 'idObligaciones_Tributarias';
    
    protected $allowedFields = [
        'nombre' ];
    
    protected $useTimestamps = false;
    
}