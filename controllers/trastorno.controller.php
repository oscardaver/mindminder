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




    public function ctrAction($action, $params = [])
    {
        switch ($action) {

            case 'registrarTrastorno':
                $this->registrarTrastorno();
                break;
            case 'cargarTablaTrastornos':
                $this->obtenerTrastornos();
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