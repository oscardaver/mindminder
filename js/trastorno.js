
$(document).ready(function() {
    cargarTablaTrastornos();
});
// Abrir modal al hacer clic en el botón
$('#abrirModal').on('click', function() {
    $('#modalTrastorno').modal('show');
});

// Limpiar campos al cerrar el modal
$('#modalTrastorno').on('hidden.bs.modal', function () {
    $('#nombreTrastorno').val('');
    $('#descripcionTrastorno').val('');
});

// Enviar datos por AJAX al controller
$('#registrarTrast').on('click', function() {
    var nombreTrastorno = $('#nombreTrastorno').val().trim();
    var descripcionTrastorno = $('#descripcionTrastorno').val().trim();

    if (nombreTrastorno === "" || descripcionTrastorno === "") {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Por favor completa todos los campos.',
        });
        return;
    }

    $.ajax({
        url: 'controllers/trastorno.controller.php',
        type: 'POST',
        data: {
            action: 'registrarTrastorno',
            nombreTrastorno: nombreTrastorno,
            descripcionTrastorno: descripcionTrastorno
        },
        success: function(response) {
            if (response === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Trastorno registrado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

                $('#modalTrastorno').modal('hide');

                // Si tienes una tabla, actualízala aquí (ejemplo):
                cargarTablaTrastornos();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo registrar el trastorno.',
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error de servidor',
                text: 'No se pudo establecer conexión con el servidor.',
            });
            console.error(error);
        }
    });
});

// Función para cargar la tabla de trastornos (ejemplo)

function cargarTablaTrastornos() {
    // Verifica si ya hay una tabla inicializada
    if ($.fn.DataTable.isDataTable('#tablaTrastornos')) {
        $('#tablaTrastornos').DataTable().clear().destroy();
    }

    $('#tablaTrastornos').DataTable({
        ajax: {
            url: 'controllers/trastorno.controller.php',
            type: 'POST',
            data: { action: 'cargarTablaTrastornos' },
            dataSrc: 'data'
        },
    columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'nombre' },
            { data: 'descripcion' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn-editar" data-id="${row.codigoTrastorno}">✏️</button>
                        <button class="btn-eliminar" data-id="${row.codigoTrastorno}">🗑️</button>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        language: {
            decimal: "",
            emptyTable: "No hay datos disponibles en la tabla",
            info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
            infoEmpty: "Mostrando 0 a 0 de 0 entradas",
            infoFiltered: "(filtrado de _MAX_ entradas totales)",
            lengthMenu: "Mostrar _MENU_ entradas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "No se encontraron registros coincidentes",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50]
    });
}


// Llamar a la función para cargar la tabla al cargar la página
$('#tablaTrastornos').on('click', '.btn-eliminar', function () {
    const id = $(this).data('id');
    eliminarTrastorno(id);
});

$('#tablaTrastornos').on('click', '.btn-editar', function () {
    const id = $(this).data('id');

    $.ajax({
        url: 'controllers/trastorno.controller.php',
        type: 'POST',
        data: { action: 'obtenerTrastorno', id: id },
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.success) {
                const trastorno = respuesta.data;
                $('#editarId').val(trastorno.codigoTrastorno);
                $('#editarNombre').val(trastorno.nombre);
                $('#editarDescripcion').val(trastorno.descripcion);
                $('#modalEditar').modal('show');
            } else {
                Swal.fire('Error', 'No se pudo obtener el trastorno.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Error en la petición AJAX.', 'error');
        }
    });
});

// Función para eliminar un trastorno
function eliminarTrastorno(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás recuperar este registro!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'controllers/trastorno.controller.php',
                type: 'POST',
                data: {
                    action: 'eliminarTrastorno',
                    id: id
                },
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire(
                            'Eliminado!',
                            'El trastorno ha sido eliminado.',
                            'success'
                        );
                        cargarTablaTrastornos();
                    } else {
                        Swal.fire(
                            'Error!',
                            'No se pudo eliminar el trastorno.',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
}

// Función para editar un trastorno
$('#btnEditarTrastorno').on('click', function () {
    const editarId = $('#editarId').val();
    const editarNombre = $('#editarNombre').val();
    const editarDescripcion = $('#editarDescripcion').val();

    $.ajax({
        url: 'controllers/trastorno.controller.php',
        type: 'POST',
        data: {
            action: 'editarTrastorno',
            editarId: editarId,
            editarNombre: editarNombre,
            editarDescripcion: editarDescripcion
        },
        dataType: 'json',
        success: function (respuesta) {
            if (respuesta.success) {
                $('#modalEditar').modal('hide');
                Swal.fire('Éxito', 'Trastorno actualizado correctamente.', 'success');
                $('#tablaTrastornos').DataTable().ajax.reload();
            } else {
                Swal.fire('Error', 'No se pudo actualizar el trastorno.', 'error');
            }
        },
        error: function () {
            Swal.fire('Error', 'Error en la petición AJAX.', 'error');
        }
    });
});

