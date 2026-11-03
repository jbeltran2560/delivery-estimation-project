<html>
<body>
<?php $lmake = fopen("dlist.txt", "a");?>
<!--Debugging Only-->
Name: "<?php echo $_POST["fname"];?>"<br>
Order: "<?php echo $_POST["ffrst"];?>"<br>
Expected: "<?php echo $_POST["fexpt"];?>"<br>
Actual: "<?php echo $_POST["factu"];?>"<br>
Type: "<?php echo $_POST["ftype"];?>"<br>
Size: "<?php echo $_POST["fsize"];?>"<br>
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

if ($_SERVER["REQUEST_METHOD"] =="POST") {
    //Valid Name
    /*
    if (empty($_POST["fname"])){
        echo 'Name must contain at least one character.<br>';
    } else {
        //fwrite($lmake, $_POST["fname"]);
        //echo 'Name successfully added.<br>';
    }*/
    
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
    //postcard
    if ($_POST["ftype"] == "post") {
        if ($_POST["fsize"] > 6){
            echo 'Length for postcards must not exceed 6 inches.<br>';
            $e++;
        }
    }
    //letter
    if ($_POST["ftype"] == "lett") {
        if ($_POST["fsize"] > 11) {
            echo 'Length for letters must not exceed 11 1/2 inches.<br>';
            $e++;
        } else if ($_POST["fsize"] < 5) {
            echo 'Length for letters must at least be 5 inches.<br>';
            $e++;
        }
    }
    //flat
    if ($_POST["ftype"] == "flat") {
        if ($_POST["fsize"] > 15) {
            echo 'Length for flats must not exceed 15 inches.<br>';
            $e++;
        } else if ($_POST["fsize"] < 12) {
            echo 'Length for flats must at least be 11 1/2 inches.<br>';
            $e++;
        }
    }
    //parcel
    if ($_POST["ftype"] == "prcl") {
        if ($_POST["fsize"] > 27) {
            echo 'Length for parcels must not exceed 27 inches.<br>';
            $e++;
        } else if ($_POST["fsize"] < 6) {
            echo 'Length for parcels must at least be 6 inches.<br>';
            $e++;
        }
    }
    
    //Write to File
    //error check
    if($e == 0) {
        $a = $_POST["fname"] . " " . $_POST["ftype"] . " " . $_POST["fsize"] .  " " . $dtOr . " " . $dtEx . " " . $dtOr;
        echo 'Item successfully added to list.';
        //fwrite($lmake, $_POST["fname"]);
        //fwrite($lmake, $_POST["fsize"]);
        fwrite($lmake, $a);
        fwrite($lmake, $b);
    } else {
        echo 'Error(s): ' , $e, '. See above for explanation.';
    }
}
fclose($lmake);
?>

<p><a href = "list.html">Add more items</a></p>

</body>
</html>