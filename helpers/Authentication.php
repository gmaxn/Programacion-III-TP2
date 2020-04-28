<?php
require_once __DIR__ . '\..\vendor\autoload.php';
require_once __DIR__ . '\..\repos\PersonasRepository.php';
require_once __DIR__ . '\..\entities\Persona.php';
require_once __DIR__ . '\..\config\environment.php';

use \Firebase\JWT\JWT;

class Authentication {

    public static function validateCredentials($email, $password)
    {
        $filename = __DIR__ . '\..\data\personas.txt';
        $persona =  PersonasRepository::findByEmail($filename, $email);

        if ($persona) {

            $hashedpass = $persona->password;

            if (password_verify($password, $hashedpass)) {

                return self::generateToken(
                    $persona->email,
                    $persona->firstname,
                    $persona->lastname,
                    $persona->userType,
                    strtotime('now'),
                    strtotime('now') +60
                );

            } else {

                throw new Exception('email and password do not match');
            }
        }

        throw new Exception('email not registered');
    }

    private static function generateToken($email, $firstname, $lastname, $userType, $iat, $exp) {

        $payload = array(
            "iat" => $iat,
            "exp" => $exp,
            "email" => $email,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "user_type" => $userType,
        );

        return JWT::encode($payload, getenv('ACCESS_TOKEN_SECRET'));
    }

    public static function authorizedUser($token) {

        try {

            $decoded = JWT::decode($token, getenv('ACCESS_TOKEN_SECRET'), array('HS256'));
            return $decoded;
        }
        catch (\Throwable $th) {

            if($th->getMessage() == 'Malformed UTF-8 characters') {

                throw new Exception('Invalid token');
            }
        }
    }
}