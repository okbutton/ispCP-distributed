<VirtualHost {SUB_IP}:80>

    #
    #User {SUEXEC_USER}
    #Group {SUEXEC_GROUP}
    #

    SuexecUserGroup {SUEXEC_USER} {SUEXEC_GROUP}

    ServerAdmin     root@{DMN_NAME}
    DocumentRoot    {WWW_DIR}/{DMN_NAME}{MOUNT_POINT}/htdocs

    ServerName      {SUB_NAME}
    ServerAlias     www.{SUB_NAME} {SUB_NAME} *.{SUB_NAME}

    ErrorLog        {APACHE_USERS_LOG_DIR}/{SUB_NAME}-error.log
    TransferLog     {APACHE_USERS_LOG_DIR}/{SUB_NAME}-access.log

    CustomLog       {APACHE_LOG_DIR}/{DMN_NAME}-traf.log traff
    CustomLog       {APACHE_LOG_DIR}/{DMN_NAME}-combined.log combined

    Alias /errors {WWW_DIR}/{DMN_NAME}/errors/

    <Directory {WWW_DIR}/{DMN_NAME}/errors/>
        <IfModule mod_php4.c>
            php_admin_value open_basedir "{WWW_DIR}/{DMN_NAME}/errors/"
        </IfModule>
    </Directory>

    ErrorDocument 401 /errors/401/index.php
    ErrorDocument 403 /errors/403/index.php
    ErrorDocument 404 /errors/404/index.php
    ErrorDocument 500 /errors/500/index.php

    # httpd sub entry cgi support BEGIN.
    # httpd sub entry cgi support END.

    <IfModule mod_fastcgi.c>
        ScriptAlias /php4/ {STARTER_DIR}/{DMN_NAME}/
        <Directory "{STARTER_DIR}/{DMN_NAME}">
            AllowOverride None
            Options +ExecCGI -MultiViews -Indexes
            Order allow,deny
            Allow from all
        </Directory>
    </IfModule>

    <IfModule mod_php4.c>
        <Directory {GUI_ROOT_DIR}>
            php_admin_value open_basedir "{GUI_ROOT_DIR}/:/etc/ispcp/:/proc/:{WWW_DIR}/:/tmp/:/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin"
            php_admin_value session.save_path "{GUI_ROOT_DIR}/phptmp/"
        </Directory>
    </IfModule>

    # httpd sub entry PHP2 support BEGIN.
    # httpd sub entry PHP2 support END.

    <Directory {WWW_DIR}/{DMN_NAME}{MOUNT_POINT}/htdocs>
        # httpd sub entry PHP support BEGIN.
        # httpd sub entry PHP support END.
        Options -Indexes Includes FollowSymLinks MultiViews
        AllowOverride All
        Order allow,deny
        Allow from all
    </Directory>

</VirtualHost>
