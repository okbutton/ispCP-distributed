<?php
/**
 *  ispCP (OMEGA) - Virtual Hosting Control System | Omega Version
 *
 *  @copyright 	2001-2006 by moleSoftware GmbH
 *  @copyright 	2006-2007 by ispCP | http://isp-control.net
 *  @link 		http://isp-control.net
 *  @author		ispCP Team (2007)
 *
 *  @license
 *  This program is free software; you can redistribute it and/or modify it under
 *  the terms of the MPL General Public License as published by the Free Software
 *  Foundation; either version 1.1 of the License, or (at your option) any later
 *  version.
 *  You should have received a copy of the MPL Mozilla Public License along with
 *  this program; if not, write to the Open Source Initiative (OSI)
 *  http://opensource.org | osi@opensource.org
 **/

include '../include/ispcp-lib.php';

check_login();

if (isset($_GET['id']) && $_GET['id'] !== '') {
  $sub_id = $_GET['id'];
  $dmn_id = get_user_domain_id($sql, $_SESSION['user_id']);

  $query = <<<SQL_QUERY
        select
             subdomain_id,
             subdomain_name
        from
            subdomain
        where
            domain_id = ?
          and
            subdomain_id = ?
SQL_QUERY;

  $rs = exec_query($sql, $query, array($dmn_id, $sub_id));
  $sub_name = $rs->fields['subdomain_name'];

  if ($rs -> RecordCount() == 0) {
    user_goto('manage_domains.php');
  }

  // check for mail accounts
  $query = "select count(mail_id) as cnt from mail_users WHERE (mail_type = 'subdom_mail' OR mail_type = 'subdom_forward') AND sub_id = ?";
  $rs = exec_query($sql, $query, array($sub_id));

  if ($rs -> fields['cnt'] > 0 ) {
    set_page_message(tr('Subdomain you are trying to remove has email accounts !<br>First remove them!'));
    header('Location: manage_domains.php');
    exit(0);
  }

  check_for_lock_file();

  $query = <<<SQL_QUERY
        update
            subdomain
        set
            subdomain_status = 'delete'
        where
            subdomain_id = ?
SQL_QUERY;

  $rs = exec_query($sql, $query, array($sub_id));
  send_request();
  write_log($_SESSION['user_logged'].": delete subdomain: ".$sub_name);
  set_page_message(tr('Subdomain scheduled for deletion!'));
  header('Location: manage_domains.php');
  exit(0);

} else {

  header('Location: manage_domains.php');
  exit(0);

}

?>
