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


    public function save($saveType = 'Serialized') {

        if($this->email && $this->password && $this->firstname && $this->lastname && $this->telephone && $this->userType) {

            $filename = __DIR__ . '\..\data\personas.txt';
            return PersonasRepository::saveSerialized($filename, $this);
        }
        
        return false;
    }
    
    ////////////////////
    // HELPER METHODS //
    ////////////////////
    public function toJSON() {

        return json_encode($this);
    }

    public function toCSV() {

        return $this->nombre . ',' . $this->apellido . ',' . $this->legajo . ',' . $this->photo . PHP_EOL;
    }

    public function isDefaultPhoto() {

        return ($this->file == '\..\Data\Photos\default.jpg') ? true : false;
    }
}