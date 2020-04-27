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

            case 'POST/personas/signin':

                $personasDto = new stdClass();
                $personasDto->email = $_POST['email'] ?? false;
                $personasDto->password = $_POST['clave'] ?? false;
                $personasDto->firstname = $_POST['nombre'] ?? false;
                $personasDto->lastname = $_POST['apellido'] ?? false;
                $personasDto->telephone = $_POST['telefono'] ?? false;
                $personasDto->userType = $_POST['tipo'] ?? false;

                echo $this->postPersonasCreate($personasDto);

            break;
        
            case 'POST/personas/login':
                $nombre =   $_POST['nombre'] ?? false;
                $apellido = $_POST['apellido'] ?? false;
                $legajo =   $_POST['legajo'] ?? false;
                echo $this->postPersonasCSV($nombre, $apellido, $legajo);
            break;
        
            default:
                echo 'Metodo no esperado';
            break;
        }
    }


    // POST/personas/signin
    function postPersonasCreate($personasDto) {

        $response = new Response('faltan datos');

        $persona = new Persona (
            $personasDto->email,
            password_hash($personasDto->password, PASSWORD_DEFAULT),
            $personasDto->firstname, 
            $personasDto->lastname, 
            $personasDto->telephone, 
            $personasDto->userType
        );
        
        $persona->save();
        $persona->password = "***";

        if($persona) {
 
            $response->status = 'Succeed';
            $response->data = $persona;
        }
        
        $response = json_encode($response);

        echo $response;
    }
}