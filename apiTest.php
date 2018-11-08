#!/usr/bin/php
<?php


error_reporting(E_ALL);
ini_set('log_errors', TRUE);
ini_set('error_log', '/home/roydem/database/logging/dbLog.txt');
ini_set('log_errors_max_len', 1024);



echo "WELCOME TO MOVIE BUDDY\n";

$answer = readline("Do you dare search?: ");
if ($answer == "yes") {

        $input = readline("TV Show or Movie name: ");
        $searchname = preg_replace('/\s+/', '+',$input);


        $ch = curl_init("https://api.themoviedb.org/3/search/multi?api_key=a99025c572bede9218ee420b5c9f4cc4&language=en-US&query=" . $searchname . "&page=1&include_adult=false");
        $fp = fopen("/home/roydem/database/apidata/multi_search.json", "w+");

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);


}else{

	echo "Why are you here then?\n";
	exit();
	
}

exec('/home/roydem/database/jsontest.php', $output, $return);

if (!$return){
	echo "Displaying search results\n\n";
	foreach ($output as $line){
		echo "$line\n";
	}
}else{
	echo "Could not display search results\n";
}


?>



