<?php
require_once '../config/conexion.php';

class Trastorno_model
{


    public static function obtenerTrastornos()
    {
        $pdo = Database::connect();
        $query = "SELECT codigoTrastorno, nombre, descripcion FROM trastorno";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function registrar($nombre, $descripcion)
    {
        $pdo = Database::connect();
        $query = "INSERT INTO trastorno (nombre, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt->execute();
    }

    public static function eliminarTrastorno($id)
    {
        $pdo = Database::connect();
        $query = "DELETE FROM trastorno WHERE codigoTrastorno = '$id'";
        error_log("Executing query: $query"); // Log the query for debugging
        $stmt = $pdo->prepare($query);
        //$stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function obtenerTrastornoEditar($id)
    {
        $pdo = Database::connect();
        $query = "SELECT codigoTrastorno, nombre, descripcion FROM trastorno WHERE codigoTrastorno = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizarTrastorno($id, $nombre, $descripcion)
    {
        error_log("Updating trastorno with ID: $id, nombre: $nombre, descripcion: $descripcion"); // Log the parameters for debugging
        $pdo = Database::connect();
        $query = "UPDATE trastorno SET nombre = :nombre, descripcion = :descripcion WHERE codigoTrastorno = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);

        return $stmt->execute();
    }
}