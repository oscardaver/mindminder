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
            { data: 'descripcion' }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 20, 50]
    });
}
// Llamar a la función para cargar la tabla al cargar la página
$(document).ready(function() {
    cargarTablaTrastornos();
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
function editarTrastorno(id) {
    $.ajax({
        url: 'controllers/trastorno.controller.php',
        type: 'POST',
        data: {
            action: 'obtenerTrastorno',
            id: id
        },
        success: function(response) {
            var data = JSON.parse(response);
            $('#nombreTrastorno').val(data.nombre);
            $('#descripcionTrastorno').val(data.descripcion);
            $('#modalTrastorno').modal('show');

            // Cambiar el botón de registrar a actualizar
            $('#registrarTrast').off('click').on('click', function() {
                actualizarTrastorno(id);
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}
// Función para actualizar un trastorno 

function actualizarTrastorno(id) {
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
            action: 'actualizarTrastorno',
            id: id,
            nombreTrastorno: nombreTrastorno,
            descripcionTrastorno: descripcionTrastorno
        },
        success: function(response) {
            if (response === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Trastorno actualizado correctamente',
                    showConfirmButton: false,
                    timer: 1500
                });

                $('#modalTrastorno').modal('hide');
                cargarTablaTrastornos();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el trastorno.',
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}