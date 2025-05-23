  $('#btnLogin').on('click', function () {
    const loginUser = $('#loginUser').val();
    const Loginpass = $('#Loginpass').val();
    const remember = $('#customCheck').is(':checked') ? 1 : 0;

   
    if (!loginUser || !Loginpass) {
      Swal.fire({
        icon: 'warning',
        title: 'Campos requeridos',
        text: 'Por favor completa todos los campos.'
      });
      return;
    }

    $.ajax({
      url: 'controllers/login.controller.php',
      type: 'POST',
      data: {
        action: 'login',
        loginUser: loginUser,
        Loginpass: Loginpass,
        remember: remember
      },
      dataType: 'json',
      success: function (response) {

        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Bienvenido',
            text: response.message || 'Inicio de sesión correcto.'
          }).then(() => {
            // Redireccionar o recargar
            window.location.href = 'index.php'; // Cambia a tu vista
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Error de login',
            text: response.message || 'Credenciales inválidas.'
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
        Swal.fire({
          icon: 'error',
          title: 'Error de conexión',
          text: 'No se pudo conectar al servidor.'
        });
      }
    });
  });
