<?php
require_once(__DIR__ . '/../models/reporteStudent.model.php');

class reporteStudent_controller {



    public function mostrarOrganizacion(){
        $model = new ReporteStudent_model();
        $result = $model->obtenerOrganizcion();
        return $result;
    }
    public function mostrarSubOrganizacion(){
        $model = new ReporteStudent_model();
        $result = $model->obtenerSubOrganizcion();
        return $result;
    }

    public function buscarEstudiante(){
        $fechaIncio = isset($_POST['fechaInicio']) ? $_POST['fechaInicio'] : date('Y-m-d');
        $fechaFin = isset($_POST['fechaFin']) ? $_POST['fechaFin'] : date('Y-m-d');
        $codigoEstudiante = isset($_POST['codigoEstudiante']) ? $_POST['codigoEstudiante'] : '';
        $filtroCarrera = isset($_POST['filtroCarrera']) ? $_POST['filtroCarrera'] : [];
        $filtroOrganizacion = isset($_POST['filtroOrganizacion']) ? $_POST['filtroOrganizacion'] : [];



        $model = new ReporteStudent_model();
        $stmt = $model->obtenerEstudiantes($fechaIncio, $fechaFin, $codigoEstudiante, $filtroCarrera, $filtroOrganizacion);

        if (!empty($stmt)) {
            echo json_encode([
                "status" => "success",
                "buscarEstudiantes" => $stmt
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "No se encontraron Datos del Contactos."
            ]);
        }
        exit;


    }


    public function subirEstudiantes() {
        $registrosJson = $_POST['registros'] ?? '';
        $registros = json_decode($registrosJson, true);

        if (!is_array($registros) || empty($registros)) {
            echo json_encode([
                'success' => false,
                'message' => 'No se recibieron registros válidos.'
            ]);
            return;
        }
        $model = new ReporteStudent_model();
        $resultado = $model->subirEstudiantes($registros);

        echo json_encode($resultado);
    }



    public function ctrAction($action, $params = [])
    {
        switch ($action) {

            case 'buscarEstudiantes':
                $this->buscarEstudiante();
                break;

            case 'subirEstudiantes':
                $this->subirEstudiantes();
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
    $controller = new reporteStudent_controller();
    $controller->ctrAction($_POST['action']);
}