<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use Config\Services;

class Usercontroller extends BaseController
{
    protected $helpers = ['url', 'form', 'TCEmail', 'CIFunctions'];
    public function index()
    {
        $data = [
            'pageTitle' => 'Usuarios',
        ];
        return view('frontend/pages/g_usuarios', $data);
    }

    public function agregarUsuario()    
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $validation = Services::validation();
            $this->validate([
                'identificacion' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'La campo identificación es obligatorio.']
                ],
                'nombreUsuario' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'El campo nombre de usuario es obligatorio.']
                ],
                'apellidoUsuario' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'El campo apellidos de usuario es obligatorio.']
                ],
                'perfilUsuario' => [
                    'rules' => 'required|in_list[1,2]',
                    'errors' => ['required' => 'El campo perfil es obligatorio.']
                ],
                'correoUsuario' => [
                    'rules' => 'required|valid_email',

                    'errors' => [
                        'required' => 'El campo correo electrónico es obligatorio.',
                        'valid_email' => 'El campo correo electrónico debe ser un correo electrónico válido.'
                    ]
                ],
                'contrasenaUsuario' => [
                    'rules' => 'required|min_length[6]|max_length[25]',
                    'errors' => [
                        'required' => 'El campo contraseña es obligatorio.',
                        'min_length' => 'El campo contraseña debe tener al menos 6 caracteres.',
                        'max_length' => 'El campo contraseña no puede exceder los 25 caracteres.'
                    ]
                ],
            ]);
            if ($validation->run() === FALSE) {
                $errores = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'errors' => $errores
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 1,
                    'token' => csrf_hash(),
                    'msg' => 'Usuario Validado'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'No se puede procesar la solicitud.'
            ]);
        }
    }
}

