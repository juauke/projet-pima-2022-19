#!/bin/bash
# This script is used to deploy the application to the server

# Update the repository
cd ~/projet-pima-2022-19
git pull
npm run build

cp -r PHP ../shriimpe
cp -r build/* ../shriimpe
cp -r Stats/* /nfs/Python/