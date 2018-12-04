#!/bin/bash

# What to backup. 
backup_files="/home/roydem/database/"

# Where to backup to.
dest="/home/roydem/backups/"

# Create archive filename.
archive_file="database-backup.tgz"

# Print start status message.
echo "Backing up $backup_files to $dest/$archive_file"
date
echo

# Backup the files using tar.
tar czf $dest/$archive_file -C /home/roydem/database/ .

# Print end status message.
echo
echo "Backup finished"
date
echo


# Long listing of files in $dest to check file sizes.
ls -lh $dest
