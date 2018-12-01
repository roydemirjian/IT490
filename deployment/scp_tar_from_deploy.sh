#!/bin/bash

# SCP the tar from the deploy server to its destination

#$1 is filename

cd /home/roydem/database/scp

pv $1 | ssh roydem@192.168.1.10 'cat | tar xz --strip-components=1 -C /home/roydem/scp/'
