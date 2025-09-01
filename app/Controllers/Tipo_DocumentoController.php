<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tipo_DocumentoController extends BaseController
{
    public function index()
    {
        
        $data = [
            'pageTitle' => 'tipo_documento',
        ];

        return view('frontend/pages/g_tipo_documento', $data);
    }

    public function show($id)
    {
        // Logic to fetch user by ID
        return view('rol_detail', ['id' => $id]);
    }

    public function create()
    {
        // Logic to create a new user
        return view('rol_create');
    }
}

