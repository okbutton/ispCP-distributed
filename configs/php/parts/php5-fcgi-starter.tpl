#!/bin/sh

PHPRC="{PHP_STARTER_DIR}/{DMN_NAME}/"

export PHPRC
PHP_FCGI_CHILDREN=2                                                                                                           
export PHP_FCGI_CHILDREN                                                                                                      
PHP_FCGI_MAX_REQUESTS=5000                                                                                                    
export PHP_FCGI_MAX_REQUESTS                                                                                                  

exec /usr/bin/php5-cgi 
