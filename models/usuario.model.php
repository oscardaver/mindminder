<?php

require_once(__DIR__ . '/../config/conexion.php');

class Usuario_model
{
public static function obtenerUsuarios()
{
    try {
        $pdo = Database::connect();
        
        // Verificar conexión
        if (!$pdo) {
            return false;
        }
        
        $query = "SELECT 
        u.nombre, 
        u.codigoEntidad, 
        e.razonSocial AS nombreEntidad,  -- Nuevo campo
        u.user, 
        u.rol, 
        u.estado 
    FROM usuario u
    LEFT JOIN entidad e ON u.codigoEntidad = e.codigoEntidad";
        $stmt = $pdo->prepare($query);
        
        if (!$stmt->execute()) {
            return false;
        }
        
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Verificar que los datos tengan la estructura correcta
        return $resultado ? $resultado : [];
        
    } catch (PDOException $e) {
        error_log("Error en obtenerUsuarios: " . $e->getMessage());
        return false;
    }
}

    public static function registrarUsuario($nombre, $EntidadUser,$username,$rolUser, $password)
    {
        $pdo = Database::connect();
        $query = "INSERT INTO usuario (codigoEntidad, nombre, rol, user, pass, estado) VALUES (:codigoEntidad,:nombre, :rol, :user, :pass,1)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':codigoEntidad', $EntidadUser);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':rol', $rolUser);
        $stmt->bindParam(':user', $username);
        $stmt->bindParam(':pass', $password);

        return $stmt->execute();
    }

    public function obtenerEntidades(){
        $pdoQueue = Database::connect();
        $sql = "SELECT DISTINCT codigoEntidad, razonSocial FROM `entidad`";
        $result = $pdoQueue->prepare($sql);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}