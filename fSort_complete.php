<!DOCTYPE html>
<html>
<body>
<?php
//echo $_POST["fSDate"]. "<br/>";
if(! file_exists("dlist.txt")){
    echo "File does not exist.". "<br/>";
} else {

$sarr = array();
$farr = array();

function numTrim($fNum = 01) {
    if(substr($fNum,0,1) == 0){
        return substr($fNum,1,1);
    } else {
        return substr($fNum,0,2);
    }
}
//Changes 8-digit number to MDY date format
function dateSlice ($fDate = 01022012){
    global $month;
    $fDay = numTrim(substr($fDate,0,2));
    $fMonth = numTrim(substr($fDate,2,2));
    $fYear = substr($fDate,4,4);
    return $month[$fMonth - 1]. " ". $fDay. ", ". $fYear;
}

function sortAlg ($arrA,$ArrB,$sAtype) {
    switch ($sAtype) {
        case "fSR":
            echo $sAtype;
            break;
        case "fSO":
            echo $sAtype;
            break;
        default:
            echo "invalid";
    }
    
}


$sortR = fopen("dlist.txt","r");

$inti = -1;
$nemt = "";
while(! feof($sortR)) {
    $inti++;
    $nemt = fgetcsv($sortR);
    if ($nemt != "") {
    $sarr[$inti] = $nemt;
    }
}
fclose($sortR);

for($i = 0; $i < count($sarr);$i++) {
    echo $sarr[$i][0]. "<br/>";
}
sortAlg($sarr,$farr,$_POST["fSDate"]);
/*
$sortW = fopen("dlist.txt", "w");
fclose($sortW);*/
}
?>
</body>
</html>