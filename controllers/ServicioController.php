<?php

namespace Controllers;

use Model\Servicios;
use MVC\Router;

class ServicioController
{

    public static function index(Router $router)
    {

        session_start();
        isAdmin();

        $servicio = Servicios::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicio
        ]);
    }

    public static function crear(Router $router)
    {

        session_start();
        isAdmin();

        $servicio = new Servicios;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Sincronizamos el objeto con los datos enviados
            $servicio->sincronizar($_POST);

            //Validamos
            $alertas = $servicio->validar();

            //Creamos el servicio
            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'nombreServicio' => $servicio->nombre,
            'precioServicio' => $servicio->precio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();
        isAdmin();

        try {
            $id = s($_GET['id']) ?? null;
            $alertas = [];

            if (!$id || !is_numeric($id)) {
                header('Location: /servicios');
            }

            $servicio = Servicios::find($id);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //Sincronizamos el objeto con los datos enviados
                $servicio->sincronizar($_POST);

                //Validamos
                $alertas = $servicio->validar();

                //Creamos el servicio
                if (empty($alertas)) {
                    $servicio->guardar();
                    header('Location: /servicios');
                }
            }
        } catch (\Throwable $th) {
            header('Location: /servicios');
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'nombreServicio' => $servicio->nombre ?? '',
            'precioServicio' => $servicio->precio ?? '',
            'alertas' => $alertas

        ]);
    }

    public static function eliminar()
    {
        session_start();
        isAdmin();

        try {

            $id = s($_POST['id']) ?? null;
            if (!$id || !is_numeric($id)) {
                header('Location: /servicios');
            }
            $servicio = Servicios::find($id);

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $servicio->eliminar();
                header('Location: /servicios');
            }
        } catch (\Throwable $th) {

            header('Location: /servicios');
        }
    }
}
