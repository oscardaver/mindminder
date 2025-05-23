<?php

require_once '../models/login.model.php';
class Login_controller{

public function login(){

            $loginUser = trim($_POST['loginUser']);
            $Loginpass = $_POST['Loginpass'];

        $user = Login_model::getUserByUsername($loginUser);

        if ($user) {
            // Aquí puedes validar también si el usuario está activo
            if ($user['estado'] != 1) {
            echo json_encode([
                'success' => false,
                'message' => 'Usuario inactivo.'
            ]);
            exit;
            }

            // Validación de contraseña
            if ($user['pass'] === $Loginpass) { // solo si las contraseñas están en texto plano (no recomendado)
            session_start();
            $_SESSION['idUsuario'] = $user['idUsuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['rol'] = $user['rol'];

            echo json_encode([
                'success' => true,
                'message' => 'Inicio de sesión exitoso.'
            ]);
            exit;
            }
        }

        echo json_encode([
            'success' => false,
            'message' => 'Usuario o contraseña incorrectos.'
        ]);
        exit;
        }

    public function ctrAction($action, $params = [])
    {
        switch ($action) {

            case 'login':
                $this->login();
                break;
           
        }
    }
}

if (isset($_POST['action'])) {
    $controller = new Login_controller();
    $controller->ctrAction($_POST['action']);
}




