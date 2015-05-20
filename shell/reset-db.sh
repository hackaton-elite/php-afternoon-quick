#!/usr/bin/env bash

php app/console doc:data:drop --force --env=$1
php app/console doc:data:create --env=$1
php app/console doc:mig:mig -n --env=$1
php app/console doc:fix:load -n --env=$1
