<html>
<body>
<?php $read = fopen("dlist.txt", "r");?>
Option: "<?php echo $_POST["type"];?>"<br>
<?php
    while(! feof($read)) {
        echo fgets($read) . "<br />";
    }
fclose($read);
?>
</html>
</body>