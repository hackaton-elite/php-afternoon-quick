#!/usr/bin/env bash

mkdir build;
./shell/reset-db.sh test
phpunit -c app --coverage-text --coverage-clover=build/coverage.clover;
