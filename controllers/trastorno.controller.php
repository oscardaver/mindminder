<?php
require_once '../models/trastorno.model.php';

class Trastorno_controller{


    public function obtenerTrastornos(){
        $resultado = Trastorno_model::obtenerTrastornos();
        echo json_encode(["data" => $resultado]);
    }

    // Método para registrar un nuevo trastorno
    public function registrarTrastorno(){
        $nombre = $_POST['nombreTrastorno'] ?? '';
        $descripcion = $_POST['descripcionTrastorno'] ?? '';

        if (!empty($nombre) && !empty($descripcion)) {
            $resultado = Trastorno_model::registrar($nombre, $descripcion);
            echo $resultado ? 'success' : 'error';
        } else {
            echo 'error';
        }
    }

    public function eliminarTrastorno(){
        $id = $_POST['id'] ?? '';
        if (!empty($id)) {
            $resultado = Trastorno_model::eliminarTrastorno($id);
            echo $resultado ? 'success' : 'error';
        } else {
            echo 'error';
        }
    }

    public function obtenerTrastornoEditar(){
        $id = $_POST['id'] ?? '';
       if (!empty($id)) {
    $resultado = Trastorno_model::obtenerTrastornoEditar($id);
        if ($resultado) {
            echo json_encode(['success' => true, 'data' => $resultado]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Trastorno no encontrado']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
    }

    }

    public function editarTrastorno(){
        $editarId = $_POST['editarId'] ?? '';
        $editarNombre = $_POST['editarNombre'] ?? '';
        $editarDescripcion = $_POST['editarDescripcion'] ?? '';

        if (!empty($editarId) && !empty($editarNombre) && !empty($editarDescripcion)) {
            $resultado = Trastorno_model::actualizarTrastorno($editarId, $editarNombre, $editarDescripcion);
            if ($resultado) {
            echo json_encode(['success' => true, 'data' => $resultado]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Trastorno no actualizado']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID no proporcionado']);
    }
    }



    public function ctrAction($action, $params = [])
    {
        switch ($action) {

            case 'registrarTrastorno':
                $this->registrarTrastorno();
                break;
            case 'cargarTablaTrastornos':
                $this->obtenerTrastornos();
                break;
            case 'eliminarTrastorno':
                $this->eliminarTrastorno();
                break;
            
            case 'obtenerTrastorno':
                $this->obtenerTrastornoEditar();
                break;
            
            case 'editarTrastorno':
                $this->editarTrastorno();
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
    $controller = new Trastorno_controller();
    $controller->ctrAction($_POST['action']);
}