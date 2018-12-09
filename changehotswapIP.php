#!/usr/bin/php
<?php


$oldip = '192.168.1.4';
$newip = '192.168.1.184';

#Read file
$str = file_get_contents('hotswaptest.ini');

#Replace
$str = str_replace($oldip,$newip,$str);

#Write
file_put_contents('hotswaptest.ini', $str);
?>
