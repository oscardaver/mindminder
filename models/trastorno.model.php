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
}