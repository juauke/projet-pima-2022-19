#!/bin/bash
# This script is used to deploy the application to the server

# Update the repository
cd ~/projet-pima-2022-19
git pull

cp -r PHP ../shriimpe
cp -r CSS ../shriimpe
cp -r public ../shriimpe

chgrp -R work ../shriimpe

cp -r Stats/* /nfs/Python/
chgrp -R work /nfs/Python