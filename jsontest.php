#!/usr/bin/php
<?php

$file = file_get_contents("/home/roydem/database/apidata/movies.json");
$jsonarray = json_decode($file, true);

#foreach($jsonarray as $key => $json ){

#	echo $key;

#	foreach($json as $key2 => $json2){

#		echo $key2;

#	}

#}


foreach($jsonarray['results'] as $variable){

	print $variable['title'];
        print "\n";

	print $variable['overview'];
        print "\n";

	print $variable['release_date'];
        print "\n";

	print "\n";

}

#var_dump($jsonarray);





?>
