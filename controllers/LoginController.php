<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function login(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // Comprobar que existe el usuario
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {

                    // Autenticar usuario
                    if ($usuario->comprarPasswordAndVerificado($auth->password)) {

                        //Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " .  $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionamiento

                        if ($usuario->admin == 1) {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('/auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
       session_start();
       $_SESSION = [];
       header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {

                //Intenta encontrar el usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado == 1) {
                    // Generar un Token unic
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu email');
                    
                } else {

                    // No existe el usuario o no esta confirmado
                    Usuario::setAlerta('error', 'E-mail no existe o no esta confirmados');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('/auth/olvide', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        //Variables de errores y alertas
        $alertas = [];
        $error = false;

        //Obtener el token de la url
        $token = s($_GET['token'] ?? null);

        //Buscar usuario por su token
        $usuario = Usuario::where('token', $token);

        //Validar si el token es valido
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        //Realizar el cambio de password
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if (empty($alertas)) {
               //ELiminamos el password anterior
               $usuario->password = null;

               //Password en el objeto es cambiado
               $usuario->password = $password->password;

               //Se hashea el password
               $usuario->hashPassword();

               //eliminamos el token
               $usuario->token = null;

               //guardamos(Actualizamos el registro que ya existe);
               $resultado = $usuario->guardar();

               if ($resultado) {
                   header('Location: /');
               }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revistar si no hay errores;
            if (empty($alertas)) {
                //verificar que el usuario no este registrado

                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {

                    //Hashear el password
                    $usuario->hashPassword();

                    // Generar un Token unico
                    $usuario->crearToken();

                    //Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('/auth/crear-cuenta', [
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token'] ?? null);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        } else {

            //Confirmar el usuario
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada');
        }

        //Obtener alertas
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }
}
