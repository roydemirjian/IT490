#!/bin/bash

if ping -c 1 192.168.1.184 &> /dev/null
then
	echo "Host Found. No Changes Made..."
else
	echo "Host Not Found. Starting HotSwap..."
	php changehotswapIP.php
fi
