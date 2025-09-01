<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\CIAuth;

class AdminController extends BaseController
{
    protected $helpers = ['url', 'form', 'TCEmail', 'CIFunctions']; 
    public function index()
    {
       $data = [
            'pageTitle' => 'Dashboard',
        ];

        return view('frontend/pages/home', $data);
    }

    public function logoutHandle(): ResponseInterface
    {
        // Perform logout logic here, such as clearing session data
        cIAuth::forget();
        
        // Redirect to the login page with a success message
        return redirect()->route('admin.login.form')
            ->with('fail', 'Has cerrado sesión correctamente.');
    }
    
}
