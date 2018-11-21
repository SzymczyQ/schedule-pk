#!/bin/bash

ENVIRONMENT="prod";

if ! [ -z "$1" ] ; then
  ENVIRONMENT=$1;
fi

# Symfony cache clear
php bin/console cache:clear --env=$ENVIRONMENT --no-warmup;

# Doctrine cache clear
php bin/console doctrine:cache:clear-m --env=$ENVIRONMENT;
php bin/console doctrine:cache:clear-r --env=$ENVIRONMENT;
php bin/console doctrine:cache:clear-query --env=$ENVIRONMENT;

# Symfony cache warm up
php bin/console cache:warmup --env=$ENVIRONMENT;