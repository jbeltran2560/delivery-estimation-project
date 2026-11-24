<html>
<body>
<!--<h1>List of Past deliveries</h1>-->
<?php require 'variables.php';

//Info is grabbed from list line by line and put into temporary Multidimensional Arrays

//Functions
//For Day or Month only
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

function itemList($ilArray, $ilNum){
    $ilType = $ilArray[$ilNum][1];
    switch ($ilType) {
        case "post":
            $ilType = "postcard";
            break;
        case "lett":
            $ilType = "letter";
            break;
        case "flat":
            $ilType = "envelope";
            break;
        case "prcl":
            $ilType = "parcel";
            break;
        default:
            $ilType = "undefined";
    }
    $ilText = $ilArray[$ilNum][0]. " was ordered on ". dateSlice($ilArray[$ilNum][3]). ", with expected delivery ". dateSlice($ilArray[$ilNum][4]). ", and arrived ". dateSlice($ilArray[$ilNum][5]). ". The package was a ". $ilArray[$ilNum][2]. " inch long ". $ilType. ".";
    return $ilText;
}

//Checks if file exists before majority of code is executed
if(! file_exists("dlist.txt")){
    echo "File does not exist.". "<br/>";
} else {
$readl = fopen("dlist.txt", "r");

//For each line in list, add contents to array; empty is ignored
$inti = -1;
$nemt = "";
while(! feof($readl)) {
    $inti++;
    $nemt = fgetcsv($readl);
    if ($nemt != "") {
    $larr[$inti] = $nemt;
    }
}
//Debugging Only
/*
foreach ($larr as $t) {
    print_r($t). "<br/>";
}
echo "<br/>";
*/
//Prints entire array list as a complete sentence; [0 to n][0 to 5]
for($i = 0; $i < count($larr);$i++) {
    echo itemList($larr,$i). "<br/>";
}

fclose($readl);
}
?>
<!-- <p><a href = "list.html">Return</a></p> -->
</body>
</html>