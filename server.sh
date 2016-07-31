#!/bin/bash

# setup PHP
PHP_BIN="/usr/bin/php"
PHP_INI="/etc/php5/cli/php.ini"
HOST_PORT=9000

# Get script path location
BASEDIR=$(dirname "$0")

# execute built-in server
$PHP_BIN -S localhost:$HOST_PORT -c $PHP_INI -t "$BASEDIR/web"
