#!/bin/bash



#------ SOURCE TO DEPLOY ----------

# SCP the tar that was just made to the deploy server 
scp /home/roydem/backups/* roydem@192.168.1.4:/home/roydem/database/scp


#delete local copy once tar has reached server
rm -r /home/roydem/backups/*
