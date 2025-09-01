$(function () {
    // Abrir modal
    $('#btnNuevoUsuario').on('click', function () {
        $('#nuevoUsuario-modal').modal('show');
    });

    // Enviar formulario via AJAX
    $('#btnGuardarUsuario').on('click', function (e) {
        e.preventDefault();

        // Limpiar errores anteriores
        $('.text-danger').text('');
        $(this).prop('disabled', true);

        const csrfInput = $('.ci_csrf_data');
        const csrf_token = csrfInput.attr('name') || ''; // nombre del token CSRF
        const csrf_hash = csrfInput.val() || '';        // valor del token CSRF
        const form = document.getElementById("agregarUsuario_form");
        const $form = $(form);
        const formData = new FormData(form);
        const modal = $('body').find('div#nuevoUsuario-modal');

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
                $form.find('span.error-text').text('');
            },
            success: function (response) {
                // Actualizar token CSRF si viene en la respuesta
                if (response && response.token) {
                    csrfInput.val(response.token);
                }

                if (response && response.status === 1) {
                    $form[0].reset();
                    modal.modal('hide');
                    toastr.success(response.msg || 'Operación exitosa');
                    // Aquí puedes refrescar tabla/listado si aplica
                } else {
                    let ban = 0;
                    let texto = "";

                    if (response && response.errors) {
                        $.each(response.errors, function (field, value) {
                            ban++;
                            // Intentar marcar campo por name o id
                            const $field = $form.find('[name="' + field + '"], #' + field);
                            if ($field.length) {
                                $field.addClass("brc-danger");
                                // colocar mensaje en span.error-text dentro del grupo del campo si existe
                                const $errSpan = $field.closest('.form-group').find('span.error-text');
                                if ($errSpan.length) {
                                    $errSpan.html(value);
                                } else {
                                    texto += value + "!<br>";
                                }
                            } else {
                                // si no se encuentra el campo, acumular el mensaje
                                texto += value + "!<br>";
                            }
                        });
                    } else {
                        texto = response.msg || 'Ocurrió un error en la validación.';
                        ban = 1;
                    }

                    if (ban > 0) {
                        Swal.fire("¡Atención!", texto, "warning");
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                toastr.error('Error en la petición: ' + (error || status));
            },
            complete: function () {
                $('#btnGuardarUsuario').prop('disabled', false);
            }
        });
    });
});
