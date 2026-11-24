<html>
<body>
<?php $lmake = fopen("dlist.txt", "a");?>
<!--Debugging Only-->
<!--
Name: "<?php echo $_POST["fname"];?>"<br>
Order: "<?php echo $_POST["ffrst"];?>"<br>
Expected: "<?php echo $_POST["fexpt"];?>"<br>
Actual: "<?php echo $_POST["factu"];?>"<br>
Type: "<?php echo $_POST["ftype"];?>"<br>
Size: "<?php echo $_POST["fsize"];?>"<br>
-->
<?php

//variables
//error
$e = 0;
//break
$b = "\n";
//add
$a = "";

//day month year
$dateOr = array("Day"=>substr($_POST["ffrst"],8,2),"Month"=>substr($_POST["ffrst"],5,2),"Year"=>substr($_POST["ffrst"],0,4));
$dateEx = array("Day"=>substr($_POST["fexpt"],8,2),"Month"=>substr($_POST["fexpt"],5,2),"Year"=>substr($_POST["fexpt"],0,4));
$dateAc = array("Day"=>substr($_POST["factu"],8,2),"Month"=>substr($_POST["factu"],5,2),"Year"=>substr($_POST["factu"],0,4));
$dtOr = $dateOr['Day'] . $dateOr['Month'] . $dateOr['Year'];
$dtEx = $dateEx['Day'] . $dateEx['Month'] . $dateEx['Year'];
$dtAc = $dateAc['Day'] . $dateAc['Month'] . $dateAc['Year'];

//Return all values
//print_r(array_values($dateOr));

function futureCheck($anyDate) {
    global $e;
    $yearC = $anyDate['Year'] == date("Y");
    
    if ($anyDate['Year'] > date("Y")){
        echo 'Dates after today\'s date not allowed. <br>';
        $e++;
    } else if ($anyDate['Month'] > date("m") && $yearC == true) {
        echo 'Dates after today\'s date not allowed. <br>';
        $e++;
    } else if ($anyDate['Day'] > date("d") && $yearC == true) {
        echo 'Dates after today\'s date not allowed. <br>';
        $e++;
    }     
}

function dataRange($firstDate, $secndDate,$timeDate) {
    global $e;
    if ($firstDate[$timeDate] < $secndDate[$timeDate]) {
        echo $timeDate, ' date out of range. <br>';
        $e++;
    }
}

define("POSTCARD", "postcard");
define("POST_MAX", 6);
define("POST_MIN", 3);
define("LETTER", "letter");
define("LETT_MAX", 11);
define("LETT_MIN", 5);
define("FLAT", "envelope");
define("FLAT_MAX", 15);
define("FLAT_MIN", 12);
define("PARCEL", "parcel");
define("PRCL_MAX", 27);
define("PRCL_MIN", 6);
define("UNDEFINED", "undefinied");

function itemName($inPack){
    switch ($inPack) {
        case "post":
            $inPack = POSTCARD;
            break;
        case "lett":
            $inPack = LETTER;
            break;
        case "flat":
            $inPack = FLAT;
            break;
        case "prcl":
            $inPack = PARCEL;
            break;
        default:
            $inPack = UNDEFINED;
    }
    return $inPack;
}

function sizeRange($srForm,$srPack,$srNumA,$srNumB) {
    global $e;
    if ($srForm["ftype"] == $srPack){
        if ($srForm["fsize"] > $srNumA) {
            echo 'Length for '. itemName($srPack). 's must not exceed '. $srNumA. ' inches. <br>';
            $e++;
        } else if ($srForm["fsize"] < $srNumB) {
            echo 'Length for '. itemName($srPack). 's must be at least '. $srNumB. ' inches. <br>';
            $e++;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] =="POST") {
    
    //Valid Date
    futureCheck($dateOr);
    futureCheck($dateEx);
    futureCheck($dateAc);
    dataRange($dateAc,$dateOr,"Year");
    dataRange($dateAc,$dateOr,"Month");
    dataRange($dateAc,$dateOr,"Day");
    
    dataRange($dateEx,$dateOr,"Year");
    dataRange($dateEx,$dateOr,"Month");
    dataRange($dateEx,$dateOr,"Day");
    
    //Valid Size
    sizeRange($_POST,"post",POST_MAX,POST_MIN);
    sizeRange($_POST,"lett",LETT_MAX,LETT_MIN);
    sizeRange($_POST,"flat",FLAT_MAX,FLAT_MIN);
    sizeRange($_POST,"prcl",PRCL_MAX,PRCL_MIN);
    
    //Write to File
    //error check
    if($e == 0) {
        $a = $_POST["fname"] . "," . $_POST["ftype"] . "," . $_POST["fsize"] .  "," . $dtOr . "," . $dtEx . "," . $dtAc;
        echo 'Item successfully added to list.';
        fwrite($lmake, $a);
        fwrite($lmake, $b);
    } else {
        echo 'Number of error(s): '. $e. '. See above for explanation.';
    }
}
fclose($lmake);
?>

<!--<p><a href = "list.html">Add more items</a></p>-->

</body>
</html>