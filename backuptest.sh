#!/bin/bash

cd ..

# What to backup. 
backup_files="database"

# Where to backup to.
dest="/home/roydem/backups"

# Create archive filename.
current_time=$(date +%Y-%m-%d_%H-%M-%S)
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

# Long listing of files in $dest to check file sizes.
ls -lh $dest
