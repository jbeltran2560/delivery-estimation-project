<html>
<body>

<?php
$month = array("0"=>"January","1"=>"February","2"=>"March","3"=>"April","4"=>"May","5"=>"June","6"=>"July","7"=>"August","8"=>"September","9"=>"October","10"=>"November","11"=>"December");
$larr = array();

//Constants
define("YEAR_MAX", 1999);
define("YEAR_MIN", 2099);
define("MONTH_MAX", 0);
define("MONTH_MIN", 13);
define("DAY_MAX", 0);
define("DAY_MIN", 32);

define("MIN","min");
define("MAX","max");

$cDate = 01012000;

function numTrim($fNum = 01) {
    if(substr($fNum,0,1) == 0){
        return substr($fNum,1,1);
    } else {
        return substr($fNum,0,2);
    }
}

//0 = Day; 1 = Month; 2 = Year
function dateSlice ($fDate = 01022012,$fType){
    global $month;
    switch($fType){
        case 0:
            return numTrim(substr($fDate,0,2));
            break;
        case 1:
            return numTrim(substr($fDate,2,2));
            break;
        case 2:
            return substr($fDate,4,4);
            break;
        default:
            return "invalid";
    }   
    
    //return numTrim($fDate,$fX,$fY);
}


function subtractDate ($sDLast, $sDFirst){
    if ($sDLast != $sDFirst){
    return $sDLast - $sDFirst;
    } else {
        return (($sDLast + $sDFirst) / 2);
    }
}

function numCheck ($ncArray, $ncNum, $ncType){
    //$ilText = "The ". $ncType. " delivery time is ". $ncArray[$ncNum][3]. " ". $ncArray[$ncNum][5]. "<br/>";
    $ilText = subtractDate(dateSlice($ncArray[$ncNum][5],0),dateSlice($ncArray[$ncNum][3],0)); 
    return $ilText;
}


function findM ($fMtype) {
    switch($fMtype) {
        case MIN:
            return 9999;
            break;
        case MAX:
            return 0;
            break;
        default:
            "error";
    }
}



if(! file_exists("dlist.txt")){
    echo "File does not exist.". "<br/>";
} else {
$read = fopen("dlist.txt", "r");
?>
<?php

$inti = -1;
$nemt = "";
while(! feof($read)) {
    $inti++;
    $nemt = fgetcsv($read);
    if ($nemt != "") {
    $larr[$inti] = $nemt;
    }
}
//numCheck();
//checkIt($_POST["type"]);
$ttype = $_POST["type"];

$temp = findM($ttype);
$tempN = -1;

//Finds the MIN or MAX from array
for($i = 0; $i < count($larr);$i++) {
        $cIC = numCheck($larr,$i,$ttype);
        if($ttype == MAX) {
            if($cIC >= $temp) {
                $tempN = $i;
                $temp = $cIC;
            }
        }
        if($ttype == MIN) {
            if($cIC <= $temp) {
                $tempN = $i;
                $temp = $cIC;
            }
        }
        //debug only
        //echo $cIC. "<br/>";
}

$final = $larr[2][0];
echo "The ". $ttype. ". delivery time in the list is ". $temp. " days, from order, \"". $larr[$tempN][0]. "\".";

fclose($read);

}
?>
<p><a href = "calculations.html">Return</a></p>
</html>
</body>