#!/usr/bin/php
<?php

error_reporting(E_ALL);
ini_set('log_errors', TRUE);
ini_set('error_log', '/home/roydem/database/logging/dbLog.txt');
ini_set('log_errors_max_len', 1024);



$file = file_get_contents("/home/roydem/database/apidata/multi_search.json");
$jsonarray = json_decode($file, true); //convert json into multidimensional associative array 

foreach($jsonarray['results'] as $variable){

	$title = $variable['title'];
	if (is_null($title)){
		$title = $title . 'NULL';
	}
	print 'TITLE: ' . $title . "\n";

	$overview =  $variable['overview'];
        if (is_null($overview)){
                $overview = $overview . 'NULL';
        }
	print 'OVERVIEW: ' . $overview . "\n";

	$releasedate =  $variable['release_date'];
        if (is_null($releasedate)){
                $releasedate = $releasedate . 'NULL';
        }
	print 'RELEASE DATE: ' . $releasedate . "\n";

	$posterpath = $variable['poster_path'];
        if (is_null($posterpath)){
                $posterpath = $posterpath . 'NULL';
        }
	print 'POSTER PATH: ' . $posterpath . "\n\n";

	print "- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\n";
}


?>
