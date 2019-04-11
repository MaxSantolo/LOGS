<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/builder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/struct/classes/PickLog.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Log.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/tech/class/PHPMailerAutoload.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/struct/classes/Mail.php';

builder::startSession();
builder::Header('.logs - Browser');
builder::Navbar('DataTable');


?>
<p class='titolo'>.log browser</p>;
<div class="logContainer">

    <!-- view modal -->
    <div class="modal fade" id="viewLogModal" tabindex="-1" role="dialog" aria-labelledby="viewLogModal" aria-hidden="true">
        <div class="modal-dialog modal-fluid" role="document">
            <div class="modal-content" style="background-color: rgba(250,250,250,.85)">
                <div class="modal-header" style="background-color: rgba(89,12,15,.85);color: white">
                    <h5 class="modal-title" id="exampleModalPreviewLabel">Dettaglio del log</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="text-white">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="viewLogModalBody">
                    ...
                </div>
            </div>
        </div>
    </div>


<?php

$db = new DB;
$conn = $db->getProdConn('crm_punti');

/*
$plog = new PickLog();



$results2 = $conn->query("SELECT * FROM users WHERE bookid = 212");
$text2 = urlencode($plog->sql2Text($results2) . "(" . $conn->affected_rows . " righe)");


echo $res = $plog->sendLog(array('app' => 'PMS','action' => 'GET__USER_212','content' => $text2,'user' => 'Max',));*/

function dirToArray($dir) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }

    return $result;
}

$root = $_SERVER['DOCUMENT_ROOT'].'/logs/';
$dirarray = (dirToArray($root));

echo "<table class=\"table table-bordered table-striped table-sm table-dark\">
<thead style='background-color: rgb(89,12,15)' ><th class='font-weight-bold'>APPLICAZIONE</th><th class='font-weight-bold'>FILE DI LOG</th></thead>";

foreach( $dirarray as $dir => $files) {
    echo "<tr><td>". $dir . "</td><td class='text-white'>";
    foreach( $files as $file) {
        $link = "/logs/". $dir . "/" . $file;
        if (substr($link,-3) == 'txt') {
            echo "<p><A HREF='#' data-toggle=\"modal\" data-target=\"#viewLogModal\" class='text-info font-weight-bold loglink' data-file='{$link}' data-command='open'>" . $file . "</A> - 
             <a href='{$link}' download><img src='/images/dload_txt.png' width='20' title='SCARICA'></a>
             <a href='{$link}' target='_blank'><img src='/images/link_txt.png' width='20' hspace='5' title='APRI PER STAMPA'></a>
             <a href='#' class='logdelete' data-file='{$link}' data-command='delete'><img src='/images/del_txt.png' width='20' title='ELIMINA'></a>
            </p>"; //HREF='{$link}'
        }
    }
    echo "</td></tr>";
}






builder::Scripts();
echo "

    <script>    
                $(document).on('click', '.loglink', function(e){
                            e.preventDefault();
                            var file = $(this).data('file');
                            var command = $(this).data('command');
                            console.log(file);
                $.ajax({
                    type: 'POST',
                    url: 'browser.ajax.php',
                    data: {file: file, command: command},
                    success: function(data){
                        $('#viewLogModalBody').html(data);}
                    });
                });
    </script>

    <script>    
                $(document).on('click', '.logdelete', function(e){
                            e.preventDefault();
                            var file = $(this).data('file');
                            var command = $(this).data('command');
                            console.log(file);
                            console.log(command);
                            
                if(confirm('Elimino il file \"'+file+'\" ?')) {
                            
                $.ajax({
                    type: 'POST',
                    url: 'browser.ajax.php',
                    data: {file: file, command: command},
                    success: function () {
                                              window.location.reload();
                                                }
                    });
                }
                });
    </script>

";


?>




</div>


</html>