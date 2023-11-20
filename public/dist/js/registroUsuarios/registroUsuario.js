$(function(){

    $('.select2Agregar').select2({
        language: 'es',
        dropdownParent: $('.modal-body', '#modalAgregarUsuarioId'),
    });
    $('.select2Actualizar').select2({
        language: 'es',
        dropdownParent: $('.modal-body', '#modalEditarUsuarioId'),
    });

    //generar tabla usuarios
    let form = $('#formTablaUsuarios');
    let url = form.attr('action');

    $("#tablaUsuariosId").DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
        },
        "paging": true,
        "pageLength": 10,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "ajax": url,
        "columns": [{
                "data": "DT_RowIndex",
                "class": "text-center"
            },
            {
                "data": "nombre",
                "class": "text-center"
            },
            {
                "data": "nroDoc",
                "class": "text-center"
            },
            {
                "data": "rol",
                "class": "text-center"
            },
            {
                "data": "email",
                "class": "text-center"
            },
            {
                "data": "foto",
                "class": "text-center"
            },
            {
                "data": "fechaCrea",
                "class": "text-center"
            },
            {
                "data": "estado",
                "class": "text-center"
            },
            {
                "data": "options",
                "class": "text-center"
            },
        ],
        "processing": true,
        "order": [
            [0, "asc"]
        ],

    });

    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    agregarUsuario();

});

const clearForm = (formId, arraySelectsIds = []) => {
    $("#" + formId).trigger("reset");
    arraySelectsIds.forEach(row => {
        $("#" + row).val("").trigger("change");
    });
}

const agregarUsuario = () => {

    //obteniendo la url
    const form = $("#formAgregarUsuarioId");
    const url = form.attr('action');

    $('#formAgregarUsuarioId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formAgregarUsuarioId')[0]);

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
                    $('#tablaUsuariosId').DataTable().ajax.reload();
                    $("#modalAgregarUsuarioId").modal("hide");
                    clearForm('formAgregarUsuarioId', ['estado_id','tipoUser_id']);
                });
            }
        })
    });
}

const editarUsuario = (id) => {
    let modalActualiza = $('#modalEditarUsuarioId')
    $('#getUsuarioId').val(id);

    let formGet = $('#formGetUsuarioId');
    let urlGet = formGet.attr('action');
    let urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {usuario:usuario} = response;
        $('#name_edit_id').val(usuario.name);
        $('#apellidoP_edit_id').val(usuario.apellidosP);
        $('#apellidoM_edit_id').val(usuario.apellidosM);
        $('#dni_edit_id').val(usuario.dni);
        $('#email_edit_id').val(usuario.email);
        $('#telefono_edit_id').val(usuario.telefono);
        $('#fechaNacimiento_edit_id').val(moment(usuario.fecha_nacimiento).format("DD/MM/YYYY"));
        $('#tipoUser_edit_id').val(usuario.tipo_usuario).trigger('change');
        $('#estado_edit_id').val(usuario.estado).trigger('change');

        $("#password_edit_id").prop("disabled", true).val('');
        $("#password_rep_edit_id").prop("disabled", true).val('');
        $("#cambiarPassCheckId").prop("checked", false);
        if (usuario.foto_archivo) {
            $('#imagenSubida').html(usuario.foto_archivo);
        } else{
            $('#imagenSubida').html('Imagen no encontrada');
        }
    }).done(() => {
        modalActualiza.modal("show");
    })

    $("#cambiarPassCheckId").on("change", (e) => {
        let check = e.target.checked;
        if (check) {
            $("#password_edit_id").prop("disabled", false)
            $("#password_rep_edit_id").prop("disabled", false)
        } else {
            $("#password_edit_id").prop("disabled", true)
            $("#password_rep_edit_id").prop("disabled", true)
        }
    });

    //obteniendo la url
    const form = $("#formEditarUsuarioId");
    const url = form.attr('action');

    $('#formEditarUsuarioId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formEditarUsuarioId')[0]);

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
                    $('#tablaUsuariosId').DataTable().ajax.reload();
                    modalActualiza.modal("hide");
                    clearForm('formEditarUsuarioId', ['estado_edit_id','tipoUser_edit_id']);
                });
            }
        })
    });
}

const eliminarUsuario = (id) => {

    $("#usuarioEliminarId").val(id);
    //obteniendo la url
    const form = $("#formEliminarUsuarioId");
    const url = form.attr('action');
    const dataForm = new FormData($('#formEliminarUsuarioId')[0]);
        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma eliminar usuario?",
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
                    $('#tablaUsuariosId').DataTable().ajax.reload();
                });
            }
        })
}


const cambioEstado = (id) => {
    let modalEstado = $('#modalActualizarEstadoId')
    $("#estadosContainer").empty();
    $('#mensajeGuardadoId').empty();
    let formGet = $('#formGetUsuarioId');
    let urlGet = formGet.attr('action');
    let urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {estados,usuario} = response;
        estados.forEach(function (row) {
            let valChecked = '';
            if (row.name === usuario.estado) {
                valChecked = 'checked';
            }
            let html = `
            <div class="icheck-primary">
                <input type="radio" id="cal_${row.id}" onclick="guardarEstado('${row.name}', ${id})" value="${row.name}" name="name" ${valChecked} />
                <label class="fw-bold text-uppercase fs-20" for="cal_${row.id}"><span class="badge bg-${row.color}">${row.name}</span></label>
            </div>
            `;
            $("#estadosContainer").append(html);
        });
    }).done(() => {
        modalEstado.modal("show");
    })
}


let timeout = null;
const guardarEstado = (estado, usuarioId) => {
    $("#idUser").val(usuarioId);
    $("#valoEstado").val(estado);

    //obteniendo la url
    const form = $("#formActualizarEstadoId");
    const urlForm = form.attr('action');
    const dataform = form.serialize();
    let html = `<div class="alert alert-dark mb-0" role="alert">
                    <i class="ri-refresh-line me-3  align-middle fs-16" animated-icon></i>
                    Guardando...
                </div>
                `;
    $("#mensajeGuardadoId").html(html);

    clearTimeout(timeout); // this will clear the recursive unneccessary calls
    timeout = setTimeout(() => {
        $.ajax({
            url: urlForm,
            type: "POST",
            data: dataform,
        }).then((data) => {
            if (data.status === 'ok') {
                mostrarMensajeExito('Guardado automaticamente');
                $('#tablaUsuariosId').DataTable().ajax.reload(null, false);
            } else {
                mostrarMensajeError('Error al guardar');
            }
        }, (reason) => {
            mostrarMensajeError('Error de red');
        });
    }, 200);
}

function mostrarMensajeExito(mensaje) {
    let html = `<div class="alert alert-success" role="alert">
                    <i class="ri-check-double-line me-3 align-middle fs-16 text-success"></i>
                    ${mensaje}
                </div>
                `;
    $("#mensajeGuardadoId").html(html);
}

function mostrarMensajeError(mensaje) {
    let html = `<div class="alert alert-danger" role="alert">
                    <i class="ri-error-warning-line me-3 align-middle fs-16 text-danger "></i>
                    ${mensaje}
                </div>
                `;
    $("#mensajeGuardadoId").html(html);
}
