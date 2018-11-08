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

	$title = $variable['title'];
	print $title;
        print "\n";

	$overview =  $variable['overview'];
	print $overview;
        print "\n";

	$releasedate =  $variable['release_date'];
	print $releasedate;
        print "\n";

	$posterpath = $variable['poster_path'];
	print $posterpath;
	print "\n";

        print "\n";
	print "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -";
        print "\n";

}

#var_dump($jsonarray);





?>
