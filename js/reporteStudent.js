
$('#btnDescargarPlantilla').on('click', function () {
  window.location.href = 'assets/plantilla_estudiante.csv';
});


$('#csvFile').on('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    Papa.parse(file, {
        header: true,
        skipEmptyLines: true,
        complete: function (results) {
            csvData = results.data;

            if (!csvData || csvData.length === 0) {
                Swal.fire("⚠️ Atención", "El archivo está vacío o mal formateado.", "warning");
            } else {
                Swal.fire("✅ Archivo cargado", `${csvData.length} registros listos para subir.`, "success");
            }
        },
        error: function () {
            Swal.fire("❌ Error", "No se pudo leer el archivo CSV.", "error");
        }
    });
});

$('#subirEstudiantesBtn').on('click', function () {
    if (!csvData || csvData.length === 0) {
        Swal.fire("⚠️ Atención", "Primero debes cargar un archivo CSV válido.", "warning");
        return;
    }

    const registros = csvData.map(row => ({
        codigoEstudiante: row['codigoEstudiante'] || '',
        fechaRegistro: convertirFecha(row['fechaRegistro'] || ''),
        nombre: row['nombre'] || '',
        carrera: row['carrera'] || '',
        organizacion: row['organizacion'] || '',
        semestre: row['semestre'] || '',
        estado: row['estado'] || '',
        trastorno: row['trastorno'] || '',
        nivel: row['nivel'] || ''
    }));

        console.log("📦 Datos enviados al controlador:", registros); // 👈 Aquí verás los datos en consola

    Swal.fire({
        title: "¿Deseas subir los estudiantes?",
        text: `Se enviarán ${registros.length} registros.`,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, subir",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'controllers/reporteStudent.controller.php',
                method: 'POST',
                data: {
                    action: 'subirEstudiantes',
                    registros: JSON.stringify(registros)
                },
                dataType: 'json',
                beforeSend: function () {
                    Swal.fire({
                        title: 'Subiendo...',
                        text: 'Por favor espera.',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire("✅ Éxito", response.message, "success");
                        $('#csvFile').val('');
                        csvData = [];
                        // Actualiza tabla si deseas
                    } else {
                        Swal.fire("⚠️ Error", response.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("❌ Error", "Hubo un problema en el servidor.", "error");
                }
            });
        }
    });
});

//funcion para buscar estudiantes



$('#buscarEstudiantesBtn').on('click', function () {


    
    const fechaIncio = $('#fechaInicio').val() || '';
    const fechaFin = $('#fechaFin').val() || '';
    const codigoEstudiante = $('#codigoEstudiante').val() || '';
    const filtroCarrera = $('#filtroCarrera').val()||[];
    const filtroOrganizacion = $('#filtroOrganizacion').val() || [];

    if (!codigoEstudiante && !fechaIncio && !filtroCarrera && !filtroOrganizacion && !fechaFin) {
        Swal.fire("⚠️ Atención", "Debes ingresar al menos un criterio de búsqueda.", "warning");
        return;
    }

    $.ajax({
        url: 'controllers/reporteStudent.controller.php',
        method: 'POST',
        data: {
            action: 'buscarEstudiantes',
            codigoEstudiante: codigoEstudiante,
            fechaIncio: fechaIncio,
            fechaFin: fechaFin,
            filtroCarrera: filtroCarrera,
            filtroOrganizacion: filtroOrganizacion
        },
        dataType: 'json',
        beforeSend: function () {
            Swal.fire({
                title: 'Buscando...',
                text: 'Por favor espera.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
        },
        success: function (response) {
    if (response.status === 'success') {
        Swal.close(); // Cierra el loader

        // Destruir el DataTable si ya existe
        if ($.fn.DataTable.isDataTable('#tablaEstudiantes')) {
            $('#tablaEstudiantes').DataTable().destroy();
        }

        // Limpiar tbody
        $('#tablaEstudiantes tbody').empty();

        // Insertar filas
        response.buscarEstudiantes.forEach(est => {
            $('#tablaEstudiantes tbody').append(`
                <tr>
                    <td>${est.fechaRegistro}</td>
                    <td>${est.codigoEstudiante}</td>
                    <td>${est.nombre}</td>
                    <td>${est.carrera}</td>
                    <td>${est.organizacion}</td>
                </tr>
            `);
        });

        // Inicializar DataTable
        $('#tablaEstudiantes').DataTable({
            responsive: true,
            pageLength: 10,
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
        lengthMenu: [5, 10, 20, 50]
        });

        } else {
            Swal.fire("⚠️ Error", response.message, "error");
        }
    },
        error: function () {
            Swal.fire("❌ Error", "Hubo un problema en el servidor.", "error");
        }
    });

});


function convertirFecha(fechaStr) {
    // Convierte '30/05/2025' a '2025-05-30'
    const partes = fechaStr.split('/');
    if (partes.length === 3) {
        return `${partes[2]}-${partes[1]}-${partes[0]}`;
    }
    return fechaStr; // Devuelve igual si ya está bien
}




