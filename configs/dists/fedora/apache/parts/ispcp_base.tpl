# httpd Data BEGIN.

#
# wget-hack prevention
#

<IfModule mod_rewrite.c>
    RewriteEngine on
    RewriteCond %{HTTP_USER_AGENT} ^LWP::Simple
    RewriteRule ^/.* http://%{REMOTE_ADDR}/ [L,E=nolog:1]
</IfModule>

#
# Web traffic accounting.
#

LogFormat "%B" traff

#
# GUI Location.
#

Alias /ispcp /srv/www/ispcp/gui
<Directory /srv/www/ispcp/gui>
    AllowOverride none
    Options MultiViews IncludesNoExec FollowSymLinks
    ErrorDocument 404 /ispcp/errordocs/index.php
    DirectoryIndex index.html index.php
</Directory>

<Directory /srv/www/ispcp/gui/tools/filemanager>
    <IfModule mod_php4.c>
    php_flag register_globals On
    php_admin_value open_basedir "/srv/www/ispcp/gui/tools/filemanager/:/tmp/:/usr/share/php/"
    </IfModule>
</Directory>

Alias /ispcp_images /srv/www/ispcp/gui/images
<Directory /srv/www/ispcp/gui/images>
    AllowOverride none 
    Options MultiViews IncludesNoExec FollowSymLinks
</Directory>

#
# AWStats
#

Alias /awstatsclasses "/srv/www/awstats/classes/"
Alias /awstatscss "/srv/www/awstats/css/"
Alias /awstatsicons "/srv/www/awstats/icon/"
Alias /awstatsjs "/srv/www/awstats/js/"
Alias /stats "/usr/lib/cgi-bin/awstats/"

<Directory /usr/lib/cgi-bin/awstats>
    AllowOverride AuthConfig
    Options -Includes FollowSymLinks +ExecCGI MultiViews
    AddHandler cgi-script cgi pl
    DirectoryIndex awstats.pl
    Order deny,allow
    Allow from all
</Directory>

#
# Header End
#

# httpd [{IP}] virtual host entry BEGIN.
# httpd [{IP}] virtual host entry END.

# httpd Data END.