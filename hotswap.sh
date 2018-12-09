#!/bin/bash

#ip='192.168.1.184'

grn=$'\e[1;32m'
red=$'\e[1;31m'

echo "[Monitoring $1 for availability]"

while true; do
	
	if ping -c 1 $1 &> /dev/null
	then
		echo "${grn}Host Found at [$1] | No Changes Made!"
		sleep 5 
	else
		echo "${red}Host Not Found at [$1] | HotSwap has been executed!"
		php changehotswapIP.php
		break
	fi
done
