<?php
$postdata = file_get_contents("php://input");

$myfile = fopen("e.txt", "a") or die("Unable to open file!");
fwrite($myfile, (string) $postdata."\n");
fclose($myfile);
?>
