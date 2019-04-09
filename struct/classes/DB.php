<?php
/**
 * Created by PhpStorm.
 * User: msantolo
 * Date: 30/10/2018
 * Time: 10:46
 */

class DB
{
    //carico i parametri di connessione dall'ini
    function __construct()
    {
        $ini = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/logs.ini', true);
        //Server Centralino MySQL
        $this->PBX = $ini['DB']['PBX'];
        $this->PBXUserName = $ini['DB']['PBXUserName'];
        $this->PBXPassword = $ini['DB']['PBXPassword'];
        //DB_Server MySQL
        $this->Amanda = $ini['DB']['Amanda'];
        $this->AmandaUserName = $ini['DB']['AmandaUserName'];
        $this->AmandaPassword = $ini['DB']['AmandaPassword'];
        //DB Sito - database fisso 'pick_cent23' MySQL
        $this->SiteGround = $ini['DB']['SiteGround'];
        $this->SiteGroundUserName = $ini['DB']['SiteGroundUserName'];
        $this->SiteGroundPassword = $ini['DB']['SiteGroundPassword'];
        $this->SiteGroundDB = $ini['DB']['SiteGroundDB'];
        //DB eSolver - database fisso 'ESOLVER' SQLServer
        $this->eSolver = $ini['DB']['eSolver'];
        $this->eSolverUserName = $ini['DB']['eSolverUserName'];
        $this->eSolverPassword = $ini['DB']['eSolverPassword'];
        $this->eSolverDB = $ini['DB']['eSolverDB'];
        //Schema Punti
        $this->BPFirstLogin = $ini['Punti']['Iscrizione'];
        $this->BPBirthday = $ini['Punti']['Compleanno'];
        $this->BPAnniversary = $ini['Punti']['Anniversario'];
        //Database Dom2
        $this->Dom2 = $ini['DB']['Dom2'];
        $this->Dom2UserName = $ini['DB']['Dom2UserName'];
        $this->Dom2Password = $ini['DB']['Dom2Password'];
        $this->Dom2DB = $ini['DB']['Dom2DB'];

        //Tolleranze per continuità contrattuale per accrediti bonus
        $this->CToleranceDays = $ini['Rinnovi']['Tolleranza'];

        //Percentuale di punti spendibili
        $this->percPoints = $ini['Punti']['PercentualeSpesa'];

    }

    //genera connessione al PBX
    function getPBXConn($db)
    {
        $servername = $this->PBX;
        $username = $this->PBXUserName;
        $password = $this->PBXPassword;
        $conn = mysqli_connect($servername, $username, $password, $db) or die("Impossibile connettersi a: " . $db . " - " . mysqli_connect_error());
        return $conn;
    }

    //genera connessione ad amanda
    function getProdConn($db)
    {
        $servername = $this->Amanda;
        $username = $this->AmandaUserName;
        $password = $this->AmandaPassword;
        $conn = mysqli_connect($servername, $username, $password, $db) or die("Impossibile connettersi a: " . $db . " - " . mysqli_connect_error());
        return $conn;
    }

    //genera connessione a Siteground
    function getSiteConn()
    {
        $servername = $this->SiteGround;
        $username = $this->SiteGroundUserName;
        $password = $this->SiteGroundPassword;
        $db = $this->SiteGroundDB;
        $conn = mysqli_connect($servername, $username, $password, $db) or die("Impossibile connettersi a: " . $db . " - " . mysqli_connect_error());
        return $conn;
    }

    //genera connessione a eSolver
    function getSistemiConn()
    {
        $servername = $this->eSolver;
        $username = $this->eSolverUserName;
        $password = $this->eSolverPassword;
        $db = $this->eSolverDB;
        $connectionInfo = array("Database" => $db, "UID" => $username, "PWD" => $password);
        $conn = sqlsrv_connect($servername, $connectionInfo);
        if ($conn) {
            return $conn;
        } else {
            die("Impossibile connettersi a: " . $db . " - " . print_r(sqlsrv_errors(), true));
        }
    }

    //genera connessione a Dom2
    function getDom2Conn()
    {
        $servername = $this->Dom2;
        $username = $this->Dom2UserName;
        $password = $this->Dom2Password;
        $db = $this->Dom2DB;
        $connection_string = "DRIVER={SQL Server};SERVER={$servername};DATABASE={$db}";
        $conn = odbc_connect($connection_string, $username, $password);

        if ($conn) {
            return $conn;
        } else {
            die("Impossibile connettersi a: " . $db . " - " . print_r(odbc_errormsg(), true));
        }
    }

    //distrugge connessione
    function dropConn($conn)
    {
        mysqli_close($conn);
    }

    //controlla la password da CRM
    function checkPassword($password, $user_hash)
    {
        if (empty($user_hash)) return false;
        if ($user_hash[0] != '$' && strlen($user_hash) == 32) {
            return strtolower(md5($password)) == $user_hash;
        }
        return crypt(strtolower(md5($password)), $user_hash) == $user_hash;
    }

    //genera elenco date nel periodo saltando i festivi
    function dateRange($first, $last, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);
        while ($current <= $last) {
            if (date("D", $current) != "Sun" and date("D", $current) != "Sat")
                $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

    //genera le option per campo e tabella
    public static function showOpt($conn, $pvalue, $field, $table)
    {
        $array = $conn->query("SELECT distinct {$field} FROM {$table}");

        $string = "<OPTION value='' SELECTED></OPTION>";
        while ($value = $array->fetch_assoc()) {
            $fvalue = DB::transcode($value[$field]);
            ($value[$field] == $pvalue) ? $selected = 'selected' : $selected = '';
            $string .= "<OPTION value='{$value[$field]}' {$selected}>{$fvalue}</OPTION>";
        }
        return $string;
    }

    //genera date per ripetizione
    public function dateRangeRecurring($first, $last, $days, $step = '+1 day', $format = 'Y-m-d')
    {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);
        while ($current <= $last) {

            $needle = date("D", $current);

            if (in_array($needle, $days))
                $dates[] = date($format, $current);
            $current = strtotime($step, $current);
        }
        return $dates;
    }

}
