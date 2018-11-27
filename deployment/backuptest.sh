#!/bin/bash

# What to backup. 
backup_files="/home/roydem/database"

# Where to backup to.
dest="/home/roydem/backups"

# Create archive filename.
current_time=$(date +%m-%d-%Y_%H-%M-%S)
hostname=$(hostname -s)
archive_file="database-backup-$hostname-$current_time.tgz"

# Print start status message.
echo "Backing up $backup_files to $dest/$archive_file"
date
echo

# Backup the files using tar.
tar czf $dest/$archive_file --absolute-names $backup_files

# Print end status message.
echo
echo "Backup finished"
date
echo

# SCP the tar that was just made to the deploy server 
scp /home/roydem/backups/* roydem@192.168.1.184:/home/roydem/database/scp

# Long listing of files in $dest to check file sizes.
ls -lh $dest
