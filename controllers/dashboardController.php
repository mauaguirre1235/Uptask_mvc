<?php

namespace Controllers;

use MVC\Router;

class DashboardController
{

    public static function index(Router $router)
    {
        session_start();

        // protege la ruta
        isAuth();

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }

}