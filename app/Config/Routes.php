<?php

use CodeIgniter\Router\RouteCollection;

use App\Filters\CIFilter;
/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');

$routes->group('admin', static function ($routes) {
    $routes->group('', ['filter'=> 'cifilter:auth'], static function ($routes) {
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandle', ['as' => 'admin.logout']);
        $routes->get('roles', 'RolesController::index', ['as' => 'admin.roles']);
        $routes->get('usuarios', 'UserController::index', ['as' => 'admin.usuarios']);
        $routes->post('usuariosAgregar', 'UserController::agregarUsuario', ['as' => 'admin.usuarios.agregar']);
        $routes->get('clientes', 'ClientesController::index', ['as' => 'admin.clientes']);
        
    });
    $routes->group('', ['filter'=> 'cifilter:guest'], static function ($routes) {
        $routes->get('login', 'AuthController::loginform', ['as' => 'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'admin.forgot.form']);
        $routes->post('send-password-reset-link', 'AuthController::sendPasswordResetLink', ['as' => 'send_password_reset_link']);
        $routes->get('reset-password/(:any)', 'AuthController::resetPasswordForm/$1', ['as' => 'admin.reset-password']);
        $routes->post('reset-password-handler/(:any)', 'AuthController::resetPasswordHandler/$1', ['as' => 'reset-password.handler']);
    });
    $routes->group('', [], static function ($routes) {
        $routes->view('example-404', 'example-404');
    });
});