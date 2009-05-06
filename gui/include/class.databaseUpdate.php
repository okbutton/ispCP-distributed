<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright	2001-2006 by moleSoftware GmbH
 * @copyright	2006-2009 by ispCP | http://isp-control.net
 * @version		SVN: $Id$
 * @link		http://isp-control.net
 * @author		ispCP Team
 *
 * @license
 *   This program is free software; you can redistribute it and/or
 *   modify it under the terms of the GPL General Public License
 *   as published by the Free Software Foundation; either version 2.0
 *   of the License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *   GPL General Public License for more details.
 *
 *   You may have received a copy of the GPL General Public License
 *   along with this program.
 *
 *   An on-line copy of the GPL General Public License can be found
 *   http://www.fsf.org/licensing/licenses/gpl.txt
 */


/**
 * Implementing abstract class ispcpUpdate for database update functions
 *
 * @author	Daniel Andreca <sci2tech@gmail.com>
 * @copyright	2006-2009 by ispCP | http://isp-control.net
 * @version	1.0
 * @since	r1355
 */
class databaseUpdate extends ispcpUpdate {
	protected $databaseVariableName = "DATABASE_REVISION";
	protected $functionName = "_databaseUpdate_";
	protected $errorMessage = "Database update %s failed";

	public static function getInstance() {
		static $instance = null;
		if ($instance === null) $instance = new self();
		return $instance;
	}

	/*
	 * Insert the update functions below this entry. The revision has to be ascending and unique.
	 * Each databaseUpdate function has to return a array. Even if the array contains only one entry.
	 */

	/**
	 * Initital Update. Insert the first Revision.
	 *
	 * @author		Jochen Manz <zothos@zothos.net>
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1355
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_1() {
		$sqlUpd = array();

		$sqlUpd[] = "INSERT INTO `config` (name, value) VALUES ('DATABASE_REVISION' , '1')";

		return $sqlUpd;
	}

	/**
	 * Updates the database fields ispcp.mail_users.mail_addr to the right mail address.
	 *
	 * @author		Christian Hernmarck
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1355
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_2() {
		$sqlUpd = array(); // we need several SQL Statements...

		// domain mail + forward
		$sqlUpd[]	= "UPDATE `mail_users`, `domain`"
					. "SET `mail_addr` = CONCAT(`mail_acc`,'@',`domain_name`)"
					. "WHERE `mail_users`.`domain_id` = `domain`.`domain_id`"
					. "AND (`mail_type` = 'normal_mail' OR `mail_type` = 'normal_forward');";

		// domain-alias mail + forward
		$sqlUpd[]	= "UPDATE `mail_users`, `domain_aliasses`"
					. "SET `mail_addr` = CONCAT(`mail_acc`,'@',`alias_name`)"
					. "WHERE `mail_users`.`domain_id` = `domain_aliasses`.`domain_id` AND `mail_users`.`sub_id` = `domain_aliasses`.`alias_id`"
					. "AND (`mail_type` = 'alias_mail' OR `mail_type` = 'alias_forward');";

		// subdomain mail + forward
		$sqlUpd[]	= "UPDATE `mail_users`, `subdomain`, `domain`"
					. "SET `mail_addr` = CONCAT(`mail_acc`,'@',`subdomain_name`,'.',`domain_name`)"
					. "WHERE `mail_users`.`domain_id` = `subdomain`.`domain_id` AND `mail_users`.`sub_id` = `subdomain`.`subdomain_id`"
					. "AND `mail_users`.`domain_id` = `domain`.`domain_id`"
					. "AND (`mail_type` = 'subdom_mail' OR `mail_type` = 'subdom_forward');";

		// domain catchall
		$sqlUpd[]	= "UPDATE `mail_users`, `domain`"
					. "SET `mail_addr` = CONCAT('@',`domain_name`)"
					. "WHERE `mail_users`.`domain_id` = `domain`.`domain_id`"
					. "AND `mail_type` = 'normal_catchall';";

		// domain-alias catchall
		$sqlUpd[]	= "UPDATE `mail_users`, `domain_aliasses`"
					. "SET `mail_addr` = CONCAT('@',`alias_name`)"
					. "WHERE `mail_users`.`domain_id` = `domain_aliasses`.`domain_id` AND `mail_users`.`sub_id` = `domain_aliasses`.`alias_id`"
					. "AND `mail_type` = 'alias_catchall';";

		// subdomain catchall
		$sqlUpd[]	= "UPDATE `mail_users`, `subdomain`, `domain`"
					. "SET `mail_addr` = CONCAT('@',`subdomain_name`,'.',`domain_name`)"
					. "WHERE `mail_users`.`domain_id` = `subdomain`.`domain_id` AND `mail_users`.`sub_id` = `subdomain`.`subdomain_id`"
					. "AND `mail_users`.`domain_id` = `domain`.`domain_id`"
					. "AND `mail_type` = 'subdom_catchall';";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1139 http://www.isp-control.net/ispcp/ticket/1139.
	 *
	 * @author		Benedikt Heintel
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1355
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_3() {
		$sqlUpd = array();

		$sqlUpd[] = "ALTER IGNORE TABLE `orders_settings` CHANGE `id` `id` int(10) unsigned NOT NULL auto_increment;";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1196 http://www.isp-control.net/ispcp/ticket/1196.
	 *
	 * @author		Benedikt Heintel
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1355
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_4() {
		$sqlUpd = array();

		$sqlUpd[] = "ALTER IGNORE TABLE `mail_users` CHANGE `mail_auto_respond` `mail_auto_respond_text` text collate utf8_unicode_ci;";
		$sqlUpd[] = "ALTER IGNORE TABLE `mail_users` ADD `mail_auto_respond` BOOL NOT NULL default '0' AFTER `status`;";
		$sqlUpd[] = "ALTER IGNORE TABLE `mail_users` CHANGE `mail_type` `mail_type` varchar(30);";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1346 http://www.isp-control.net/ispcp/ticket/1346.
	 *
	 * @author		Benedikt Heintel
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1355
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_5() {
		$sqlUpd = array();

		$sqlUpd[] = "ALTER IGNORE TABLE `sql_user` CHANGE `sqlu_name` `sqlu_name` varchar(64) binary DEFAULT 'n/a';";
		$sqlUpd[] = "ALTER IGNORE TABLE `sql_user` CHANGE `sqlu_pass` `sqlu_pass` varchar(64) binary DEFAULT 'n/a';";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #755 http://www.isp-control.net/ispcp/ticket/755.
	 *
	 * @author		Markus Milkereit
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1355
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_6() {
		$sqlUpd = array();

		$sqlUpd[] = "ALTER IGNORE TABLE `htaccess`
					CHANGE `user_id` `user_id` VARCHAR(255) NULL DEFAULT NULL,
					CHANGE `group_id` `group_id` VARCHAR(255) NULL DEFAULT NULL";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1509 http://www.isp-control.net/ispcp/ticket/1509.
	 *
	 * @author		Benedikt Heintel
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1356
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_7() {
		$sqlUpd = array();

		$sqlUpd[] = "DROP TABLE IF EXISTS `subdomain_alias`";
		$sqlUpd[] = "CREATE TABLE IF NOT EXISTS `subdomain_alias` (
					`subdomain_alias_id` int(10) unsigned NOT NULL auto_increment,
					`alias_id` int(10) unsigned default NULL,
					`subdomain_alias_name` varchar(200) collate utf8_unicode_ci default NULL,
					`subdomain_alias_mount` varchar(200) collate utf8_unicode_ci default NULL,
					`subdomain_alias_status` varchar(255) collate utf8_unicode_ci default NULL,
					PRIMARY KEY (`subdomain_alias_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1571 http://www.isp-control.net/ispcp/ticket/1571.
	 *
	 * @author		Daniel Andreca
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1417
	 * @removed		r1418
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_8() {
		$sqlUpd = array();
		// moved to critical because we need to run engine request
		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1610 http://www.isp-control.net/ispcp/ticket/1610.
	 *
	 * @author		Daniel Andreca
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1462
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_9() {
		$sqlUpd = array();
		$sqlUpd[] = "ALTER TABLE `mail_users`
					CHANGE `mail_acc` `mail_acc` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
					CHANGE `mail_pass` `mail_pass` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
					CHANGE `mail_forward` `mail_forward` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
					CHANGE `mail_type` `mail_type` VARCHAR(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
					CHANGE `status` `status` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL";
		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1664 http://www.isp-control.net/ispcp/ticket/1664.
	 *
	 * @author		Daniel Andreca
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1508
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_10() {
		$sqlUpd = array();
		$sqlUpd[] = "UPDATE `config` SET `value` = CONCAT(`value`, ';') WHERE `name` LIKE \"PORT_%\"";
		$sqlUpd[] = "UPDATE `config` SET `value` = CONCAT(`value`, 'localhost') WHERE `name` IN (\"PORT_POSTGREY\", \"PORT_AMAVIS\", \"PORT_SPAMASSASSIN\", \"PORT_POLICYD-WEIGHT\")";

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1620 http://www.isp-control.net/ispcp/ticket/1620.
	 *
	 * @author		Daniel Andreca
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0
	 * @since		r1550
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_11() {
		$sqlUpd = array();
		$sqlUpd[] = "ALTER TABLE `admin` ADD `state` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `city`";
		$sqlUpd[] = "ALTER TABLE `orders` ADD `state` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL AFTER `city`";
		return $sqlUpd;
	}


	/**
	 * add variable SHOW_SERVERLOAD to config table
	 *
	 * @author		Thomas Häber
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1614
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_12() {
		$sqlUpd = array();
		$sqlUpd[] = "INSERT INTO `config` (name, value) VALUES ('SHOW_SERVERLOAD' , '1')";
		return $sqlUpd;
	}

	/**
	 * add variables PREVENT_EXTERNAL_LOGIN for each user type to config table
	 *
	 * @author		Thomas Häber
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1659
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_13() {
		$sqlUpd = array();
		$sqlUpd[] = "INSERT INTO `config` (name, value) VALUES ('PREVENT_EXTERNAL_LOGIN_ADMIN' , '1')";
		$sqlUpd[] = "INSERT INTO `config` (name, value) VALUES ('PREVENT_EXTERNAL_LOGIN_RESELLER' , '1')";
		$sqlUpd[] = "INSERT INTO `config` (name, value) VALUES ('PREVENT_EXTERNAL_LOGIN_CLIENT' , '1')";
		return $sqlUpd;
	}

	/**
	 * Fixed #1761: Hosting plan description (to short field description in SQL table hosting_plan)
	 *
	 * @author		Thomas Häber
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1663
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_14() {
		$sqlUpd = array();
		$sqlUpd[] = "ALTER TABLE `hosting_plans` CHANGE `description` `description` TEXT";
		return $sqlUpd;
	}
	
	/**
	 * missing db updates for per-domain backup
	 *
	 * @author		Jochen Manz
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1663
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_15() {
		$sqlUpd = array();
		$sqlUpd[] = "ALTER TABLE `domain` ADD `allowbackup` VARCHAR( 8 ) NOT NULL DEFAULT 'full';";
		return $sqlUpd;
	}
	
	/**
	 * update SMTP-SSL to the original Port list, see ticket #1806
	 * http://www.isp-control.net/ispcp/ticket/1806.
	 *
	 * @author		Christian Hernmarck
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1714 (ca)
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_16() {
		$sqlUpd = array();
		$sqlUpd[] = "INSERT IGNORE INTO `config` (`name`, `value`) VALUES ('PORT_SMTP-SSL', '465;tcp;SMTP-SSL;1;0;')";
		return $sqlUpd;
	}

	/**
	 * Clean ticket database: Remove html entities from subjects and messages
	 * Related to ticket #1721 http://www.isp-control.net/ispcp/ticket/1721.
	 *
	 * @author		Thomas Wacker
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1718
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_17() {
		$sqlUpd = array();
		$sql = Database::getInstance();
		$query	= "SELECT `ticket_id`, `ticket_subject`, `ticket_message`"
				. " FROM `tickets` ORDER BY `ticket_id`";
		$rs = exec_query($sql, $query);
		if ($rs->RecordCount() != 0) {
			while (!$rs->EOF) {
				$subject = html_entity_decode($rs->fields['ticket_subject'], ENT_QUOTES, 'UTF-8');
				$message = html_entity_decode($rs->fields['ticket_message'], ENT_QUOTES, 'UTF-8');
				if ($subject != $rs->fields['ticket_subject']
					|| $message != $rs->fields['ticket_message']) {
					$sqlUpd[] = "UPDATE `tickets` SET"
							. " `ticket_subject` = '".addslashes($subject)."'"
							. ", `ticket_message` = '".addslashes($message)."'"
							. " WHERE `ticket_id` = '".addslashes($rs->fields['ticket_id'])."'";
				}
				$rs->MoveNext();
			}
		}

		return $sqlUpd;
	}

	/**
	 * Fix for ticket #1810 http://www.isp-control.net/ispcp/ticket/1810.
	 *
	 * @author		Daniel Andreca
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1726
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_18() {
		$sqlUpd = array();
		//moved to 19
		return $sqlUpd;
	}

	/**
	 * Add suport for DNS management.
	 *
	 * @author		Daniel Andreca
	 * @copyright	2006-2009 by ispCP | http://isp-control.net
	 * @version		1.0.1
	 * @since		r1727
	 *
	 * @access		protected
	 * @return		sql statements to be performed
	 */
	protected function _databaseUpdate_19() {
		$sqlUpd = array();
		$sqlUpd[]	= "CREATE TABLE IF NOT EXISTS `domain_dns` (
					`domain_dns_id` int(11) NOT NULL auto_increment,
					`domain_id` int(11) NOT NULL,
					`alias_id` int(11) default NULL,
					`domain_dns` varchar(50) collate utf8_unicode_ci NOT NULL,
					`domain_class` enum('IN','CH','HS') collate utf8_unicode_ci NOT NULL default 'IN',
					`domain_type` enum('A','AAAA','CERT','CNAME','DNAME','GPOS','KEY','KX','MX','NAPTR','NSAP','NS ​','NXT','PTR','PX','SIG','SRV','TXT') collate utf8_unicode_ci NOT NULL default 'A',
					`domain_text` varchar(128) collate utf8_unicode_ci NOT NULL,
					PRIMARY KEY  (`domain_dns_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
		$sqlUpd[]	= "ALTER IGNORE TABLE `domain` ADD `domain_dns` VARCHAR( 15 ) NOT NULL DEFAULT 'no';";
		$sqlUpd[]	= "UPDATE `hosting_plans` SET `props`=CONCAT(`props`,'_no_;') ";
		$sqlUpd[]	= "UPDATE `config` SET `value` = '465;tcp;SMTP-SSL;1;0;' WHERE `name` = 'PORT_SMTP-SSL';";
		return $sqlUpd;
	}

	/*
	 * DO NOT CHANGE ANYTHING BELOW THIS LINE!
	 */
}
