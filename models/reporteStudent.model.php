<?php

require_once(__DIR__ . '/../config/conexion.php');


class ReporteStudent_model {


    public function obtenerOrganizcion(){
        $pdoQueue = Database::connect();
        $sql = "SELECT DISTINCT codigoOrganizacion, codigoEntidad, nombre FROM `organizacion`";
        $result = $pdoQueue->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

      public function obtenerSubOrganizcion(){
        $pdoQueue = Database::connect();
        $sql = "SELECT DISTINCT codigoSub, codigoOrganizacion, nombre FROM `suborganizacion`";
        $result = $pdoQueue->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerEstudiantes($fechaInicio, $fechaFin, $codigoEstudiante, $filtroCarrera, $filtroOrganizacion){
    $pdoQueue = Database::connect();
    $sql = "SELECT codigoEstudiante, fechaRegistro, nombre, carrera, organizacion
            FROM estudiantes
            WHERE fechaRegistro BETWEEN :fechaInicio AND :fechaFin";

    if (!empty($codigoEstudiante)) {
        $sql .= " AND codigoEstudiante LIKE :codigoEstudiante";
    }

    if (!empty($filtroCarrera)) {
        $strfiltroCarrera = $this->convertToStringWithQuotes($filtroCarrera);
        $sql .= " AND carrera IN ($strfiltroCarrera)";
    }

    if (!empty($filtroOrganizacion)) {
        $strfiltroOrg = $this->convertToStringWithQuotes($filtroOrganizacion);
        $sql .= " AND organizacion IN ($strfiltroOrg)";
    }

    $sql .= " ORDER BY carrera ASC";

    error_log("SQL Query: " . $sql);

    $stmt = $pdoQueue->prepare($sql);
    $stmt->bindParam(':fechaInicio', $fechaInicio);
    $stmt->bindParam(':fechaFin', $fechaFin);

    if (!empty($codigoEstudiante)) {
        $codigoEstudiante = "%$codigoEstudiante%";
        $stmt->bindParam(':codigoEstudiante', $codigoEstudiante);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



public static function subirEstudiantes($registros) {
    try {
        $pdo = Database::connect();

        $insertSQL = "INSERT INTO estudiantes (
            codigoEstudiante, fechaRegistro, nombre, carrera, organizacion, semestre, estado, trastorno, nivel
        ) VALUES (
            :codigoEstudiante, :fechaRegistro, :nombre, :carrera, :organizacion, :semestre, :estado, :trastorno, :nivel
        )";

        $updateSQL = "UPDATE estudiantes SET
            fechaRegistro = :fechaRegistro,
            nombre = :nombre,
            carrera = :carrera,
            organizacion = :organizacion,
            semestre = :semestre,
            estado = :estado,
            trastorno = :trastorno,
            nivel = :nivel
        WHERE codigoEstudiante = :codigoEstudiante";

        $stmtInsert = $pdo->prepare($insertSQL);
        $stmtUpdate = $pdo->prepare($updateSQL);

        foreach ($registros as $estudiante) {
            // Verificamos si ya existe
            $checkSQL = "SELECT COUNT(*) FROM estudiantes WHERE codigoEstudiante = ?";
            $stmtCheck = $pdo->prepare($checkSQL);
            $stmtCheck->execute([$estudiante['codigoEstudiante']]);
            $exists = $stmtCheck->fetchColumn() > 0;

            $params = [
                ':codigoEstudiante' => $estudiante['codigoEstudiante'],
                ':fechaRegistro'    => $estudiante['fechaRegistro'],
                ':nombre'           => $estudiante['nombre'],
                ':carrera'          => $estudiante['carrera'],
                ':organizacion'     => $estudiante['organizacion'],
                ':semestre'         => $estudiante['semestre'],
                ':estado'           => $estudiante['estado'],
                ':trastorno'        => $estudiante['trastorno'],
                ':nivel'            => $estudiante['nivel']
            ];

            if ($exists) {
                $stmtUpdate->execute($params);
            } else {
                $stmtInsert->execute($params);
            }
        }

        return [
            'success' => true,
            'message' => 'Estudiantes insertados o actualizados correctamente.'
        ];

    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => 'Error al insertar o actualizar estudiantes: ' . $e->getMessage()
        ];
    }
}




    private function convertToStringWithQuotes($array)
    {
        $quotedValues = array_map(function ($value) {
            return "'$value'";
        }, $array);
        $stringSeparatedByCommas = implode(", ", $quotedValues);
        return $stringSeparatedByCommas;
    }
}