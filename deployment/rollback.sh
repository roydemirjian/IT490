#!/bin/bash

#rollback

# SCP the tar from the deploy server to its destination

#sourcefile=$1
#scp /home/roydem/database/scp/$sourcefile roydem@192.168.1.10:/home/roydem/scp
#echo $sourecfile

cd /home/roydem/database/scp

#delete contents first
ssh roydem@192.168.1.12 'rm -rf /home/roydem/scp/*'

#send new rollback version
pv $1 | ssh roydem@192.168.1.12 'cat | tar xz --strip-components=3 -C /home/roydem/scp'
