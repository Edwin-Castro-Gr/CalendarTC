<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'TCEmail', 'CIFunctions'];

    public function loginform()
    {
        return view('frontend/pages/auth/login', [
            'pageTitle' => 'Login',
            'validation' => null,
        ]);
    }

    public function loginHandler()
    {
        $username = $this->request->getVar('username');

        $password = $this->request->getVar('password');

        $isEmail = filter_var($username, FILTER_VALIDATE_EMAIL);
        $fieldType = $isEmail ? 'correo_usuario' : 'usuario';

        $rules = [
            'username' => [
                'rules' => "required|is_not_unique[usuarios.$fieldType]",
                'errors' => [
                    'required' => 'El campo es obligatorio.',
                    'is_not_unique' => $isEmail
                        ? 'El Email ingresado no existe en nuestros registros.'
                        : 'El Usuario ingresado no existe en nuestros registros.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]|max_length[45]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'min_length' => 'El campo {field} debe tener al menos 6 caracteres.',
                    'max_length' => 'El campo {field} no puede exceder los 45 caracteres.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return view('frontend/pages/auth/login', [
                'pageTitle' => 'Login',
                'validation' => $this->validator,
            ]);
        }else{
            $userModel = new User();
            $userdata = $userModel->where($fieldType, $username)->first();
            
            if ($userdata['estado'] == "0") {
                return redirect()->route('admin.login.form')->with('fail', 'El usuario se encuentra inactivo.')->withInput();
            }else{
                
                $check_password = Hash::check($this->request->getVar('password'), $userdata['password']);

                if (!$check_password) {
                    return redirect()->route('admin.login.form')->with('fail', 'Contraseña incorrecta.')->withInput();
                }else{
                    CIAuth::setCIAuth($userdata);
                    return redirect()->route('admin.home');
                }
            }
        }
    }

    public function forgotForm()
    {
        return view('frontend/pages/auth/forgot', [
            'pageTitle' => 'Recuperar Contraseña',
            'validation' => null,
        ]);
    }

    public function sendPasswordResetLink()
    {
        $email = $this->request->getVar('email');
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email|is_not_unique[usuarios.correo_usuario]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'valid_email' => 'El campo {field} debe ser un correo electrónico válido.',
                    'is_not_unique' => 'El Email ingresado no existe en nuestros registros.' // Corregido el mensaje
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return view('frontend/pages/auth/forgot', [
                'pageTitle' => 'Recuperar Contraseña',
                'validation' => $this->validator,
            ]);
        }else{

            $usuario = new User();
            $user_info = $usuario->asObject()->where('correo_usuario', $this->request->getVar('email'))->first();

            // if (!$user_info) {
            //     return redirect()->route('admin.forgot.form')->with('fail', 'El Email ingresado no existe.')->withInput();
            // }

            // Generar token
            $token = bin2hex(random_bytes(32)); // Más seguro que openssl_random_pseudo_bytes
            
            $passwordResetToken = new PasswordResetToken();
            $isOldToken = $passwordResetToken->where('email', $user_info->correo_usuario)->first();
            if ($isOldToken) {
                // Si ya existe un token, reutilizarlo y actualizar la fecha de creación

                $passwordResetToken->where('email', $user_info->correo_usuario)->set([
                    'token' => $token,
                    'created_at' => Carbon::now()->addMinutes(30)->toDateTimeString()
                ])->update();
            }else{
                 // Insertar nuevo token
                $passwordResetToken->insert([
                    'email' => $user_info->correo_usuario,
                    'token' => $token,
                    'created_at' => Carbon::now()->addMinutes(30)->toDateTimeString()
                ]);
            }

            $actionLink = base_url(route_to('admin.reset-password', $token));

            $mail_data = ['actionLink' => $actionLink, 'user' => $user_info];
            
            $view = \Config\Services::renderer();

            $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/forgot-email-template');

            $mailConfig = [
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_to' => $user_info->correo_usuario,
                'mail_toName' => $user_info->nombre_usuario,
                'mail_subject' => 'Restablecer la contraseña de su cuenta',
                'mail_body' => $mail_body
            ];

            // Debug: Verificar configuración
            log_message('debug', 'Configuración de email: ' . print_r([
                'from' => $mailConfig['mail_from_email'],
                'to' => $mailConfig['mail_to'],
                'host' => env('EMAIL_HOST')
            ], true));
            
            if (sendEmail($mailConfig)) {
                return redirect()->route('admin.forgot.form')->with('success', 'Se ha enviado un enlace de restablecimiento de contraseña a su correo electrónico.');
            } else {
                return redirect()->route('admin.forgot.form')->with('fail', 'Error al enviar el correo electrónico. Inténtalo de nuevo más tarde.');
            }
        }
    }
    public function resetPasswordForm($token)
    {
        $passwordResetToken = new PasswordResetToken();
        $tokenData = $passwordResetToken->where('token', $token)->first();

        if (!$tokenData) {
            return redirect()->route('admin.forgot.form')->with('fail', 'El enlace de restablecimiento de contraseña no es válido o ha expirado.');
        }

        // Verificar si el token ha expirado
        $createdAt = new Carbon($tokenData['created_at']);
        if (Carbon::now()->greaterThan($createdAt)) {
            // Eliminar el token expirado
            $passwordResetToken->where('token', $token)->delete();
            return redirect()->route('admin.forgot.form')->with('fail', 'El enlace de restablecimiento de contraseña ha expirado. Por favor, solicite un nuevo enlace.');
        }

        return view('frontend/pages/auth/reset_password', [
            'pageTitle' => 'Restablecer Contraseña',
            'validation' => null,
            'token' => $token
        ]);
    }
    public function resetPasswordHandler($token)
    {
       $isValid = $this->validate([
            
            'nuevo_password' => [
                'rules' => 'required|min_length[5]|max_length[20]|IsPasswordStrong[nuevo_password]',                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'min_length' => 'El campo {field} debe tener al menos 6 caracteres.',
                    'max_length' => 'El campo {field} no puede exceder los 20 caracteres.',
                    'IsPasswordStrong' => 'La contraseña debe contener al menos un número, una letra mayúscula y un carácter especial.',
                ]
            ],
            'confirmar_password' => [
                
                'rules' => 'required|matches[nuevo_password]',
                'errors' => [
                    'required' => 'El campo {field} es obligatorio.',
                    'matches' => 'El campo {field} debe coincidir con la Nueva Contraseña.',
                ]
            ]
        ]);

        if (!$isValid) {
            return view('frontend/pages/auth/reset_password', [
                'pageTitle' => 'Restablecer Contraseña',
                'validation' => null,
                'token' => $token,
            ]);
        } else {
            $passwordResetToken = new PasswordResetToken();
            $tokenData = $passwordResetToken->where('token', $token)->first();

            //Get user associated with the token
            $userModel = new User();
            $user_info = $userModel->asObject()->where('correo_usuario', $tokenData['email'])->first();

            if (!$tokenData) {
                return redirect()->back()->with('fail', 'El enlace de restablecimiento de contraseña no es válido o ha expirado.');
            }else{
                // Actualizar la contraseña (usar propiedad ->correo_usuario porque $user_info es objeto)
                $newPassword = $this->request->getVar('nuevo_password');
                //var_dump(password_hash($this->request->getVar('nuevo_password'), PASSWORD_DEFAULT));exit;
                $userModel->where('correo_usuario', $user_info->correo_usuario)
                        ->set(['password' => Hash::make($this->request->getVar('nuevo_password'))])
                        ->update();

                // Enviar notificación al correo del usuario sobre el restablecimiento de la contraseña.
                $mail_data = array(
                    'user' => $user_info,
                    'nueva_contraseña' => $this->request->getVar('nuevo_password')
                );

                $view =  \config\Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/email_reset_password');

                $mailconfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_to' => $user_info->correo_usuario,
                    'mail_toName' => $user_info->nombre_usuario,
                    'mail_subject' => 'Su contraseña ha sido restablecida',
                    'mail_body' => $mail_body
                );
                if(sendEmail($mailconfig)){
                    //Eliminar el token después de restablecer la contraseña
                    $passwordResetToken->where('token', $token)->delete();

                    return redirect()->route('admin.login.form')->with('success', 'Su contraseña ha sido restablecida con éxito. Ahora puede iniciar sesión con su nueva contraseña.');
                }else{
                    return redirect()->back()->with('fail', 'Error al enviar el correo de restablecimiento de contraseña.')->withInput();
                }
            }
        }
    }
}
