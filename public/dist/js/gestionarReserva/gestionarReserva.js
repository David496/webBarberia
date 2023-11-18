$(function(){
    $('.select2').select2({
        language: 'es',
        dropdownParent: $('.modal-body', '#modalAgregarReservaId'),
    });
    $('.select3').select2({
        language: 'es',
        dropdownParent: $('.modal-body', '#modalEditarrReservaId'),
    });
    $('.select4').select2({
        language: 'es',
        dropdownParent: $('.modal-body', '#modalActualizarEstadoId'),
    });
    $('.selectFilter').select2();

    //generar tabla clientes
    let form = $('#formTablaReservas');
    let url = form.attr('action');

    $("#tablaReservaId").DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json",
        },
        "paging": true,
        "pageLength": 10,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "processing": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "ajax": url,
        "columns": [{
                "data": "DT_RowIndex",
                "class": "text-center"
            },
            {
                "data": "titulo",
                "class": "text-center"
            },
            {
                "data": "empleado",
                "class": "text-center"
            },
            {
                "data": "cliente",
                "class": "text-center"
            },
            {
                "data": "fecha",
                "class": "text-center"
            },
            {
                "data": "hora_inicio",
                "class": "text-center"
            },
            {
                "data": "hora_fin",
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

    agregarReserva();

    $('#filterEstadoId').on('select2:select', function() {
        let value = $(this).val();
        filtroTablaEstado(value);
    });
});

const filtroTablaEstado = (val) => {
    $('#tablaReservaId').DataTable().column(7).search(
        val,
    ).draw();
}

const clearForm = (formId, arraySelectsIds = []) => {
    $("#" + formId).trigger("reset");
    arraySelectsIds.forEach(row => {
        $("#" + row).val("").trigger("change");
    });
}


const agregarReserva = () => {

    //obteniendo la url
    const form = $("#formAgregarReservaId");
    const url = form.attr('action');

    $('#formAgregarReservaId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formAgregarReservaId')[0]);

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
                    $('#tablaReservaId').DataTable().ajax.reload();
                    $("#modalAgregarReservaId").modal("hide");
                    clearForm('formAgregarReservaId',['cliente_id','empleado_id']);
                });
            }
        })
    });
}

const editarReserva = (id) => {
    let modalActualiza = $('#modalEditarrReservaId')
    $('#getReservaId').val(id);

    let formGet = $('#formGetReservaId');
    let urlGet = formGet.attr('action');
    let urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {reserva:reserva} = response;
        let hoy = moment().format('YYYY-MM-DD');
        let horaReserva = hoy + ' ' + reserva.hora_reserva;
        let horaReservaFin = hoy + ' ' + reserva.hora_fin_reserva;

        $('#titulo_edit_id').val(reserva.titulo_reserva);
        $('#descripcion_edit_id').val(reserva.descripcion);
        $('#fecha_edit_id').val(moment(reserva.fecha_reserva).format("DD/MM/YYYY"));
        $('#hora_inicio_edit_id').val(moment(horaReserva, 'YYYY-MM-DD H:mm').format('H:mm'));
        $('#hora_fin_edit_id').val(moment(horaReservaFin, 'YYYY-MM-DD H:mm').format('H:mm'));
        $('#cliente_edit_id').val(reserva.clienteID).trigger('change');
        $('#empleado_edit_id').val(reserva.userID).trigger('change');
    }).done(() => {
        modalActualiza.modal("show");
    })

    //obteniendo la url
    const form = $("#formEditarReservaId");
    const url = form.attr('action');

    $('#formEditarReservaId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formEditarReservaId')[0]);

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
                    $('#tablaReservaId').DataTable().ajax.reload();
                    modalActualiza.modal("hide");
                    clearForm('formEditarReservaId',['cliente_edit_id','empleado_edit_id']);
                });
            }
        })
    });
}

const eliminarReserva = (id) => {

    $("#reservaEliminarId").val(id);
    //obteniendo la url
    const form = $("#formEliminarReservaId");
    const url = form.attr('action');
    const dataForm = new FormData($('#formEliminarReservaId')[0]);
        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma eliminar reserva?",
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
                    $('#tablaReservaId').DataTable().ajax.reload();
                });
            }
        })
}

const cambioEstado = (id) => {
    let modalEstado = $('#modalActualizarEstadoId')
    $('#getRId').val(id);

    let formGet = $('#formGetReservaId');
    let urlGet = formGet.attr('action');
    let urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {reserva:reserva} = response;
        $('#estado_id').val(reserva.estado).trigger('change');
    }).done(() => {
        modalEstado.modal("show");
    })

    //obteniendo la url
    const form = $("#formActualizarEstadoId");
    const url = form.attr('action');

    $('#formActualizarEstadoId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formActualizarEstadoId')[0]);

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
                    $('#tablaReservaId').DataTable().ajax.reload();
                    modalEstado.modal("hide");
                    clearForm('formActualizarEstadoId',['estado_id']);
                });
            }
        })
    });
}
