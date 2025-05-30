
// Llamar a la función para cargar la tabla al cargar la página
function cargarTablaUsuarios() {
    if ($.fn.DataTable.isDataTable('#tablaUsuarios')) {
        $('#tablaUsuarios').DataTable().destroy();
    }

    $('#tablaUsuarios').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: 'controllers/usuario.controller.php',
            type: 'POST',
            data: { action: 'obtenerUsuarios' },
            dataSrc: function(json) {
                //console.log('Respuesta completa:', json);
                
                // Verificar si hay error en la respuesta
                if (json.status === 'error') {
                    console.error('Error del servidor:', json.message);
                    alert('Error: ' + json.message);
                    return [];
                }
                
                // Verificar que la respuesta tenga datos
                if (!json || !json.data || !Array.isArray(json.data)) {
                    console.error('Respuesta inválida:', json);
                    return [];
                }
                
                //console.log('Datos recibidos:', json.data.length, 'registros');
                return json.data;
            },
            error: function(xhr, error, code) {
                console.error('Error AJAX completo:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error,
                    code: code
                });
                
                try {
                    const errorResponse = JSON.parse(xhr.responseText);
                    alert('Error del servidor: ' + errorResponse.message);
                } catch (e) {
                    alert('Error de comunicación con el servidor');
                }
            }
        },
        columns: [
            { data: 'nombre', defaultContent: '' },
            { data: 'nombreEntidad', defaultContent: '' },
            { data: 'user', defaultContent: '' },
            { data: 'rol', defaultContent: '' },
            {
                data: 'estado',
                defaultContent: '',
                render: function(data) {
                    return data == 1 ? 'Activo' : 'Inactivo';
                }
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

// Ejecutar al cargar la página
$(document).ready(function() {
    //console.log('Iniciando carga de usuarios...');
    
    // Probar conexión primero
    //probarConexion();
    
    // Cargar tabla si existe el elemento
    if ($('#tablaUsuarios').length) {
        //console.log('Elemento tabla encontrado, inicializando...');
        cargarTablaUsuarios();
    } else {
        console.error('Elemento #tablaUsuarios no encontrado en el DOM');
    }
});

// Enviar datos por AJAX al controller
$('#registrarUser').on('click', function () {
    const nombre = $('#nombre').val().trim();
    const EntidadUser = $("#EntidadUser").val();
    const username = $('#username').val().trim();
    const rolUser = $('#rolUser').val();
    const password = generarPassword(); // Generamos la contraseña directamente

    if (nombre === "" || username === "") {
      Swal.fire({
        icon: 'warning',
        title: 'Campos incompletos',
        text: 'Por favor completa todos los campos.',
      });
      return;
    }

  //     // Mostrar en consola lo que se va a enviar
  // console.log("Datos enviados:", {
  //   action: 'registrarUsuarios',
  //   nombre: nombre,
  //   EntidadUser: EntidadUser,
  //   username: username,
  //   rolUser: rolUser,
  //   password: password
  // });
    $.ajax({
      url: 'controllers/usuario.controller.php',
      type: 'POST',
      data: {
        action: 'registrarUsuarios',
        nombre: nombre,
        EntidadUser: EntidadUser,
        username: username,
        rolUser: rolUser,
        password: password
      },
      success: function (response) {
          //console.log("Respuesta cruda del servidor:", response); // 👈 Agregado para depurar
        try {
          const data = JSON.parse(response);
          if (data.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Usuario registrado',
              html: `<strong>Usuario:</strong> ${username}<br><strong>Contraseña:</strong> ${password}`,
            });
            $('#modalUser').modal('hide');
            $('#nombre').val('');
            $('#EntidadUser').val('');
            $('#username').val('');
            $('#rolUser').val('');
            cargarTablaUsuarios();
          
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: data.message || 'Error al registrar.',
            });
          }
        } catch (err) {
          console.error(err);
          Swal.fire('Error', 'Respuesta inválida del servidor.', 'error');
        }
      },
      error: function (xhr, status, error) {
        Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error');
      }
    });
  });




function generarPassword(longitud = 12) {
  const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
  let password = '';
  for (let i = 0; i < longitud; i++) {
    password += chars.charAt(Math.floor(Math.random() * chars.length));
  }
  return password;
}