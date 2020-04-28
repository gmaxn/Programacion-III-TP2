<?php

class PersonasRepository
{
    public static function save($filename, $data)
    {
        $list = array();

        if (file_exists($filename)) {

            $file = fopen($filename, 'r');
            $stream = fread($file, filesize($filename));
            $list = unserialize($stream);
            fclose($file);
        }

        array_push($list, $data);

        $file = fopen($filename, 'w');
        $result = fwrite($file, serialize($list));
        fclose($file);

        return $result ?? false;
    }

    public static function readAll($filename) {

        if(!file_exists($filename))
        {
            throw new Exception('File not found');
        }

        $file = fopen($filename, 'r');
        $stream = fread($file, filesize($filename));
        $list = unserialize($stream);
        fclose($file);

        return $list ?? false;
    }

    public static function fetchByUserType($filename, $userType) {

        if(!file_exists($filename))
        {
            throw new Exception('File not found');
        }

        if($userType == null || $userType == '')
        {
            throw new Exception('User Type is null or empty');
        }

        $file = fopen($filename, 'r');
        $stream = fread($file, filesize($filename));
        $list = unserialize($stream);
        fclose($file);
        $resultSet = array();

        foreach ($list as $persona) {

            if ($persona->userType == $userType) {

                array_push($resultSet, $persona);
            }
        }

        return $resultSet ?? false;
    }

    public static function findByEmail($filename, $email)
    {

        if(!file_exists($filename))
        {
            throw new Exception('File not found');
        }

        if($email == null || $email == '')
        {
            throw new Exception('Email is null or empty');
        }

        $file = fopen($filename, 'r');
        $stream = fread($file, filesize($filename));
        $list = unserialize($stream);
        fclose($file);

        foreach ($list as $persona) {

            if ($persona->email == $email) {

                return $persona;
            }
        }
        return false;
    }
}
