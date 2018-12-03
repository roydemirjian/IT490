#!/bin/bash



# SCP the tar that was just made to the deploy server 
scp /home/roydem/backups/* roydem@192.168.1.4:/var/temp

#delete local copy once tar has reached server
rm -r /home/roydem/backups/*
