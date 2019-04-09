<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/builder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/struct/classes/PickLog.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Log.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tech/class/PHPMailerAutoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Mail.php';

builder::startSession();
builder::Header('.logs - Test Page');
builder::Navbar('DataTable');


//PMSBase::CheckCreateAccounts();






?>





<div style="width: 600px;margin: auto;padding: 10px"><br><br><br><br><img src="images/logo_logs.png" width="550"> </div>

<div class="logContainer">
<?php

$db = new DB;
$conn = $db->getProdConn('crm_punti');


/*$plog = new PickLog();



$results2 = $conn->query("SELECT * FROM users WHERE bookid != 212");
$text2 = urlencode($plog->sql2Text($results2) . "(" . $conn->affected_rows . " righe)");

echo urldecode($text2);


$res = $plog->sendLog(array('app' => 'AGENT','action' => 'GET__USER_NOT212','content' => $text2,'user' => 'Max', 'description' => 'utenti non 212', 'origin' => 'crm_punti_users', 'destination' => 'sito',));*/


echo json_decode("Questa è una stringa di test per il decode!");




builder::Scripts();



?>
</div>
<script type="text/javascript">
    $(".autocomplete").chosen();
    $(".chzn-container").css({"left":"20%"});
</script>

</html>