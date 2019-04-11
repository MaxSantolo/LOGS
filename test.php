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






$sql = "SELECT * FROM users WHERE bookid = 212";
$sql2 = "SELECT * FROM users WHERE bookid = 719";
echo "<HR>";

try {
    $query = $conn->query($sql);
    $query2 = $conn->query($sql2);
    if ($query === FALSE || $query2 === FALSE) {
        throw new Exception($conn->error);
    }
    else {
        $result = $query->fetch_assoc();
        $result2 = $query2->fetch_assoc();
        print_r($result);
        echo "<BR>";
        print_r($result2);

    }
} catch(Exception $e) {
    echo $e;
}













builder::Scripts();



?>
</div>
<script type="text/javascript">
    $(".autocomplete").chosen();
    $(".chzn-container").css({"left":"20%"});
</script>

</html>