{MINUTE} {HOUR}  * * *   root perl /var/www/ispcp/engine/awstats/awstats_buildstaticpages.pl -config={DMN_NAME} -update -lang=en -awstatsprog=/usr/lib/cgi-bin/awstats.pl -dir=/var/www/virtual/{DMN_NAME}/statistics/ >/dev/null 2>&1