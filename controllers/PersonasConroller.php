<?php
require_once __DIR__ . '\..\Entities\Persona.php';
require_once __DIR__ . '\..\helpers\Response.php';
require_once __DIR__ . '\..\helpers\HttpHelper.php';

class PersonasController {

    private $path_info;
    private $request_method;

    function getRoute(){
        return $this->request_method . $this->path_info;
    }

    function __construct() {

        $this->path_info = $_SERVER['PATH_INFO'] ?? '';
        $this->request_method = $_SERVER['REQUEST_METHOD'] ?? '';
    }


    function start() {

        switch($this->getRoute()) {

            case 'GET/personas/csv':
                $legajo = $_GET['legajo'] ?? 0;
                echo $this->getPersonasCSV($legajo);
            break;
        
            case 'POST/personas/csv':
                $nombre =   $_POST['nombre'] ?? false;
                $apellido = $_POST['apellido'] ?? false;
                $legajo =   $_POST['legajo'] ?? false;
                echo $this->postPersonasCSV($nombre, $apellido, $legajo);
            break;

            case 'GET/personas/json':
                $legajo = $_GET['legajo'] ?? 0;
                echo $this->getPersonasJSON($legajo);
            break;
        
            case 'POST/personas/json':
                $nombre =   $_POST['nombre'] ?? false;
                $apellido = $_POST['apellido'] ?? false;
                $legajo =   $_POST['legajo'] ?? false;
                $photo = $_FILES['photo'] ?? null;
                echo $this->postPersonasJSON($nombre, $apellido, $legajo, $photo);
            break;

            case 'PUT/personas/json':     
                $_PUT = HttpHelper::getputcontent();
                $nombre = $_PUT['nombre'] ?? false;
                $apellido = $_PUT['apellido'] ?? false;
                $legajo = $_PUT['legajo'] ?? false;
                $photo = $_PUT['photo'] ?? null;
                echo $this->putPersonasJSON($nombre, $apellido, $legajo, $photo);
            break;
        
            case 'DELETE/personas/json':
                $_DELETE = HttpHelper::getputcontent();
                $legajo = $_DELETE['legajo'] ?? 0;
                echo $this->deletePersonasJSON($legajo);
            break;
        
            default:
                echo 'Metodo no esperado';
            break;
        }
    }


    // GET/personas/json
    function getPersonasJSON($id = 0) {

        $response = new Response('Registro no encontrado');
        
        $persona = Persona::readJSON($id);

        if($persona) {
 
            $response->status = 'Succeed';
            $response->data = $persona;
        }
        
        $response = json_encode($response);

        echo $response;
    }


    // POST/personas/json
    function postPersonasJSON($nombre, $apellido, $legajo, $photo) {

        $response = new Response('faltan datos');

        $persona = new Persona($nombre, $apellido, $legajo, $photo);

        if($persona->saveJSON()) {

            $response->status = 'Succeed';
            $response->data = $persona;
        }

        $response = json_encode($response);
        
        echo $response;
    }

    // PUT/personas/json
    function putPersonasJSON($nombre, $apellido, $legajo, $photo) {


        $response = new Response('faltan datos');

        $persona = new Persona($nombre, $apellido, $legajo, $photo);

        if($persona->updateJSON()) {

            $response->status = 'Succeed';
            $response->data = $persona;
        }

        $response = json_encode($response);
        
        echo $response;
    }

    // DELETE/personas/json
    function deletePersonasJSON($id) {

        $response = new Response('Registro no encontrado');
        
        $persona = Persona::deleteJSON($id);

        if($persona) {
    
            $response->status = 'Succeed';
            $response->data = $persona;
        }
        
        $response = json_encode($response);

        echo $response;
    }
}