<?php

class PersonasRepository {

    public static function saveSerialized($filename, $data) {

        $file = fopen($filename, 'a');
        $result = fwrite($file, serialize($data));
        fclose($file);
        return $result ?? false;
    }
}