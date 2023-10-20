$(function(){

    $('.select2Agregar').select2();

    $('#depa_id').change(function() {
        fn_get_provincias();
    });

    $('#provincia_id').change(function() {
        fn_get_distritos();
    });

    if ($('#departamento_ayuda').val() != '') {
        fn_iniciar();
    } else {
        $('#departamento_id').change(function() {
            fn_get_provincias();
        });

        $('#provincia_id').change(function() {
            fn_get_distritos();
        });
    }

    actualizarEmpresa();
});

const fn_iniciar = () => {
    fn_get_provincias();
}

const cargaCombo = (id, lista) => {
    $(id).empty();
    $(id).append("<option value=''>[ SELECCIONE ]</option>");
    $.each(lista, function(i, item) {
        $(id).append("<option value='" + item.codigo + "'>" + item.descripcion + "</option>");
    });
}

const fn_get_provincias = () => {
    let form = $("#form-getProvincias");
    let url = form.attr('action');
    $("#get_provincia_id").val($("#depa_id").val());
    let data = form.serialize();

    $.post(url, data)
        .done(function(response) {
            let { data, status } = response;
            if (status === 'success') {
                cargaCombo('#provincia_id', response.data);
                if ($('#provincia_ayuda').val() != null) {
                    $('#provincia_id').val($('#provincia_ayuda').val());
                    $('#provincia_id').trigger('change');
                    fn_get_distritos();
                }
                $('#depa_id').change(function() {
                    $('#provincia_ayuda').val('');
                });
            }
        })
        .fail(function() {
            console.log("Error en la solicitud.");
        });
}

const fn_get_distritos = () => {
    let form = $("#form-getDistritos");
    let url = form.attr('action');
    $("#get_distrito_id").val($("#provincia_id").val());
    let data = form.serialize();

    $.post(url, data)
        .done(function(response) {
            let { data, status } = response;
            if (status === 'success') {
                cargaCombo('#distrito_id', response.data);
                if ($('#distrito_ayuda').val() != null && $('#provincia_ayuda').val() != null) {
                    $('#distrito_id').val($('#distrito_ayuda').val());
                    $('#distrito_id').trigger('change');
                }
                $('#provincia_id').change(function() {
                    $('#distrito_ayuda').val('');
                });
            }
        })
        .fail(function() {
            console.log("Error en la solicitud.");
        });
}

const actualizarEmpresa = () => {
    //obteniendo la url
    const form = $("#formActualizarEmpresaId");
    const url = form.attr('action');

    $('#formActualizarEmpresaId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formActualizarEmpresaId')[0]);

        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma guardar cambios de la información?",
            icon: "question",
            showCancelButton: true,
            confirmButtonClass: "btn btn-success w-xs me-2 mt-2",
            cancelButtonClass: "btn btn-light w-xs mt-2",
            confirmButtonText: "Si, Confirmar!",
            buttonsStyling: false,
            showCloseButton: true,
            cancelButtonText: "Cancelar",
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            background: "#fff url(" + ruta_principal_main + "assets/images/chat-bg-pattern.png)",
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                            url: url,
                            type: 'post',
                            data: dataForm,
                            cache: false,
                            processData: false,
                            contentType: false,
                        }).done((response) => {
                            console.log("response:", response);
                            // Manejar la respuesta del servidor
                            if (response.status == 'ok') {
                                console.log("response:", response);
                                // Resuelve la promesa para cerrar la alerta
                                resolve(response);
                            } else {
                                Swal.fire({
                                    html: '<div class="mt-3"><lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon><div class="mt-4 pt-2 fs-15"><h4>' + response.titulo + '</h4><p class="text-muted mx-4 mb-0">' + response.message + '</p></div></div>',
                                    showCancelButton: !0,
                                    showConfirmButton: !1,
                                    cancelButtonClass: "btn btn-light w-xs mb-1",
                                    cancelButtonText: "Ok",
                                    buttonsStyling: !1,
                                    showCloseButton: !0,
                                    background: "#fff url(" + ruta_principal_main + "assets/images/chat-bg-pattern.png)",
                                });
                            }
                        })
                        .fail((reason) => {
                            // Manejar los errores de la llamada AJAX
                            Swal.fire({
                                title: 'Error',
                                text: reason,
                                icon: "error",
                                confirmButtonClass: "btn btn-light w-xs mt-2",
                                confirmButtonText: "Ok",
                                buttonsStyling: !1,
                                showCloseButton: !0,
                                background: "#fff url(" + ruta_principal_main + "assets/images/chat-bg-pattern.png)",
                            });
                        });
                });
            }
        }).then((result) => {
            console.log("result:", result);
            const { value: response } = result;
            console.log("response:", response);
            if (result.isConfirmed) {
                Swal.fire({
                    html: '<div class="mt-3"><lord-icon src="' + ruta_principal_main + 'assets/images/successfully-done.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:250px;height:250px;margin:-49px"></lord-icon><div class="mt-0 pt-2 fs-15"><h4>' + response.titulo + '</h4><p class="text-muted mx-4 mb-0">' + response.message + '</p></div></div>',
                    showCancelButton: !0,
                    showConfirmButton: !1,
                    cancelButtonClass: "btn btn-light w-xs mb-1",
                    cancelButtonText: "Cerrar",
                    buttonsStyling: !1,
                    showCloseButton: !0,
                    background: "#fff url(" + ruta_principal_main + "assets/images/chat-bg-pattern.png)",
                }).then(() => {
                    location.reload();
                });
            }
        })
    });
}
