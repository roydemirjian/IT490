#!/usr/bin/php
<?php

## Implement wildcards to ip later....


#string to replace
$oldip = '192.168.1.4';

#new string
$newip = '192.168.1.184';

#Read file
$str = file_get_contents('hotswaptest.ini');

#Replace
$str = str_replace($oldip,$newip,$str);

#Write
file_put_contents('hotswaptest.ini', $str);
?>
