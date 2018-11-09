#!/usr/bin/php
<?php



$search_input = $_POST['search'];

echo nl2br("\n\n ");

echo nl2br("WELCOME TO MOVIE BUDDY\n\n");


if (isset($_POST['search']) && !empty($_POST['search'])){

      	
	$searchname = preg_replace('/\s+/', '+',$search_input);


        $ch = curl_init("https://api.themoviedb.org/3/search/multi?api_key=a99025c572bede9218ee420b5c9f4cc4&language=en-US&query=" . $searchname . "&page=1&include_adult=false");	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$curl_results = curl_exec($ch);
        curl_close($ch);
}else{

	echo nl2br("Why are you here then?\n");
	exit();
	
}


$jsonarray = json_decode($curl_results, true); //convert json into multidimensional associative array 


foreach($jsonarray['results'] as $variable){

        $title = $variable['title'];
        if (is_null($title)){
                $title = $title . 'NULL';
        }
        echo nl2br('TITLE: ' . $title . "\n");
	


        $overview =  $variable['overview'];
        if (is_null($overview)){
                $overview = $overview . 'NULL';
        }
        echo nl2br('OVERVIEW: ' . $overview . "\n");

        $releasedate =  $variable['release_date'];
        if (is_null($releasedate)){
                $releasedate = $releasedate . 'NULL';
        }
        echo nl2br('RELEASE DATE: ' . $releasedate . "\n");

        $posterpath = $variable['poster_path'];
        if (is_null($posterpath)){
                $posterpath = $posterpath . 'NULL';
        }
	//echo nl2br('POSTER PATH: ' . 'https://image.tmdb.org/t/p/w500' . $posterpath . "\n\n");	
	$image = 'https://image.tmdb.org/t/p/w500' . $posterpath;
	$imagedata = base64_encode(file_get_contents($image));

	echo "<img src=\"".$image."\">";

	echo nl2br("\n\n");

        echo nl2br("- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\n");
}


?>

<?php


?>
