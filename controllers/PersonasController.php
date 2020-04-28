<?php
require_once __DIR__ . '\..\entities\Persona.php';
require_once __DIR__ . '\..\helpers\Response.php';
require_once __DIR__ . '\..\helpers\HttpHelper.php';
require_once __DIR__ . '\..\helpers\Authentication.php';

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

                $loginDto = new stdClass();
                $loginDto->email = $_POST['email'] ?? false;
                $loginDto->password = $_POST['clave'] ?? false;

                echo $this->postPersonasLogin($loginDto);
            break;

            case 'GET/personas/details':

                $headers = getallheaders();
                $jwt = $headers['Authorization'];

                echo $this->getPersonasDetails($jwt);
            break;

            case 'GET/personas/list':

                $headers = getallheaders();
                $jwt = $headers['Authorization'];

                echo $this->getPersonasList($jwt);
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
        
        $persona->save('Serialized');
        $persona->password = "***";

        if($persona) {
 
            $response->status = 'Succeed';
            $response->data = $persona;
        }
        
        $response = json_encode($response);

        echo $response;
    }

    // POST/personas/login
    function postPersonasLogin($loginDto) {

        $response = new Response('faltan datos');

        $result = Authentication::validateCredentials($loginDto->email, $loginDto->password);

        if($result) {

            $jwt = new stdClass();
            $jwt->token = $result;
            $response->status = 'Succeed';
            $response->data = $jwt;
        }

        $response = json_encode($response);

        echo $response;
    }

    // GET/personas/details
    function getPersonasDetails($jwt) {

        $response = new Response('faltan datos');
        $userContext = Authentication::authorizedUser($jwt);

        if(!isset($userContext->email))
        {
            $response->status = 'failure';
            $response->data = $userContext->errorMessage;
        }

        if(isset($userContext->email))
        {
            $persona = Persona::findByEmail($userContext->email);

            if($persona != null)
            {
                $response->status = 'Success';
                $response->data = $persona; 
            }
            else
            {
                $response->status = 'Success';
                $response->data = 'Persona not found'; 
            }
        }

        $response = json_encode($response);

        echo $response;
    }

    // GET/personas/list
    function getPersonasList($jwt) {

        $response = new Response('faltan datos');
        $userContext = Authentication::authorizedUser($jwt);

        if(!isset($userContext->user_type))
        {
            $response->status = 'failure';
            $response->data = $userContext->errorMessage;
        }

        if(isset($userContext->user_type))
        {
            $personas = Persona::getDetailsByUserType($userContext->user_type);
                
            if($personas != null)
            {
                $response->status = 'Success';
                $response->data = $personas; 
            }
        }

        $response = json_encode($response);

        echo $response;
    }
}