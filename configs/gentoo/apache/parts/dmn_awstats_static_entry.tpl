    Alias /stats    {WWW_DIR}/{DMN_NAME}/statistics/

    <Directory "{WWW_DIR}/{DMN_NAME}/statistics">
        AllowOverride None
        DirectoryIndex awstats.{DMN_NAME}.html
        Order allow,deny
        Allow from all
    </Directory>
