#!/usr/bin/php
<?php

$ch = curl_init("https://jsonplaceholder.typicode.com/posts/1");
$fp = fopen("api_data.txt", "w");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);
curl_close($ch);
fclose($fp);

?>
