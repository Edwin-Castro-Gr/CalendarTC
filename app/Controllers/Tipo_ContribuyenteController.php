<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Tipo_ContribuyenteController extends BaseController
{
    public function index()
    {
        
        $data = [
            'pageTitle' => 'tipo_contribuyente',
        ];

        return view('frontend/pages/g_tipo_contribuyente', $data);
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

