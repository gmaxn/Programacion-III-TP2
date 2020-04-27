<?php
date_default_timezone_set('America/Argentina/Buenos_Aires');
require_once __DIR__ . '\controllers\PersonasController.php';


$path_info = $_SERVER['PATH_INFO'] ?? '';

$resource = '/' . explode('/', $path_info)[1] ?? '';

switch ($resource) {

    case '/personas':
        $controller = new PersonasController();
        $controller->start();
    break;

    case '/alumnos':
        echo 'sarasa';
    break;

    default:
        echo $resource . 'is not a valid resource';
    break;
}