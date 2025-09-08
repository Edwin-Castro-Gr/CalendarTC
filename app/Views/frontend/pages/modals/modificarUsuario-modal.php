<div class="modal fade" id="modificaUsuario-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    style="display: none;" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="<?= route_to('admin.usuarios.actualizar') ?>" method="post" id="modificarUsuario_form">
            <div class="modal-header">
                <h5 class="modal-title">Modificar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <input class="ci_csrf_data" type="hidden" name="<?= csrf_token()?>" value="<?= csrf_hash()?>">
                <div class="form-group row">
                    <input type="hidden" name="mid_usuario" id="mid_usuario"></input>
                    <div class="col-sm-6">
                        <label class="form-label" for="midentificacion">identificación</label>
                        <input type="text" class="form-control" id="midentificacion" name="midentificacion"
                            placeholder="Ingrese su identificación" required>
                        <span class="text-danger error-text midentificacion_error"></span>
                    </div>
                    <div class="col-sm-6">
                        <label class="" for="musuario">Usuario</label>
                        <input type="text" class="form-control" id="musuario" name="musuario"
                            placeholder="Ingrese su nombre de usuario" required>
                        <span class="text-danger error-text musuario_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="" for="mnombreUsuario">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="mnombreUsuario" name="mnombreUsuario"
                            placeholder="Ingrese su nombre de usuario" required>
                        <span class="text-danger error-text mnombreUsuario_error"></span>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="mapellidoUsuario">Apellidos de Usuario</label>
                        <input type="text" class="form-control" id="mapellidoUsuario" name="mapellidoUsuario"
                            placeholder="Ingrese sus apellidos de usuario" required>
                        <span class="text-danger error-text mapellidoUsuario_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label" for="mperfilUsuario">Perfil</label>
                        <select class="form-control" id="mperfilUsuario" name="mperfilUsuario"
                            placeholder="Seleccione un perfil" required>
                            <option value="">Seleccione un perfil</option>
                            <option value="1">Administrador</option>
                            <option value="2">Usuario</option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="mcorreoUsuario">Correo Electrónico</label>
                        <input type="email" class="form-control" id="mcorreoUsuario" name="mcorreoUsuario"
                            placeholder="Ingrese su correo electrónico" required>
                        <span class="text-danger error-text mcorreoUsuario_error"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label" for="mcontrasenaUsuario">Contraseña</label>
                        <input type="password" class="form-control" id="mcontrasenaUsuario" name="mcontrasenaUsuario"
                            placeholder="Ingrese su contraseña" required>
                        <span class="text-danger error-text mcontrasenaUsuario_error"></span>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label" for="mconfirmarContrasenaUsuario">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="mconfirmarContrasenaUsuario"
                            name="mconfirmarContrasenaUsuario" placeholder="Confirme su contraseña" required>
                        <span class="text-danger error-text mconfirmarContrasenaUsuario_error"></span>
                    </div>
                </div>
            
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label" for="mestado">Estado</label>
                        <select class="form-control" id="mestado" name="mestado"
                            placeholder="Seleccione un estado" required>
                            <option value="">Seleccione un estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModificarUsuarioModal">
                    Cerrar
                </button>
                <button type="button" class="btn btn-primary" id="btnActualizarUsuario">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>