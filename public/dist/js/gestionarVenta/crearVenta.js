$(function(){

    $('.select2').select2();

    //generar tabla Items
    let form = $('#formTablaItems');
    let url = form.attr('action');

    $("#tablaItemsId").DataTable({
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
                "data": "nombre",
                "class": "text-center"
            },
            {
                "data": "tipo",
                "class": "text-center"
            },
            {
                "data": "cantidad",
                "class": "text-center"
            },
            {
                "data": "precio",
                "class": "text-center"
            },
            {
                "data": "total",
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

    $('#productoId').on('select2:select', function() {
        let value = $(this).val();
        if (value == '') {
            $('#nombreProductoId').val('');
            $('#stockProductoId').val('');
            $('#precioProductoId').val('');
        } else {
            obtenerProducto(value);
        }
    });

    $('#servicioId').on('select2:select', function() {
        let value = $(this).val();
        if (value == '') {
            $('#nombreServicioId').val('');
            $('#precioServicioId').val('');
        } else {
            obtenerServicio(value);
        }
    });

    obtenerTotalPagar();
    guardarProducto();
    guardarServicio();
    registrarVenta();

});


const obtenerProducto = (id) => {
    const formGet = $('#formGetProductoId');
    const urlGet = formGet.attr('action');
    const urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {producto:producto} = response;
        $('#nombreProductoId').val(producto.nombre_producto !== undefined ? producto.nombre_producto : '');
        $('#stockProductoId').val(producto.stock !== undefined ? producto.stock : '');
        $('#precioProductoId').val(producto.precio_venta !== undefined ? producto.precio_venta : '');
    }).done(() => {
        console.log("ok");
    })
}


const obtenerServicio = (id) => {
    const formGet = $('#formGetServicioId');
    const urlGet = formGet.attr('action');
    const urlGetWithId = urlGet.slice(0,-1) + id;

    $.get(urlGetWithId, (response) => {
        let {servicio:servicio} = response;
        $('#nombreServicioId').val(servicio.nombre_servicio !== undefined ? servicio.nombre_servicio : '');
        $('#precioServicioId').val(servicio.precio_venta !== undefined ? servicio.precio_venta : '');
    }).done(() => {
        console.log("ok");
    })
}

const obtenerTotalPagar = () => {
    const formGet = $('#formGetTotalItemsId');
    const urlGet = formGet.attr('action');
    const urlGetWithId = urlGet.slice(0,-1) + 0;

    $.get(urlGetWithId, (response) => {
        let {totalPagar:totalPagar} = response;
        $('#totalPagarId').val(totalPagar.toFixed(2));
    }).done(() => {
        console.log("ok");
    })
}

const guardarProducto = () => {
    //obteniendo la url
    const form = $("#formGuardarProductoId");
    const url = form.attr('action');

    $('#formGuardarProductoId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formGuardarProductoId')[0]);

        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma agregar item producto?",
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
                    // location.reload();
                    $('#tablaItemsId').DataTable().ajax.reload();
                    obtenerTotalPagar();
                    $("#formGuardarProductoId").trigger("reset");
                    $("#productoId").val("").trigger("change");
                });
            }
        })
    });
}

const guardarServicio = () => {
    //obteniendo la url
    const form = $("#formGuardarServicioId");
    const url = form.attr('action');

    $('#formGuardarServicioId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formGuardarServicioId')[0]);

        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma agregar item Servicio?",
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
                    // location.reload();
                    $('#tablaItemsId').DataTable().ajax.reload();
                    obtenerTotalPagar();
                    $("#formGuardarServicioId").trigger("reset");
                    $("#servicioId").val("").trigger("change");
                });
            }
        })
    });
}

const eliminarItem = (id) => {

    $("#itemEliminarId").val(id);
    //obteniendo la url
    const form = $("#formEliminarItemId");
    const url = form.attr('action');
    const dataForm = new FormData($('#formEliminarItemId')[0]);
        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma eliminar item?",
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
                    $('#tablaItemsId').DataTable().ajax.reload(null, false);
                    obtenerTotalPagar();
                });
            }
        })
}

const registrarVenta = () => {
    //obteniendo la url
    const form = $("#formRegistrarVentaId");
    const url = form.attr('action');

    $('#formRegistrarVentaId').off('submit').on('submit', function(e) {
        e.preventDefault();
        const dataForm = new FormData($('#formRegistrarVentaId')[0]);

        Swal.fire({
            title: "¿Confirma continuar?",
            text: "¿Confirma Registrar Venta?",
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
                    let formRedirec = $("#formRedireccionarVentas");
                    let urlRedirec = formRedirec.attr('action');
                    location.href = urlRedirec;
                });
            }
        })
    });
}


const cancelarVenta = () => {
    let formRedirec = $("#formRedireccionarVentas");
    let urlRedirec = formRedirec.attr('action');
    location.href = urlRedirec;
}
