<VirtualHost {DMN_IP}:80>

    <IfModule suexec_module>
           SuexecUserGroup {SUEXEC_USER} {SUEXEC_GROUP}
    </IfModule>

    ServerAdmin     webmaster@{DMN_NAME}
    DocumentRoot    {WWW_DIR}/{DMN_NAME}/htdocs

    ServerName      {DMN_NAME}
    ServerAlias     www.{DMN_NAME} {DMN_NAME} {SUEXEC_USER}.{BASE_SERVER_VHOST}

    Alias /errors   {WWW_DIR}/{DMN_NAME}/errors/

    RedirectMatch permanent ^/ftp[\/]?$		{BASE_SERVER_VHOST_PREFIX}{BASE_SERVER_VHOST}/ftp/
    RedirectMatch permanent ^/pma[\/]?$		{BASE_SERVER_VHOST_PREFIX}{BASE_SERVER_VHOST}/pma/
    RedirectMatch permanent ^/webmail[\/]?$	{BASE_SERVER_VHOST_PREFIX}{BASE_SERVER_VHOST}/webmail/
    RedirectMatch permanent ^/ispcp[\/]?$	{BASE_SERVER_VHOST_PREFIX}{BASE_SERVER_VHOST}/

    ErrorDocument 401 /errors/401.html
    ErrorDocument 403 /errors/403.html
    ErrorDocument 404 /errors/404.html
    ErrorDocument 500 /errors/500.html
    ErrorDocument 503 /errors/503.html

    <IfModule mod_cband.c>
        CBandUser {DMN_GRP}
    </IfModule>

    # httpd awstats support BEGIN.
    # httpd awstats support END.

    # httpd dmn entry cgi support BEGIN.
    # httpd dmn entry cgi support END.

    <Directory {WWW_DIR}/{DMN_NAME}/htdocs>
        # httpd dmn entry PHP support BEGIN.
        # httpd dmn entry PHP support END.
        Options -Indexes Includes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>

    # httpd dmn entry PHP2 support BEGIN.
    # httpd dmn entry PHP2 support END.

    Include {CUSTOM_SITES_CONFIG_DIR}/{DMN_NAME}.conf

</VirtualHost>
