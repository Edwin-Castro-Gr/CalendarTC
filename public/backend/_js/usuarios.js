$(function () {
    const $btnGuardar = $('#btnGuardarUsuario');
    const $modal = $('#nuevoUsuario-modal');
    const $form = $('#agregarUsuario_form');
    const $formEditar = $('#modificarUsuario_form');
    const $btnActualizarUsuario = $('#btnActualizarUsuario');

    // Abrir modal Nuevo Usuario
    $('#btnNuevoUsuario').on('click', function () {
        $modal.modal('show');
    });

    // abrir modal Modificar Usuario
    $(document).on('click', '.modificarUsuariosbtn', function (e) {
        e.preventDefault();
        var idUsuario = $(this).data('id');
        //alert(idUsuario);
        // Aquí puedes hacer una llamada AJAX para obtener los datos del usuario y llenar el formulario si es necesario
        var url = (typeof GET_USUARIO_URL !== 'undefined') ? GET_USUARIO_URL : '/admin/get-usuario';
        $.get(url, { id: idUsuario }, function (response) {
            var modal_title = 'Modificar Usuario';
            var modal_btn_text = 'Guardar Cambios';
            var modal = $("body").find('#modificaUsuario-modal');
            modal.find('form').find('input[type="hidden"][name="mid_usuario"]').val(idUsuario);
            modal.find('.modal-title').text(modal_title);
            modal.find('#btnActualizarUsuario').text(modal_btn_text);
            modal.find("#musuario").val(response.data.usuario);
            modal.find("#midentificacion").val(response.data.identificacion);
            modal.find("#mnombreUsuario").val(response.data.nombre_usuario);
            modal.find("#mapellidoUsuario").val(response.data.apellido_usuario);
            modal.find("#mcorreoUsuario").val(response.data.correo_usuario);
            modal.find("#mperfilUsuario").val(response.data.rol);
            modal.find("#mestado").val(response.data.estado);
            modal.modal('show');
        }, 'json').fail(function (xhr, status, error) {
            console.error('Error al obtener datos del usuario:', status, error, xhr.responseText);
            toastr.error('No se pudieron cargar los datos del usuario. Inténtalo de nuevo.');
        });
    });

    // Enviar formulario via AJAX
    $btnGuardar.on('click', function (e) {
        e.preventDefault();

        if (!$form.length) {
            console.warn('Formulario agregarUsuario_form no encontrado.');
            return;
        }

        // Limpiar errores anteriores
        $form.find('.text-danger, span.error-text').text('');
        $form.find('.brc-danger').removeClass('brc-danger');
        $btnGuardar.prop('disabled', true);

        const csrfInput = $form.find('.ci_csrf_data');
        const csrf_token = csrfInput.attr('name') || ''; // nombre del token CSRF
        const csrf_hash = csrfInput.val() || '';        // valor del token CSRF

        const formEl = document.getElementById("agregarUsuario_form");
        const formData = new FormData(formEl);

        if (csrf_token && csrf_hash) {
            formData.append(csrf_token, csrf_hash);
        }

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                toastr.remove(); // Limpiar notificaciones previas
                $form.find('.text-danger, span.error-text').text('');
                $form.find('.brc-danger').removeClass('brc-danger');
            },
            success: function (response) {
                // Actualizar token CSRF si viene en la respuesta
                csrfInput.val(response.token);
                
                // Manejo seguro de respuesta/errores
                const fieldErrors = response && (response.error || response.errors || response.validation) || null;

                if (!fieldErrors) {
                    if (response && response.status === 1) {
                        $form[0].reset();
                        $modal.modal('hide');
                        toastr.success(response.msg || 'Operación exitosa');
                        // emitir evento para refrescar tablas si se escucha
                        $(document).trigger('usuario:guardado', [response]);
                    } else {
                        toastr.error(response && response.msg ? response.msg : 'Error en la operación');
                    }
                } else {
                    // Mostrar errores por campo
                    $.each(fieldErrors, function (field, value) {
                        const $field = $form.find('[name="' + field + '"], #' + field);
                        if ($field.length) {
                            $field.addClass("brc-danger");
                            const $errSpan = $field.closest('.col-sm-6').find('span.error-text');
                            if ($errSpan.length) {
                                $errSpan.html(Array.isArray(value) ? value.join('<br>') : value);
                            } else {
                                toastr.warning(Array.isArray(value) ? value.join('<br>') : value);
                            }
                        } else {
                            toastr.warning(Array.isArray(value) ? value.join('<br>') : value);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error, xhr.responseText);
                toastr.error('Error en la petición: ' + (xhr.responseJSON && xhr.responseJSON.msg ? xhr.responseJSON.msg : xhr.statusText || status));
            },
            complete: function () {
                $btnActualizarUsuario.prop('disabled', false);
            }
        });
    });

    //retrieve usuarios
    var usuariosTable = $('#usuarios-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: (typeof GET_USUARIOS_URL !== 'undefined') ? GET_USUARIOS_URL : '/admin/get-usuarios',
            type: 'GET'
        },
        dom: "Bfrtip",
        info: true,
         createdRow: function (row, data, dataIndex) {
            // calcular índice considerando paginación
            var pageInfo = $('#usuarios-table').DataTable().page.info();
            var index = (pageInfo && pageInfo.start !== undefined) ? pageInfo.start + dataIndex + 1 : dataIndex + 1;
            $('td', row).eq(0).html(index);
        },
        columnDefs: [
            {
                targets: [0, 1, 2, 3, 4],
                orderable: false
            },
            {
                targets: 5,
                visible: false
            }
        ],
        order: [[5, 'asc']]
    });
    // Actualizar usuario
    $btnActualizarUsuario.on('click', function (e) {
        e.preventDefault();

        if (!$formEditar.length) {
            console.warn('Formulario ModificarUsuario_form no encontrado.');
            return;
        }

        // Limpiar errores anteriores
        $formEditar.find('.text-danger, span.error-text').text('');
        $formEditar.find('.brc-danger').removeClass('brc-danger');
        $btnActualizarUsuario.prop('disabled', true);

        const csrfInput = $formEditar.find('.ci_csrf_data');
        const csrf_token = csrfInput.attr('name') || ''; // nombre del token CSRF
        const csrf_hash = csrfInput.val() || '';        // valor del token CSRF

        const formEl = document.getElementById("modificarUsuario_form");
        if (!formEl) {
            toastr.error('Formulario de modificación no encontrado.');
            $btnActualizarUsuario.prop('disabled', false);
            return;
        }

        const formData = new FormData(formEl);

        if (csrf_token && csrf_hash) {
            formData.append(csrf_token, csrf_hash);
        }

        const actionUrl = $formEditar.attr('action') || '/admin/usuariosActualizar';
        $.ajax({
            url: $formEditar.attr('action'),
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                toastr.remove();
            },
            success: function (response) {
                 // Actualizar token CSRF si viene en la respuesta
                csrfInput.val(response.token);
                
                // Manejo seguro de respuesta/errores
                const fieldErrors = response && (response.error || response.errors || response.validation) || null;

                if (!fieldErrors) {
                    if (response && response.status === 1) {
                        $formEditar[0].reset();
                        $modal.modal('hide');
                        toastr.success(response.msg || 'Operación exitosa');
                        // emitir evento para refrescar tablas si se escucha
                        $(document).trigger('usuario:Actualizado', [response]);
                    } else {
                        toastr.error(response && response.msg ? response.msg : 'Error en la operación');
                    }
                } else {
                    // Mostrar errores por campo
                    $.each(fieldErrors, function (field, value) {
                        const $field = $formEditar.find('[name="' + field + '"], #' + field);
                        if ($field.length) {
                            $field.addClass("brc-danger");
                            const $errSpan = $field.closest('.col-sm-6').find('span.error-text');
                            if ($errSpan.length) {
                                $errSpan.html(Array.isArray(value) ? value.join('<br>') : value);
                            } else {
                                toastr.warning(Array.isArray(value) ? value.join('<br>') : value);
                            }
                        } else {
                            toastr.warning(Array.isArray(value) ? value.join('<br>') : value);
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error, xhr.responseText);
                toastr.error('Error en la petición: ' + (xhr.responseJSON && xhr.responseJSON.msg ? xhr.responseJSON.msg : xhr.statusText || status));
            },
            complete: function () {
                $btnActualizarUsuario.prop('disabled', false);
            }
        });
    });
});