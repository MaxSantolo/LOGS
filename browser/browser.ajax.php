<?php
/**
 * Created by PhpStorm.
 * User: msantolo
 * Date: 01/04/2019
 * Time: 11:17
 */

isset($_POST['file']) ? $file = $_POST['file'] : $file = "";
isset($_POST['command']) ? $command = $_POST['command'] : $command = '';
if ($command == 'open') {
    if ($file == "") {
        echo "Nessun dato";
    } else {

        $contents = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $file);
        echo $log = str_replace(array("\r\n", "\r", "\n"), "<BR>", $contents);

    }
}
if ($file != "" && $command == 'delete') {

       unlink($_SERVER['DOCUMENT_ROOT'] . $file);

}

