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
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarLogin();

            if (empty($alertas)) {
                // verificar que el usuario exista 
                $usuario = Usuario::where('email', $usuario->email);

                if (!$usuario || !$usuario->confirmado) {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                } else {
                    // el usuario existe 
                    if (password_verify($_POST['password'], $usuario->password)) {
                        // inicar la sesion 
                        session_start();
                         
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar 
                        header('Location: /dashboard');
                        
                    } else {
                        Usuario::setAlerta('error', 'Password Incorrecto');

                    }
                }


            }

        }

        $alertas = Usuario::getAlertas();

        // Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion',
            'alertas' => $alertas

        ]);
    }

    public static function logout()
    {
        echo "desde logout";

    }


    public static function crear(Router $router)
    {
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuentas();

            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {

                    // hashear el password 
                    $usuario->hashPassword();

                    // Eliminar password2  
                    unset($usuario->password2);

                    // Generar el Token
                    $usuario->crearToken();


                    // crear un nuevo usuario
                    $resultado = $usuario->guardar();

                    // Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email->enviarConfirmacion();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }

            }


        }
        // Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crea tu cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if (empty($alertas)) {
                // buscar el usuario
                $usuario = Usuario::where('email', $usuario->email);
                // encontre a usuario
                if ($usuario && $usuario->confirmado) {
                    // general un nuevo token 
                    $usuario->crearToken();
                    unset($usuario->password2);


                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Imprimir alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');

                } else {
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');

                }

            }

        }

        $alertas = Usuario::getAlertas();

        // Render a olvide password
        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi Password',
            'alertas' => $alertas

        ]);
    }
    public static function reestablecer(Router $router)
    {
        $token = s($_GET['token']);
        $mostrar = true;

        if (!$token)
            header('Location: /');

        // Identificar el usuario con este token 
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Valido ');
            $mostrar = false;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // añadir el nuevo password 
            $usuario->sincronizar($_POST);

            // validar el password
            $alertas = $usuario->validarPassword();

            if (empty($alertas)) {
                // Hashear el nuevo password
                $usuario->hashPassword();


                // Eliminar el token
                $usuario->token = null;
                // guardar el usaurio en la BD 
                $resultado = $usuario->guardar();

                // Redireccionar
                if ($resultado) {
                    header('Location: /');
                }

            }



        }

        $alertas = Usuario::getAlertas();
        // Render desde restablecer password
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }


    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);

    }
    public static function confirmar(Router $router)
    {

        $alertas = [];

        $token = s($_GET['token']);

        if (!$token)
            header('Location: /');

        // encontrar al usuario con este token 
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no Valido');
        } else {

            // confirmar la cuenta
            $usuario->confirmado = '1';
            $usuario->token = null;
            unset($usuario->password2);
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');

        }

        // obtener alertas
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirma tu cuenta UpTask',
            'alertas' => $alertas
        ]);

    }



}
