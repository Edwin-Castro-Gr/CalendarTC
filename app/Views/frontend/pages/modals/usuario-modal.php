<div class="modal fade" id="nuevoUsuario-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= route_to('admin.usuarios.agregar')?>" method="post"
            id="agregarUsuario_form">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel"> 
                Crear Nuevo Usuario
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    ×
                </button>
            </div>
            <div class="modal-body">
                <input class="ci_csrf_data" type="hidden" name="<?= csrf_token()?>" value="<?= csrf_hash()?>">
                <div class="form-group row">
                    <input type="hidden" name="id_usuario" id="id_usuario"></input>
                    <div class="col-sm-6">
                        <label class="form-label" for="identificacion">identificación</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion"
                            placeholder="Ingrese su identificación" required>
                        <span class="text-danger error-text identificacion_error"></span>
                    </div>
                    <div class="col-sm-6">
                        <label class="" for="usuario">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario"
                            placeholder="Ingrese su nombre de usuario" required>
                        <span class="text-danger error-text usuario_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="" for="nombreUsuario">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario"
                            placeholder="Ingrese su nombre de usuario" required>
                        <span class="text-danger error-text nombreUsuario_error"></span>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="apellidoUsuario">Apellidos de Usuario</label>
                        <input type="text" class="form-control" id="apellidoUsuario" name="apellidoUsuario"
                            placeholder="Ingrese sus apellidos de usuario" required>
                        <span class="text-danger error-text apellidoUsuario_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label" for="perfilUsuario">Perfil</label>
                        <select class="form-control" id="perfilUsuario" name="perfilUsuario"
                            placeholder="Seleccione un perfil" required>
                            <option value="">Seleccione un perfil</option>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="correoUsuario">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correoUsuario" name="correoUsuario"
                            placeholder="Ingrese su correo electrónico" required>
                        <span class="text-danger error-text correoUsuario_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label" for="contrasenaUsuario">Contraseña</label>
                        <input type="password" class="form-control" id="contrasenaUsuario" name="contrasenaUsuario"
                            placeholder="Ingrese su contraseña" required>
                        <span class="text-danger error-text contrasenaUsuario_error"></span>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="confirmarContrasenaUsuario">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="confirmarContrasenaUsuario"
                            name="confirmarContrasenaUsuario" placeholder="Confirme su contraseña" required>
                        <span class="text-danger error-text confirmarContrasenaUsuario_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-primary" id="btnGuardarUsuario">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>