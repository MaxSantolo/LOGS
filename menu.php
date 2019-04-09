<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/builder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/struct/classes/PickLog.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Log.php';

builder::startSession();
builder::Header(".logs {$_SESSION['version']} - Menu Principale");
builder::Navbar('DataTable');

//html
echo "
<div style=\"width: 600px;margin: auto;padding: 10px\"><br><br><br><br><img src=\"images/logo_logs.png\" width=\"550\">
<br />

</div>
";

builder::Scripts();


