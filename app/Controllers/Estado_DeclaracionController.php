<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Estado_DeclaracionController extends BaseController
{
    public function index()
    {
        
        $data = [
            'pageTitle' => 'Estado_Declaracion',
        ];

        return view('frontend/pages/g_estado_declaracion', $data);
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

