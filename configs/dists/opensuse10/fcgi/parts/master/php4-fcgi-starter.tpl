#!/bin/sh

umask 022

PHPRC="{PHP_STARTER_DIR}/{DMN_NAME}/php4/"

export PHPRC
PHP_FCGI_CHILDREN=2
export PHP_FCGI_CHILDREN
PHP_FCGI_MAX_REQUESTS=500
export PHP_FCGI_MAX_REQUESTS

exec /usr/bin/php4-cgi