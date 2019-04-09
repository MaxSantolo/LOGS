<?php
/**
 * Created by PhpStorm.
 * User: msantolo
 * Date: 29/03/2019
 * Time: 12:02
 */
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/builder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/struct/classes/PickLog.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Log.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tech/class/PHPMailerAutoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Mail.php';

(isset($_POST['app'])) ? $app = $_POST['app'] : Log::wLog("Chiamata senza applicazione specificata",'Errore');
(isset($_POST['action'])) ? $action = $_POST['action'] : $action = 'UNIDENTIFIED';
(isset($_POST['user'])) ? $user = $_POST['user'] : $user = 'SISTEMA';
(isset($_POST['content'])) ? $content = $_POST['content'] : Log::wLog("Chiamata senza contenuto", "Errore");
(isset($_POST['description'])) ? $description = $_POST['description'] : $description = $action;
(isset($_POST['origin'])) ? $origin = $_POST['origin'] : $origin = $app;
(isset($_POST['destination'])) ? $destination = $_POST['destination'] : $destination = '';

$plog = new PickLog();

$path = $_SERVER['DOCUMENT_ROOT'].'/logs/'.strtoupper($app);
echo $path;
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

$plog->write2File($app,$content,$action,$user,$description,$origin,$destination);



