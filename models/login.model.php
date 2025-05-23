<?php
require_once '../config/conexion.php'; // conexión PDO en $pdo


class Login_model{

    public static function getUserByUsername($loginUser) {
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT idUsuario, pass, estado, rol, nombre FROM usuario WHERE user = :loginUser LIMIT 1");
        $stmt->bindParam(':loginUser', $loginUser, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}