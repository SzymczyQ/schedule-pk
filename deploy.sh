#!/bin/bash

ENVIRONMENT="prod";
if ! [ -z "$1" ] ; then
  ENVIRONMENT=$1;
fi

# Pull changes
git pull origin master;

# Install third part libraries
composer install;
npm install;

# Install assets
if [ "$ENVIRONMENT" == "prod" ]
then
    npm run build;
else
    npm run dev;
fi

# Update database
php bin/console doctrine:schema:update --force;

# Clear cache
if [ "$ENVIRONMENT" == "prod" ]
then
    ./cc.sh;
else
    ./cc.sh dev;
fi