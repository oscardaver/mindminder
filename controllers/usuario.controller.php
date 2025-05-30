<?php

require_once(__DIR__ . '/../models/usuario.model.php');
class Usuario_controller{

 public function obtenerUsuarios(){
        try {
            // Establecer headers apropiados
            header('Content-Type: application/json; charset=utf-8');
            header('Cache-Control: no-cache, must-revalidate');
            
            // Log para debugging
            //error_log("Iniciando obtenerUsuarios()");
            
            $resultado = Usuario_model::obtenerUsuarios();
            
            // Verificar el resultado
            if ($resultado === false) {
                error_log("Error: resultado es false");
                http_response_code(500);
                echo json_encode([
                    "data" => [],
                    "error" => "Error al obtener datos de la base de datos"
                ]);
                return;
            }
            
            if (empty($resultado)) {
                error_log("Advertencia: resultado está vacío");
                echo json_encode([
                    "data" => [],
                    "recordsTotal" => 0,
                    "recordsFiltered" => 0
                ]);
                return;
            }
            
            // Log del resultado para debugging
            //error_log("Usuarios obtenidos: " . count($resultado));
            
            // Respuesta exitosa
            $response = [
                "data" => $resultado,
                "recordsTotal" => count($resultado),
                "recordsFiltered" => count($resultado),
                "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 1
            ];
            
            echo json_encode($response);
            
        } catch (Exception $e) {
            error_log("Excepción en obtenerUsuarios: " . $e->getMessage());
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                "data" => [],
                "error" => "Error interno del servidor: " . $e->getMessage()
            ]);
        }
    }

    public function mostrarEntidad(){
        $entidad = new Usuario_model();
        $result = $entidad->obtenerEntidades();
        return $result;
    }
    // Método para registrar un nuevo trastorno
    public function registrarUsuarios() {
    // Asegúrate de que estos POST estén llegando desde JS
    $nombre = $_POST['nombre'] ?? '';
    $EntidadUser = $_POST['EntidadUser'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $rolUser = $_POST['rolUser'] ?? ''; // Asignar rol por defecto si no se proporciona

    // Aquí puedes encriptar la contraseña si lo deseas
    // $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $resultado = Usuario_model::registrarUsuario($nombre, $EntidadUser,$username,$rolUser,$password);

    if ($resultado) {
        echo json_encode([
            'status' => 'success',
            'username' => $username,
            'password' => $password
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'No se pudo registrar el usuario.'
        ]);
    }
}



        public function ctrAction($action, $params = [])
    {
        switch ($action) {

            case 'registrarUsuarios':
                $this->registrarUsuarios();
                break;
            case 'obtenerUsuarios':
                $this->obtenerUsuarios();
                break;
            default:
                echo json_encode([
                    "status" => "error",
                    "message" => "Acción no válida"
                ]);
                break;
        }
    }

}
if (isset($_POST['action'])) {
    $controller = new Usuario_controller();
    $controller->ctrAction($_POST['action']);
}