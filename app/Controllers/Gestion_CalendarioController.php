<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Gestion_CalendarioController extends BaseController
{
    public function index()
    {
        
        $data = [
            'pageTitle' => 'gestion_calendario',
        ];

        return view('frontend/pages/g_gestion_calendario', $data);
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

