<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\User;
use Config\Services;

use SSP;

class Usercontroller extends BaseController
{
    protected $helpers = ['url', 'form', 'TCEmail', 'CIFunctions'];
    protected $db;
    public function __construct()
    {
        require_once APPPATH . 'ThirdParty/ssp.php';
        $this->db = db_connect();
    }
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
                'usuario' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'El campo usuario es obligatorio.']
                ],
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
                    'rules' => 'required|min_length[5]|max_length[20]|IsPasswordStrong[nuevo_password]',
                    'errors' => [
                        'required' => 'El campo contrasena es obligatorio.',
                        'min_length' => 'El campo contrasena debe tener al menos 5 caracteres.',
                        'max_length' => 'El campo contrasena no puede exceder los 20 caracteres.',
                        'IsPasswordStrong' => 'La contraseña debe contener al menos un número, una letra mayúscula y un carácter especial.',
                    ]
                ],
                'confirmar_password' => [
                    'rules' => 'required|matches[nuevo_password]',
                    'errors' => [
                        'required' => 'El campo confirmar contrasena es obligatorio.',
                        'matches' => 'El campo confirmar contrasena debe coincidir con la Nueva Contraseña.',
                    ]
                ]
            ]);
            if ($validation->run() === FALSE) {
                $errores = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'errors' => $errores
                ]);
            } else {
                //return $this->response->setJSON(['status' => 1,'token' => csrf_hash(),'msg' => 'Usuario Validado']);
                $userModel = new User();
                $identificacion = $this->request->getPost('identificacion');
                $nombreUsuario = $this->request->getPost('nombreUsuario');
                $apellidoUsuario = $this->request->getPost('apellidoUsuario');
                $perfilUsuario = $this->request->getPost('perfilUsuario');
                $correoUsuario = $this->request->getPost('correoUsuario');
                $contrasenaUsuario = $this->request->getPost('contrasenaUsuario');
                $data = [
                    'usuario' => $nombreUsuario . ' ' . $apellidoUsuario,
                    'identificacion' => $identificacion,
                    'nombre_usuario' => $nombreUsuario,
                    'apellido_usuario' => $apellidoUsuario,
                    'rol' => $perfilUsuario,
                    'correo_usuario' => $correoUsuario,
                    'password' => password_hash($contrasenaUsuario, PASSWORD_DEFAULT),
                    'estado' => 1
                ];
                $userModel->save($data);
                $insertedId = $userModel->getInsertID();
                if ($insertedId) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => 'Usuario agregado exitosamente.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'No se pudo agregar el usuario. Inténtalo de nuevo.'
                    ]);
                }
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'No se puede procesar la solicitud.'
            ]);
        }
    }
    public function getUsuarios()
    {
        // Obtener configuración de base de datos desde Config\Database
        $dbConfig = new \Config\Database();
        $def = $dbConfig->default;

        // Adaptar según estructura (array u objeto)
        $hostname = is_array($def) ? ($def['hostname'] ?? 'localhost') : ($def->hostname ?? 'localhost');
        $database = is_array($def) ? ($def['database'] ?? '') : ($def->database ?? '');
        $username = is_array($def) ? ($def['username'] ?? '') : ($def->username ?? '');
        $password = is_array($def) ? ($def['password'] ?? '') : ($def->password ?? '');
        $port     = is_array($def) ? ($def['port'] ?? 3306) : ($def->port ?? 3306);

        $dbDetalle = [
            'host' => $hostname,
            'db'   => $database,
            'user' => $username,
            'pass' => $password,
            'port' => $port,
            'charset' => 'utf8'
        ];

        $table = 'usuarios';
        $primaryKey = 'id';

        // Ajusta los nombres de columna según tu tabla real
        $columns = [
            ['db' => 'id',      'dt' => 0],
            ['db' => 'nombre_usuario',  'dt' => 1],
            ['db' => 'correo_usuario',  'dt' => 2],
            ['db' => 'estado',          'dt' => 3, 'formatter' => function($d, $row){
                return $d == 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
            }],
            // columna de acciones: usamos formatter para generar HTML (no hace falta columna en la BD)
            ['db' => 'id',      'dt' => 4, 'formatter' => function($d, $row){
                return '<div class="btn-group"><button class="btn btn-sm btn-link p-0 mx-1 modificarUsuariosbtn" data-id="'.$d.'">Editar</button><button class="btn btn-sm btn-link p-0 mx-1 eliminarUsuariosbtn" data-id="'.$d.'">Eliminar</button></div>';
            }],
            // columna de ordering: usamos formatter para devolver el ID (no hace falta columna en la BD)
            ['db' => 'id',      'dt' => 5, 'formatter' => function($d, $row){
                return $d; // simplemente devolvemos el ID para usarlo en ordering
            }],
        ];

        // Llamada a SSP (simple)
        try {
            $output = SSP::simple($_GET, $dbDetalle, $table, $primaryKey, $columns);
            return $this->response->setJSON($output);
        } catch (\Throwable $e) {
            log_message('error', 'getUsuarios SSP error: ' . $e->getMessage());
            // devolver estructura de error compatible con DataTables
            return $this->response->setJSON([
                'draw' => intval($_GET['draw'] ?? 0),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Error al conectar a la base de datos. Revisa logs.'
            ]);
        }
    }
    public function getUsuario()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $id_usuario = $this->request->getGet('id');
           
            $userModel = new User();
            $usuario = $userModel->find($id_usuario);
            if ($usuario) {
                return $this->response->setJSON([
                    'status' => 1,
                    'data' => $usuario
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Usuario no encontrado.'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'No se puede procesar la solicitud.'
            ]);
        }
    }

    public function actualizarUsuario()
    {
        $request = Services::request();
        if ($request->isAJAX()) {
            $validation = Services::validation();
           $this->validate([
                'musuario' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'El campo usuario es obligatorio.']
                ],
                'midentificacion' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'La campo identificación es obligatorio.']
                ],
                'mnombreUsuario' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'El campo nombre de usuario es obligatorio.']
                ],
                'mapellidoUsuario' => [
                    'rules' => 'required',
                    'errors' => ['required' => 'El campo apellidos de usuario es obligatorio.']
                ],
                'mperfilUsuario' => [
                    'rules' => 'required|in_list[1,2]',
                    'errors' => ['required' => 'El campo perfil es obligatorio.']
                ],
                'mcorreoUsuario' => [
                    'rules' => 'required|valid_email',

                    'errors' => [
                        'required' => 'El campo correo electrónico es obligatorio.',
                        'valid_email' => 'El campo correo electrónico debe ser un correo electrónico válido.'
                    ]
                ],
                'mcontrasenaUsuario' => [
                    'rules' => 'required|min_length[5]|max_length[20]|IsPasswordStrong[mcontrasenaUsuario]',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.',
                        'min_length' => 'El campo {field} debe tener al menos 5 caracteres.',
                        'max_length' => 'El campo {field} no puede exceder los 20 caracteres.',
                        'IsPasswordStrong' => 'La contraseña debe contener al menos un número, una letra mayúscula y un carácter especial.',
                    ]
                ],
                'mconfirmarContrasenaUsuario' => [
                    'rules' => 'required|matches[mcontrasenaUsuario]',
                    'errors' => [
                        'required' => 'El campo {field} es obligatorio.',
                        'matches' => 'El campo {field} debe coincidir con la Nueva Contraseña.',
                    ]
                ]
            ]);
            if ($validation->run() === FALSE) {
                $errores = $validation->getErrors();
                return $this->response->setJSON([
                    'status' => 0,
                    'token' => csrf_hash(),
                    'errors' => $errores
                ]);
            } else {
                //return $this->response->setJSON(['status' => 1,'token' => csrf_hash(),'msg' => 'Usuario Validado']);
                $userModel = new User();
                $identificacion = $this->request->getPost('midentificacion');
                $usuario = $this->request->getPost('musuario');
                $nombreUsuario = $this->request->getPost('mnombreUsuario');
                $apellidoUsuario = $this->request->getPost('mapellidoUsuario');
                $perfilUsuario = $this->request->getPost('mperfilUsuario');
                $correoUsuario = $this->request->getPost('mcorreoUsuario');
                $contrasenaUsuario = $this->request->getPost('mcontrasenaUsuario');
                $data = [
                    'usuario' => $usuario,
                    'identificacion' => $identificacion,
                    'nombre_usuario' => $nombreUsuario,
                    'apellido_usuario' => $apellidoUsuario,
                    'rol' => $perfilUsuario,
                    'correo_usuario' => $correoUsuario,
                    'password' => password_hash($contrasenaUsuario, PASSWORD_DEFAULT),
                    'estado' => 1
                ];
                $userModel->update($data);
                $update = $userModel->where('id', $usuario)->set($data)->update();

                if ($update) {
                    return $this->response->setJSON([
                        'status' => 1,
                        'token' => csrf_hash(),
                        'msg' => 'Usuario actualizado exitosamente.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'status' => 0,
                        'token' => csrf_hash(),
                        'msg' => 'No se pudo actualizar el usuario. Inténtalo de nuevo.'
                    ]);
                }
            }
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'msg' => 'No se puede procesar la solicitud.'
            ]);
        }
    }

}

