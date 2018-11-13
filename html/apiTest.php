#!/usr/bin/php
<?php



//Search input from hmtl
$search_input = $_POST['search'];

//Username obtained from user login using post
$username = 'username'; //not set up atm

echo nl2br("\n\n ");

echo nl2br("WELCOME TO MOVIE BUDDY\n\n");


if (isset($_POST['search']) && !empty($_POST['search'])){

  	    	
	$searchname = preg_replace('/\s+/', '+',$search_input);

	//API MULTI SEARCH ( MOVIES AND SHOWS)
        $ch = curl_init("https://api.themoviedb.org/3/search/multi?api_key=a99025c572bede9218ee420b5c9f4cc4&language=en-US&query=" . $searchname . "&page=1&include_adult=false");	
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	
	//Set results to var
	$curl_results = curl_exec($ch);
        curl_close($ch);
}else{

	echo nl2br("Why are you here then?\n");
	exit();
	
}


$jsonarray = json_decode($curl_results, true); //convert json into multidimensional associative array 

//Iterate through the array 'results' and assign a variable to each type that we want
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

	//Get image path and base64 encode it so that it may be displayed
	$image = 'https://image.tmdb.org/t/p/w500' . $posterpath;
	$imagedata = base64_encode(file_get_contents($image));


	//Display image
	//echo "<img src=\"".$image."\" >";

	echo '<a href="http://www.imdb.com"><img src="'.$image.'"><h4></h4></a>';

	echo nl2br("\n\n");

        echo nl2br("- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\n");
}




?>


<script id="cid0020000203039478046" data-cfasync="false" async src="//st.chatango.com/js/gz/emb.js" style="width: 400px;height: 500px;">{"handle":"moviebuddychatroom","arch":"js","styles":{"a":"33cc00","b":100,"c":"FFFFFF","d":"FFFFFF","k":"33cc00","l":"33cc00","m":"33cc00","n":"FFFFFF","p":"10","q":"33cc00","r":100,"pos":"br","cv":1,"cvbg":"33cc00","cvw":75,"cvh":30}}</script>
