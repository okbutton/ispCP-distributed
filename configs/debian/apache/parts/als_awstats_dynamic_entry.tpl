   ProxyRequests Off

   <Proxy *>
      Order deny,allow
      Allow from all
   </Proxy>

   ProxyPass			/stats	http://localhost/stats/{ALS_NAME}
   ProxyPassReverse		/stats	http://localhost/stats/{ALS_NAME}

   <Location /stats>
       AuthType Basic
       AuthName "Statistics for domain {ALS_NAME}"
       AuthUserFile {WWW_DIR}/{DMN_NAME}/{HTACCESS_USERS_FILE_NAME}
       AuthGroupFile {WWW_DIR}/{DMN_NAME}/{HTACCESS_GROUPS_FILE_NAME}
       Require group {AWSTATS_GROUP_AUTH}
   </Location>
