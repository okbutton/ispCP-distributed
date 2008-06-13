--
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT=0;

START TRANSACTION;
USE {DATABASE};

-- BEGIN: Upgrade database structure:
UPDATE `config` SET `value` = '1' WHERE `name` = 'DATABASE_REVISION' LIMIT 1;
ALTER IGNORE TABLE `sql_user` CHANGE `sqlu_name` `sqlu_name` varchar(64) binary DEFAULT 'n/a';
ALTER IGNORE TABLE `sql_user` CHANGE `sqlu_pass` `sqlu_pass` varchar(64) binary DEFAULT 'n/a';
-- END: Upgrade database structure

-- BEGIN: Regenerate config files:
UPDATE `domain` SET `domain_status` = 'change' WHERE `domain_status` = 'ok';
UPDATE `subdomain` SET `subdomain_status` = 'change' WHERE `subdomain_status` = 'ok';
UPDATE `domain_aliasses` SET `alias_status` = 'change' WHERE `alias_status` = 'ok';
UPDATE `mail_users` SET `status` = 'change' WHERE `status` = 'ok';
-- END: Regenerate config files

COMMIT;

-- Change charset:
ALTER DATABASE `{DATABASE}` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;