#!/usr/bin/env bash

./shell/reset-db.sh test;
phpunit -c app;
