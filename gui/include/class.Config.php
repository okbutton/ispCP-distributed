<?php

/**
 * this class will parse the config file and get all variables available in PHP
 */
final class Config {
	/**
	 * config filename
	 */
	private static $_file;
	/**
	 * IMPORTANT: any adding & removing of variables in /etc/ispcp/ispcp.conf should also be made here!
	 * array with all options from config file - predefined with null
	 */
	private static $_values = array(
		'BuildDate' => null,
		'Version' => null,
		'CodeName' => null,
		'DEFAULT_ADMIN_ADDRESS' => null,
		'SERVER_HOSTNAME' => null,
		'BASE_SERVER_IP' => null,
		'BASE_SERVER_VHOST' => null,
		'BASE_SERVER_VHOST_PREFIX' => null,
		'MR_LOCK_FILE' => null,
		'CMD_AWK' => null,
		'CMD_BZCAT' => null,
		'CMD_BZIP' => null,
		'CMD_CHOWN' => null,
		'CMD_CAT' => null,
		'CMD_CHMOD' => null,
		'CMD_CP' => null,
		'CMD_DIFF' => null,
		'CMD_CMP' => null,
		'CMD_DU' => null,
		'CMD_ECHO' => null,
		'CMD_EGREP' => null,
		'CMD_GZCAT' => null,
		'CMD_GZIP' => null,
		'CMD_GREP' => null,
		'CMD_GROUPADD' => null,
		'CMD_GROUPDEL' => null,
		'CMD_HOSTNAME' => null,
		'CMD_IFCONFIG' => null,
		'CMD_IPTABLES' => null,
		'CMD_LN' => null,
		'CMD_LZMA' => null,
		'CMD_MYSQL' => null,
		'CMD_MV' => null,
		'CMD_PS' => null,
		'CMD_RM' => null,
		'CMD_SED' => null,
		'CMD_SHELL' => null,
		'CMD_TAR' => null,
		'CMD_TOUCH' => null,
		'CMD_USERADD' => null,
		'CMD_USERDEL' => null,
		'CMD_WC' => null,
		'PEAR_DIR' => null,
		'DATABASE_TYPE' => null,
		'DATABASE_HOST' => null,
		'DATABASE_NAME' => null,
		'DATABASE_PASSWORD' => null,
		'DATABASE_USER' => null,
		'DATABASE_DIR' => null,
		'CMD_MYSQLDUMP' => null,
		'DATABASE_UTF8' => null,
		'CONF_DIR' => null,
		'LOG_DIR' => null,
		'PHP_STARTER_DIR' => null,
		'ROOT_DIR' => null,
		'ROOT_USER' => null,
		'ROOT_GROUP' => null,
		'GUI_ROOT_DIR' => null,
		'APACHE_WWW_DIR' => null,
		'SCOREBOARDS_DIR' => null,
		'ZIP' => null,
		'PHP5_FASTCGI_BIN' => null,
		'PHP_VERSION' => null,
		'FTPD_CONF_FILE' => null,
		'FTPD_CONF_DIR' => null,
		'BIND_CONF_FILE' => null,
		'BIND_DB_DIR' => null,
		'SECONDARY_DNS' => null,
		'AWSTATS_ACTIVE' => null,
		'AWSTATS_MODE' => null,
		'AWSTATS_CACHE_DIR' => null,
		'AWSTATS_CONFIG_DIR' => null,
		'AWSTATS_ENGINE_DIR' => null,
		'AWSTATS_WEB_DIR' => null,
		'AWSTATS_ROOT_DIR' => null,
		'AWSTATS_GROUP_AUTH' => null,
		'APACHE_NAME' => null,
		'APACHE_RESTART_TRY' => null,
		'APACHE_CONF_DIR' => null,
		'APACHE_CMD' => null,
		'APACHE_LOG_DIR' => null,
		'APACHE_BACKUP_LOG_DIR' => null,
		'APACHE_USERS_LOG_DIR' => null,
		'APACHE_MODS_DIR' => null,
		'APACHE_SITES_DIR' => null,
		'APACHE_CUSTOM_SITES_CONFIG_DIR' => null,
		'APACHE_SUEXEC_USER_PREF' => null,
		'APACHE_SUEXEC_MIN_GID' => null,
		'APACHE_SUEXEC_MAX_GID' => null,
		'APACHE_SUEXEC_MIN_UID' => null,
		'APACHE_SUEXEC_MAX_UID' => null,
		'APACHE_USER' => null,
		'APACHE_GROUP' => null,
		'POSTFIX_CONF_FILE' => null,
		'POSTFIX_MASTER_CONF_FILE' => null,
		'MTA_LOCAL_MAIL_DIR' => null,
		'MTA_VIRTUAL_MAIL_DIR' => null,
		'MTA_LOCAL_ALIAS_HASH' => null,
		'MTA_VIRTUAL_CONF_DIR' => null,
		'MTA_VIRTUAL_ALIAS_HASH' => null,
		'MTA_VIRTUAL_DMN_HASH' => null,
		'MTA_VIRTUAL_MAILBOX_HASH' => null,
		'MTA_TRANSPORT_HASH' => null,
		'MTA_SENDER_ACCESS_HASH' => null,
		'MTA_MAILBOX_MIN_UID' => null,
		'MTA_MAILBOX_UID' => null,
		'MTA_MAILBOX_UID_NAME' => null,
		'MTA_MAILBOX_GID' => null,
		'MTA_MAILBOX_GID_NAME' => null,
		'MTA_SASLDB_FILE' => null,
		'ETC_SASLDB_FILE' => null,
		'CMD_SASLDB_LISTUSERS2' => null,
		'CMD_SASLDB_PASSWD2' => null,
		'CMD_POSTMAP' => null,
		'CMD_NEWALIASES' => null,
		'AUTHLIB_CONF_DIR' => null,
		'CMD_MAKEUSERDB' => null,
		'BACKUP_HOUR' => null,
		'BACKUP_MINUTE' => null,
		'BACKUP_ISPCP' => null,
		'BACKUP_DOMAINS' => null,
		'BACKUP_ROOT_DIR' => null,
		'CMD_CRONTAB' => null,
		'CMD_AMAVIS' => null,
		'CMD_AUTHD' => null,
		'CMD_FTPD' => null,
		'CMD_HTTPD' => null,
		'CMD_IMAP' => null,
		'CMD_IMAP_SSL' => null,
		'CMD_MTA' => null,
		'CMD_NAMED' => null,
		'CMD_POP' => null,
		'CMD_POP_SSL' => null,
		'CMD_ISPCPD' => null,
		'CMD_ISPCPN' => null,
		'CMD_PFLOGSUM' => null,
		'TRAFF_LOG_DIR' => null,
		'FTP_TRAFF_LOG' => null,
		'MAIL_TRAFF_LOG' => null,
		'TRAFF_ROOT_DIR' => null,
		'TOOLS_ROOT_DIR' => null,
		'QUOTA_ROOT_DIR' => null,
		'MAIL_LOG_INC_AMAVIS' => null,
		'USER_INITIAL_THEME' => null,
		'FTP_USERNAME_SEPARATOR' => null,
		'FTP_HOMEDIR' => null,
		'IPS_LOGO_PATH' => null,
		'ISPCP_SUPPORT_SYSTEM_PATH' => null,
		'ISPCP_SUPPORT_SYSTEM_TARGET' => null,
		'MYSQL_PREFIX' => null,
		'MYSQL_PREFIX_TYPE' => null,
		'WEBMAIL_PATH' => null,
		'WEBMAIL_TARGET' => null,
		'PMA_PATH' => null,
		'PMA_TARGET' => null,
		'FILEMANAGER_PATH' => null,
		'FILEMANAGER_TARGET' => null,
		'DATE_FORMAT' => null,
		'RKHUNTER_LOG' => null,
		'CHKROOTKIT_LOG' => null,
		'OTHER_ROOTKIT_LOG' => null,
		'HTACCESS_USERS_FILE_NAME' => null,
		'HTACCESS_GROUPS_FILE_NAME' => null,
		'HTPASSWD_CMD' => null,
		'BACKUP_FILE_DIR' => null,
		'DEBUG' => null
	);
	private static $_status = false;

	public static function load($cfg = '/etc/ispcp/ispcp.conf') {
		self::$_file = $cfg;

		if (!self::_parseFile())
			throw new Exception('Cannot open the ispcp.conf config file!');

		self::$_status = true;
	}

	public static function getValues() {
		if (!self::$_status)
			throw new Exception('Config not loaded!');

		return self::$_values;
	}

	public static function get($param) {
		if (!isset(self::$_values[$param]))
			throw new Exception("Config variable '$param' is missing!");

		if (!self::$_status)
			throw new Exception('Config not loaded!');

		return self::$_values[$param];
	}

	public static function set($param, $value) {
		self::$_values[$param] = $value;
	}

	public static function exists($param) {
		return isset(self::$_values[$param]);
	}

	private static function _parseFile() {
		// open file ... parse it and put it in $cfg_values
		@$fd = fopen(self::$_file, 'r');
		if (!$fd) {
			return false;
		}
		while (!feof($fd)) {
			$buffer = fgets($fd, 4096);
			// remove spaces
			$buffer = ltrim($buffer);
			if (strlen($buffer) > 3 && $buffer[0] != '#' && $buffer[0] != ';'
				&& strpos($buffer, '=') !== false) {
				$pair = explode('=', $buffer, 2);

				$pair[0] = trim($pair[0]);
				$pair[1] = trim($pair[1]);

				// ok we have it :)
				self::$_values[$pair[0]] = $pair[1];
			}
		}
		fclose($fd);

		foreach (self::$_values as $k => $v) {
			if ($v === null) {
				throw new Exception("Config variable '$k' is missing!");
				return false;
			}
		}

		return true;
	}
}
