#!/usr/bin/php
<?php

$url = 'movies.json';
$data = file_get_contents($url);
echo json_decode($data);




?>
