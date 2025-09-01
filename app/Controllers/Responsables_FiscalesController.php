<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Responsables_FiscalesController extends BaseController
{
    public function index()
    {
        
        $data = [
            'pageTitle' => 'responsables_fiscales',
        ];

        return view('frontend/pages/g_responsables_fiscales', $data);
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

