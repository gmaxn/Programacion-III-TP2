<?php

class PersonasRepository
{
    public static function save($filename, $data)
    {
        $array = array();

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

        try {

            $file = fopen($filename, 'r');
            $stream = fread($file, filesize($filename));
            $list = unserialize($stream);
            fclose($file);

        } catch (\Throwable $th) {

            echo $th->getMessage();
        }

        return $list ?? false;
    }

    public static function fetchByUserType($filename, $userType) {

        try {

            $file = fopen($filename, 'r');
            $stream = fread($file, filesize($filename));
            $list = unserialize($stream);
            fclose($file);
            $resultSet = array();

        } catch (\Throwable $th) {

            echo $th->getMessage();
        }

        foreach ($list as $persona) {

            if ($persona->userType == $userType) {

                array_push($resultSet, $persona);
            }
        }
        return $resultSet ?? false;
    }

    public static function findByEmail($filename, $email)
    {
        try {

            $file = fopen($filename, 'r');
            $stream = fread($file, filesize($filename));
            $list = unserialize($stream);
            fclose($file);

        } catch (\Throwable $th) {

            echo $th->getMessage();
        }

        foreach ($list as $persona) {

            if ($persona->email == $email) {

                return $persona;
            }
        }
        return false;
    }
}
