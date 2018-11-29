#!/bin/bash

# SCP the tar from the deploy server to its destination

sourcefile=$1

scp /home/roydem/database/scp/$sourcefile roydem@192.168.1.10:/home/roydem/scp


