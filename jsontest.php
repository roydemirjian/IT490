#!/usr/bin/php
<?php

$string = file_get_contents("/home/roydem/database/apidata.txt");
$json = json_decode($string,true);

foreach ($json as $key => $value){

	echo $key . ':' . $value;
}







?>
