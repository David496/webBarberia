$(function(){

    //generar tabla clientes
    let form = $('#formTablaCliente');
    let url = form.attr('action');

    $("#tablaClienteId").DataTable({
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
                "data": "email",
                "class": "text-center"
            },
            {
                "data": "telefono",
                "class": "text-center"
            },
            {
                "data": "fechaCrea",
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

    agregarCliente();

});

const agregarCliente = () => {

    //obteniendo la url
    const form = $("#formAgregarClienteId");
    const url = form.attr('action');

    $('#formAgregarClienteId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formAgregarClienteId')[0]);

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
                    $('#tablaClienteId').DataTable().ajax.reload();
                    $("#modalAgregarClienteId").modal("hide");
                    $('#formAgregarClienteId').trigger("reset");
                });
            }
        })
    });
}

const editarCliente = (id) => {
    let modalActualiza = $('#modalEditarClienteId')
    $('#getClienteId').val(id);

    let formGet = $('#formGetClienteId');
    let urlGet = formGet.attr('action');
    let urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {cliente:cliente} = response;
        $('#nombres_edit_id').val(cliente.nombres);
        $('#apellidoP_edit_id').val(cliente.apellidoP);
        $('#apellidoM_edit_id').val(cliente.apellidoM);
        $('#dni_edit_id').val(cliente.dni);
        $('#telefono_edit_id').val(cliente.telefono);
        $('#email_edit_id').val(cliente.correo_electronico);
    }).done(() => {
        modalActualiza.modal("show");
    })

    //obteniendo la url
    const form = $("#formEditarClienteId");
    const url = form.attr('action');

    $('#formEditarClienteId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formEditarClienteId')[0]);

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
                    $('#tablaClienteId').DataTable().ajax.reload();
                    $("#modalEditarClienteId").modal("hide");
                    $('#formEditarClienteId').trigger("reset");
                });
            }
        })
    });
}

const eliminarCliente = (id) => {

    $("#clienteEliminarId").val(id);
    //obteniendo la url
    const form = $("#formEliminarClienteId");
    const url = form.attr('action');
    const dataForm = new FormData($('#formEliminarClienteId')[0]);
        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma eliminar Cliente?",
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
                    $('#tablaClienteId').DataTable().ajax.reload();
                });
            }
        })
}
