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

if (isset($_POST['app'])) $app = $_POST['app'];
else { (isset($_GET['app'])) ? $app = $_GET['app'] : Log::wLog("Chiamata senza applicazione specificata",'Errore'); }

if (isset($_POST['action'])) $action = $_POST['action'];
else { (isset($_GET['action'])) ? $action = $_GET['action'] : $action = 'UNIDENTIFIED'; }

if (isset($_POST['user'])) $user = $_POST['user'];
else { (isset($_GET['user'])) ? $user = $_GET['user'] : $user = 'SISTEMA'; }

if (isset($_POST['content'])) $content = $_POST['content'];
else { (isset($_GET['content'])) ? $content = json_decode($_GET['content']) : Log::wLog("Chiamata senza contenuto", "Errore"); }

if (isset($_POST['description'])) $description = $_POST['description'];
else { (isset($_GET['description'])) ? $description = $_GET['description'] : $description = $action; }

if (isset($_POST['origin'])) $origin = $_POST['origin'];
else { (isset($_GET['origin'])) ? $origin = $_GET['origin'] : $origin = strtoupper($app); }

if (isset($_POST['destination'])) $destination = $_POST['destination'];
else { (isset($_GET['destination'])) ? $destination = $_GET['destination'] : $destination = ""; }

$plog = new PickLog();

$path = $_SERVER['DOCUMENT_ROOT'].'/logs/'.strtoupper($app);
echo $path;
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

$plog->write2File($app,$content,$action,$user,$description,$origin,$destination);



