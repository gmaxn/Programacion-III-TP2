<?php
include_once __DIR__ . '\..\repos\PersonasRepository.php';

class Persona {

    public $id;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $telephone;
    public $userType;

    public function __construct($email, $password, $firstname, $lastname, $telephone, $userType)
    {
        $this->id = strtotime('now');
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->telephone = $telephone;
        $this->userType = $userType;
    }

    public function save($saveType = 'Serialized')
    {
        $result = null;

        if ($this->email && $this->password && $this->firstname && $this->lastname && $this->telephone && $this->userType) {
            
            $filename = __DIR__ . '\..\data\personas.txt';
            $result = PersonasRepository::save($filename, $this);
        }

        return $result;
    }

    public static function findByEmail($email)
    {
        $filename = __DIR__ . '\..\data\personas.txt';
        $result = PersonasRepository::findByEmail($filename, $email);
        return $result;
    }

    public static function getDetailsByUserType($userType)
    {
        $filename = __DIR__ . '\..\data\personas.txt';

        $list = array();
        
        if($userType == 'admin')
        {
            $list = PersonasRepository::readAll($filename);
        }

        if($userType == 'user')
        {
            $list = PersonasRepository::fetchByUserType($filename, $userType);
        }

        return $list;
    }  
}