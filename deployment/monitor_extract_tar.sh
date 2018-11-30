#!/bin/bash
MONITORDIR="/home/roydem/scp/"
while inotifywait  /home/roydem/backups/
do

tar xfv ~/backups/* -C ~/installfolder/
done
echo "Installed on install folder";
