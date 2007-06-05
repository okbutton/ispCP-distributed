<?php
/**
 *  ispCP (OMEGA) a Virtual Hosting Control Panel
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
 *
 **/

/* for mail types */
define('MT_NORMAL_MAIL',     'normal_mail');
define('MT_NORMAL_FORWARD',  'normal_forward');
define('MT_ALIAS_MAIL',      'alias_mail');
define('MT_ALIAS_FORWARD',   'alias_forward');
define('MT_SUBDOM_MAIL',     'subdom_mail');
define('MT_SUBDOM_FORWARD',  'subdom_forward');
define('MT_NORMAL_CATCHALL', 'normal_catchall');
define('MT_ALIAS_CATCHALL',  'alias_catchall');


function gen_reseller_mainmenu(&$tpl, $menu_file) {

	global $sql, $cfg;

	$tpl -> define_dynamic('menu', $menu_file);

	$tpl -> define_dynamic('custom_buttons', 'menu');

	$tpl -> assign(
				array(
					'TR_MENU_GENERAL_INFORMATION' => tr('General information'),
					'TR_MENU_CHANGE_PASSWORD' => tr('Change password'),
					'TR_MENU_CHANGE_PERSONAL_DATA' => tr('Change personal data'),
					'TR_MENU_HOSTING_PLANS' => tr('Manage hosting plans'),
					'TR_MENU_ADD_HOSTING' => tr('Add hosting plan'),
					'TR_MENU_MANAGE_USERS' => tr('Manage users'),
					'TR_MENU_ADD_USER' => tr('Add user'),
					'TR_MENU_E_MAIL_SETUP' => tr('Email setup'),
					'TR_MENU_CIRCULAR' => tr('Email marketing'),
					'TR_MENU_MANAGE_DOMAINS' => tr('Manage domains'),
					'TR_MENU_DOMAIN_ALIAS' => tr('Domain alias'),
					'TR_MENU_SUBDOMAINS' => tr('Subdomains'),
					'TR_MENU_DOMAIN_STATISTICS' => tr('Domain statistics'),
					'TR_MENU_QUESTIONS_AND_COMMENTS' => tr('Support system'),
					'TR_MENU_NEW_TICKET' => tr('New ticket'),
					'TR_MENU_LAYOUT_SETTINGS' => tr('Layout settings'),
					'TR_MENU_LOGOUT' => tr('Logout'),
					'TR_MENU_OVERVIEW' => tr('Overview'),
					'TR_MENU_LANGUAGE'  => tr('Language'),
					'SUPPORT_SYSTEM_PATH' => $cfg['ISPCP_SUPPORT_SYSTEM_PATH'],
					'SUPPORT_SYSTEM_TARGET' => $cfg['ISPCP_SUPPORT_SYSTEM_TARGET'],
					'TR_MENU_ORDERS' => tr('Manage Orders'),
					'TR_MENU_ORDER_SETTINGS' => tr('Order settings'),
					'TR_MENU_ORDER_EMAIL' => tr('Order email setup'),
					'TR_MENU_LOSTPW_EMAIL' => tr('Lostpw email setup'),
				)
			);

	$query = <<<SQL_QUERY
        select
            *
        from
            custom_menus
        where
            menu_level = 'reseller'
          or
            menu_level = 'all'
SQL_QUERY;

    $rs = exec_query($sql, $query, array());
	if ($rs -> RecordCount() == 0) {

        $tpl -> assign('CUSTOM_BUTTONS', '');

    } else {

		global $i;
		$i = 100;

		while (!$rs -> EOF) {

			$menu_name = $rs -> fields['menu_name'];
			$menu_link = get_menu_vars($rs -> fields['menu_link']);
			$menu_target = $rs -> fields['menu_target'];

			if ($menu_target !== ""){
				$menu_target = "target=\"".$menu_target."\"";
			}

			$tpl -> assign(
	                  array(
	                        'BUTTON_LINK' => $menu_link,
	                        'BUTTON_NAME' => $menu_name,
	                        'BUTTON_TARGET' => $menu_target,
	                        'BUTTON_ID' => $i,
	                        )
	                  );

	    	$tpl -> parse('CUSTOM_BUTTONS', '.custom_buttons');
	    	$rs -> MoveNext(); $i++;

		} // end while
	} // end else

	if ($cfg['ISPCP_SUPPORT_SYSTEM'] != 1) {

		$tpl -> assign('SUPPORT_SYSTEM', '');

	}

	$tpl -> parse('MAIN_MENU', 'menu');

}// End of gen_reseller_menu()



	// Function to generate the manu data for reseller
function gen_reseller_menu(&$tpl, $menu_file) {

	global $sql, $cfg;

	$tpl -> define_dynamic('menu', $menu_file);

	$tpl -> define_dynamic('custom_buttons', 'menu');

	$tpl -> assign(
				array(
					'TR_MENU_GENERAL_INFORMATION' => tr('General information'),
					'TR_MENU_CHANGE_PASSWORD' => tr('Change password'),
					'TR_MENU_CHANGE_PERSONAL_DATA' => tr('Change personal data'),
					'TR_MENU_HOSTING_PLANS' => tr('Manage hosting plans'),
					'TR_MENU_ADD_HOSTING' => tr('Add hosting plan'),
					'TR_MENU_MANAGE_USERS' => tr('Manage users'),
					'TR_MENU_ADD_USER' => tr('Add user'),
					'TR_MENU_E_MAIL_SETUP' => tr('Email setup'),
					'TR_MENU_CIRCULAR' => tr('Email marketing'),
					'TR_MENU_MANAGE_DOMAINS' => tr('Manage domains'),
					'TR_MENU_DOMAIN_ALIAS' => tr('Domain alias'),
					'TR_MENU_SUBDOMAINS' => tr('Subdomains'),
					'TR_MENU_DOMAIN_STATISTICS' => tr('Domain statistics'),
					'TR_MENU_QUESTIONS_AND_COMMENTS' => tr('Support system'),
					'TR_MENU_NEW_TICKET' => tr('New ticket'),
					'TR_MENU_LAYOUT_SETTINGS' => tr('Layout settings'),
					'TR_MENU_LOGOUT' => tr('Logout'),
					'TR_MENU_OVERVIEW' => tr('Overview'),
					'TR_MENU_LANGUAGE'  => tr('Language'),
					'SUPPORT_SYSTEM_PATH' => $cfg['ISPCP_SUPPORT_SYSTEM_PATH'],
					'SUPPORT_SYSTEM_TARGET' => $cfg['ISPCP_SUPPORT_SYSTEM_TARGET'],
					'TR_MENU_ORDERS' => tr('Manage Orders'),
					'TR_MENU_ORDER_SETTINGS' => tr('Order settings'),
					'TR_MENU_ORDER_EMAIL' => tr('Order email setup'),
					'TR_MENU_LOSTPW_EMAIL' => tr('Lostpw email setup'),
				)
			);

	$query = <<<SQL_QUERY
        select
            *
        from
            custom_menus
        where
            menu_level = 'reseller'
          or
            menu_level = 'all'
SQL_QUERY;

	$rs = exec_query($sql, $query, array());
	if ($rs -> RecordCount() == 0) {

        $tpl -> assign('CUSTOM_BUTTONS', '');

    } else {

		global $i;
		$i = 100;

		while (!$rs -> EOF) {

			$menu_name = $rs -> fields['menu_name'];
			$menu_link = get_menu_vars($rs -> fields['menu_link']);
			$menu_target = $rs -> fields['menu_target'];

			if ($menu_target !== ""){
				$menu_target = "target=\"".$menu_target."\"";
			}

			$tpl -> assign(
	                  array(
	                        'BUTTON_LINK' => $menu_link,
	                        'BUTTON_NAME' => $menu_name,
	                        'BUTTON_TARGET' => $menu_target,
	                        'BUTTON_ID' => $i,
	                        )
	                  );

	    	$tpl -> parse('CUSTOM_BUTTONS', '.custom_buttons');
	    	$rs -> MoveNext(); $i++;

		} // end while
	} // end else

	if ($cfg['ISPCP_SUPPORT_SYSTEM'] != 1) {

		$tpl -> assign('SUPPORT_SYSTEM', '');

	}

	$tpl -> parse('MENU', 'menu');

}// End of gen_reseller_menu()

// Get data for page of reseller
function get_reseller_default_props(&$sql, $reseller_id) {
	// Make sql query
	$query = <<<SQL_QUERY
        select
            *
        from
            reseller_props
        where
            reseller_id = ?
SQL_QUERY;
	// send sql query
	$rs = exec_query($sql, $query, array($reseller_id));

	if (0 == $rs->RowCount()) {
       	return NULL;
    }

	return array($rs -> fields['current_dmn_cnt'],
				$rs -> fields['max_dmn_cnt'],
				$rs -> fields['current_sub_cnt'],
				$rs -> fields['max_sub_cnt'],
				$rs -> fields['current_als_cnt'],
				$rs -> fields['max_als_cnt'],
				$rs -> fields['current_mail_cnt'],
				$rs -> fields['max_mail_cnt'],
				$rs -> fields['current_ftp_cnt'],
				$rs -> fields['max_ftp_cnt'],
				$rs -> fields['current_sql_db_cnt'],
				$rs -> fields['max_sql_db_cnt'],
				$rs -> fields['current_sql_user_cnt'],
				$rs -> fields['max_sql_user_cnt'],
				$rs -> fields['current_traff_amnt'],
				$rs -> fields['max_traff_amnt'],
				$rs -> fields['current_disk_amnt'],
				$rs -> fields['max_disk_amnt']
			);
}// End of get_reseller_default_props()

// Makeing user's probs
function generate_reseller_user_props ( $reseller_id ) {

	global $sql;

	// Init with empty variables
	$rdmn_current = 0; $rdmn_max = 0; $rdmn_uf = '_off_';
	$rsub_current = 0; $rsub_max = 0; $rsub_uf = '_off_';
	$rals_current = 0; $rals_max = 0; $rals_uf = '_off_';
	$rmail_current = 0; $rmail_max = 0; $rmail_uf = '_off_';
	$rftp_current = 0; $rftp_max = 0; $rftp_uf = '_off_';
	$rsql_db_current = 0; $rsql_db_max = 0; $rsql_db_uf = '_off_';
	$rsql_user_current = 0; $rsql_user_max = 0; $rsql_user_uf = '_off_';
	$rtraff_current = 0; $rtraff_max = 0; $rtraff_uf = '_off_';
	$rdisk_current = 0; $rdisk_max = 0; $rdisk_uf = '_off_';

	$ResArray = array($rdmn_current, $rdmn_max, $rdmn_uf,
                  $rsub_current, $rsub_max, $rsub_uf,
                  $rals_current, $rals_max, $rals_uf,
                  $rmail_current, $rmail_max, $rmail_uf,
                  $rftp_current, $rftp_max, $rftp_uf,
                  $rsql_db_current, $rsql_db_max, $rsql_db_uf,
                  $rsql_user_current, $rsql_user_max, $rsql_user_uf,
                  $rtraff_current, $rtraff_max, $rtraff_uf,
                  $rdisk_current, $rdisk_max, $rdisk_uf);

    $query = <<<SQL_QUERY
        select
            admin_id
        from
            admin
        where
            created_by = ?
SQL_QUERY;

	$res = exec_query($sql, $query, array($reseller_id));

	if ($res -> RowCount() == 0) {
		return array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
	}

	// Process all users of this group
	while ($data = $res -> FetchRow()) {

		$admin_id = $data['admin_id'];

		$query = <<<SQL_QUERY
	          select
	              domain_id
	          from
	              domain
	          where
	              domain_admin_id = ?
SQL_QUERY;

		$dres = exec_query($sql, $query, array($admin_id));

		$ddata = $dres -> FetchRow();

		$user_id = $ddata['domain_id'];

		list (
				$sub_current, $sub_max,
				$als_current, $als_max,
				$mail_current, $mail_max,
				$ftp_current, $ftp_max,
				$sql_db_current, $sql_db_max,
				$sql_user_current, $sql_user_max,
				$traff_max, $disk_max
				) = get_user_props($user_id);

		list (
				$tmpval1,
				$tmpval2,
				$tmpval3,
				$tmpval4,
				$tmpval5,
				$tmpval16,
				$traff_current,
				$disk_current,
				$tmpval7,
				$tmpval8
				) = generate_user_traffic($user_id);

		$rdmn_current += 1;

		if ($sub_max != -1) {

			if ($sub_max == 0) $rsub_uf = '_on_';

			$rsub_current += $sub_current;
			$rsub_max += $sub_max;

		}

		if ($als_max != -1) {

			if ($als_max == 0) $rals_uf = '_on_';

			$rals_current += $als_current;
			$rals_max += $als_max;

		}

		if ($mail_max == 0) $rmail_uf = '_on_';

		$rmail_current += $mail_current;
		$rmail_max += $mail_max;

		if ($ftp_max == 0) $rftp_uf = '_on_';

		$rftp_current += $ftp_current;
		$rftp_max += $ftp_max;

		if ($sql_db_max != -1) {

			if ($sql_db_max == 0) $rsql_db_uf = '_on_';

			$rsql_db_current += $sql_db_current;
			$rsql_db_max += $sql_db_max;

		}

		if ($sql_user_max != -1) {

			if ($sql_user_max == 0) $rsql_user_uf = '_on_';

			$rsql_user_current += $sql_user_current;
			$rsql_user_max += $sql_user_max;

		}

		if ($traff_max == 0) $rtraff_uf = '_on_';

		$rtraff_current += $traff_current;
		$rtraff_max += $traff_max;
		//print $rtraff_current."<br>"; //- debug shit

		if ($disk_max == 0) $rdisk_uf = '_on_';

		$rdisk_current += $disk_current;
		$rdisk_max += $disk_max;
		//print $rdisk_current."<br>"; //- debug shit

	}

	$ResArray = array($rdmn_current, $rdmn_max, $rdmn_uf,
	                  $rsub_current, $rsub_max, $rsub_uf,
	                  $rals_current, $rals_max, $rals_uf,
	                  $rmail_current, $rmail_max, $rmail_uf,
	                  $rftp_current, $rftp_max, $rftp_uf,
	                  $rsql_db_current, $rsql_db_max, $rsql_db_uf,
	                  $rsql_user_current, $rsql_user_max, $rsql_user_uf,
	                  $rtraff_current, $rtraff_max, $rtraff_uf,
	                  $rdisk_current, $rdisk_max, $rdisk_uf);
	return $ResArray;

}// End of generate_reseller_user_props()

// Get traffic information for user
function get_user_traffic($user_id) {
	global $sql, $crnt_month, $crnt_year;

	$query = <<<SQL_QUERY
			select
				domain_id,
				IFNULL(domain_disk_usage, 0) as domain_disk_usage,
				IFNULL(domain_traffic_limit, 0) as domain_traffic_limit,
				IFNULL(domain_disk_limit,0) as domain_disk_limit,
				domain_name
			from
				domain
			where
				domain_id = ?
			order by
				domain_id
SQL_QUERY;

	$res = exec_query($sql, $query, array($user_id));

	if ($res -> RowCount() == 0 || $res -> RowCount() > 1) {

		//write_log("TRAFFIC WARNING: >$user_id< manages incorrect number of domains >".$res -> RowCount()."<");
		return array('n/a', 0, 0, 0, 0, 0, 0, 0, 0, 0);

	} else {

		$data = $res -> FetchRow();

		$domain_id = $data['domain_id'];

		$domain_disk_usage = $data['domain_disk_usage'];

		$domain_traff_limit = $data['domain_traffic_limit'];

		$domain_disk_limit = $data['domain_disk_limit'];

		$domain_name = $data['domain_name'];

		$query = <<<SQL_QUERY
          select
              sum(dtraff_web) as web,
              sum(dtraff_ftp) as ftp,
              sum(dtraff_mail) as smtp,
              sum(dtraff_pop) as pop,
              sum(dtraff_web) +
              sum(dtraff_ftp) +
              sum(dtraff_mail) +
              sum(dtraff_pop) as total
          from
              domain_traffic
          where
              domain_id = ?
SQL_QUERY;

		$res = exec_query($sql, $query, array($domain_id));

		$data = $res -> FetchRow();

		return array(
					$domain_name,
					$domain_id,
					$data['web'],
					$data['ftp'],
					$data['smtp'],
					$data['pop'],
					$data['total'],
					$domain_disk_usage,
					$domain_traff_limit,
					$domain_disk_limit
					);

		}

}//End of get_user_traffic()


// Get user's probs info from sql
function get_user_props ( $user_id ) {

	global $sql;

	$query = <<<SQL_QUERY
    select
        *
    from
        domain
    where
        domain_id  = ?
SQL_QUERY;

	$res = exec_query($sql, $query, array($user_id));

	if ($res -> RowCount() == 0) {

		return array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);

	}

	$data = $res -> FetchRow();

	$sub_current = records_count('subdomain_id', 'subdomain', 'domain_id', $user_id);
	$sub_max = $data['domain_subd_limit'];

	$als_current = records_count('alias_id', 'domain_aliasses', 'domain_id', $user_id);
	$als_max = $data['domain_alias_limit'];

	$mail_current = records_count('mail_id', 'mail_users', 'domain_id', $user_id);
	$mail_max = $data['domain_mailacc_limit'];

	$ftp_current = sub_records_rlike_count(
											'domain_name', 'domain', 'domain_id', $user_id,
											'userid', 'ftp_users', 'userid', '@', ''
										);

	$ftp_current += sub_records_rlike_count(
											'subdomain_name', 'subdomain', 'domain_id', $user_id,
											'userid', 'ftp_users', 'userid', '@', ''
										);

	$ftp_current += sub_records_rlike_count(
											'alias_name', 'domain_aliasses', 'domain_id', $user_id,
											'userid', 'ftp_users', 'userid', '@', ''
										);

	$ftp_max = $data['domain_ftpacc_limit'];

	$sql_db_current = records_count('sqld_id', 'sql_database', 'domain_id', $user_id);
	$sql_db_max = $data['domain_sqld_limit'];

	$sql_user_current = get_domain_running_sqlu_acc_cnt(&$sql, $user_id);

	$sql_user_max = $data['domain_sqlu_limit'];

	$traff_max = $data['domain_traffic_limit'];

	$disk_max = $data['domain_disk_limit'];

	// Make return data
	return array(
					$sub_current, $sub_max,
					$als_current, $als_max,
					$mail_current, $mail_max,
					$ftp_current, $ftp_max,
					$sql_db_current, $sql_db_max,
					$sql_user_current, $sql_user_max,
					$traff_max, $disk_max
					);

}// End of get_user_props();



function rsl_full_domain_check ( $data ) {

	$data .= '.';
	$match = array();
	$last_match = array();

	$res = preg_match_all(
							"/([^\.]*\.)/",
							$data,
							$match,
							PREG_PATTERN_ORDER
						);

	if ($res == 0) return 0;

	$last = $res - 1;

	for ($i = 0; $i < $last ; $i++) {

		$token = chop($match[0][$i], ".");

		$res = check_dn_rsl_token($token);

		if ($res == 0) return 0;
	}

	$res = preg_match(
						"/^[A-Za-z][A-Za-z0-9]*[A-Za-z]\.$/",
						$match[0][$last],
						$last_match
					);

	if ($res == 0) return 0;


	return 1;
}// End of  full_domain_check()

//Generate ip list
function generate_ip_list(&$tpl, &$reseller_id) {

    global $sql;
    global $domain_ip;

    $query = <<<SQL_QUERY
        select
            reseller_ips
        from
            reseller_props
        where
            reseller_id = ?
SQL_QUERY;

    $res = exec_query($sql, $query, array($reseller_id));

    $data = $res -> FetchRow();

    $reseller_ips = $data['reseller_ips'];

    $query = <<<SQL_QUERY
        select * from server_ips
SQL_QUERY;

    $res = exec_query($sql, $query, array());

    while ($data = $res -> FetchRow()) {

        $ip_id = $data['ip_id'];

        if (preg_match("/$ip_id;/", $reseller_ips) == 1) {

            $selected = '';

            if ($domain_ip === $ip_id) {
            	$selected = 'selected';
            }

            $tpl -> assign(
                            array(
                                    'IP_NUM' => $data['ip_number'],
                                    'IP_NAME' => $data['ip_domain'],
                                    'IP_VALUE' => $ip_id,
                                    'IP_SELECTED' => "$selected"
                                 )
                          );

            $tpl -> parse('IP_ENTRY', '.ip_entry');
        }
    }// End loop

}// End of generate_ip_list()


// Check validity of input data
function check_ruser_data (&$tpl, $NoPass) {

	global $dmn_name, $hpid , $dmn_user_name;
	global $user_email, $customer_id, $first_name;
    global $last_name, $firm, $zip;
    global $city, $country, $street_one;
	global $street_two, $mail, $phone;
	global $fax, $inpass, $domain_ip;

    $rau_error = '_off_';
	$inpass_re = '';

	// Get data for fields from previus page
	if(isset($_POST['userpassword']))
		$inpass	 = $_POST['userpassword'];

	if(isset($_POST['userpassword_repeat']))
		$inpass_re	 = $_POST['userpassword_repeat'];

	if(isset($_POST['domain_ip']))
		$domain_ip	 = $_POST['domain_ip'];

	if(isset($_POST['useremail']))
		$user_email	 = $_POST['useremail'];

	if(isset($_POST['useruid']))
		$customer_id = $_POST['useruid'];

	if(isset($_POST['userfname']))
		$first_name  = $_POST['userfname'];

	if(isset($_POST['userlname']))
		$last_name	 = $_POST['userlname'];

	if(isset($_POST['userfirm']))
		$firm	 	 = $_POST['userfirm'];

	if(isset($_POST['userzip']))
		$zip = $_POST['userzip'];

	if(isset($_POST['usercity']))
		$city = $_POST['usercity'];

	if(isset($_POST['usercountry']))
		$country = $_POST['usercountry'];

	if(isset($_POST['userstreet1']))
		$street_one = $_POST['userstreet1'];

	if(isset($_POST['userstreet2']))
		$street_two	 = $_POST['userstreet2'];

	if(isset($_POST['useremail']))
		$mail	 = $_POST['useremail'];

	if(isset($_POST['userphone']))
		$phone = $_POST['userphone'];

	if(isset($_POST['userfax']))
		$fax = $_POST['userfax'];

	//if(isset($_SESSION['local_data']) )
	//	list($dmn_name, $hpid, $dmn_user_name) = explode(";", $_SESSION['local_data']);

	// Begin checking...
	if('_no_' == $NoPass) {
		if (('' === $inpass_re) || ('' === $inpass)){

			$rau_error = tr('Please fill up both data fields for password!');

		} else if ($inpass_re !== $inpass ){

			$rau_error = tr('Passwords does not match!');

		} else if (chk_password($inpass)) {

			$rau_error = tr('Incorrect password range or syntax!');
		}
    }

    if ($user_email == NULL) {
    	$rau_error = tr('Incorrect email range or syntax!');
    }
	/* we don't wannt to validate Customer ID, First and Second name and also ZIP

	else if(!ispcp_limit_check($customer_id, 999)){

		$rau_error = tr('Incorrect customer ID syntax!');
	}
	else if(!ispcp_name_check($first_name, 40)){

		$rau_error = tr('Incorrect first name range or syntax!');
	}else if(!ispcp_name_check($last_name, 40)){

		$rau_error = tr('Incorrect second name range or syntax!');
	}else if(!ispcp_limit_check($zip, 999999)){

		$rau_error = tr('Incorrect post code range or syntax!');
	} */


    if ($rau_error == '_off_') {

		// send data throught session
        $_SESSION['Message'] = NULL;

		return true;

    } else {
        $_SESSION['Message'] = $rau_error;

        return false;
    }

	return false;
}//End of check_ruser_data()

// Translate domain status
function translate_dmn_status ($status) {

	global $cfg;

    if ( $status == $cfg['ITEM_OK_STATUS']) {

        return tr('ok');

    } else if ( $status == $cfg['ITEM_ADD_STATUS']) {

        return tr('wait to be added');

    } else if ( $status == $cfg['ITEM_CHANGE_STATUS']) {

        return tr('wait to be modified');

    } else if ( $status == $cfg['ITEM_DELETE_STATUS']) {

        return tr('wait to be deleted');

    } else if ( $status == $cfg['ITEM_DISABLED_STATUS']) {

        return tr('suspended');

    } else if ($status == $cfg['ITEM_TOENABLE_STATUS']) {

        return tr('wait to be enabled');

    } else if ($status == $cfg['ITEM_TODISABLED_STATUS']) {

        return tr('wait to be suspended');
    }
	else {

        return tr('unknown status');

    }

}// End of translate_dmn_status()



// Check if the domain already exist
function ispcp_domain_exists ($domain_name, $reseller_id) {
  global $sql;

  // query to check if the domain name exist in the table for domains/accounts
  $query_domain = <<<SQL_QUERY
      select
          count(domain_id) as cnt
      from
          domain
      where
          domain_name = ?
SQL_QUERY;

  $res_domain = exec_query($sql, $query_domain, array($domain_name));


  // query to check if the domain name exist in the table for domain aliases
  $query_alias = <<<SQL_QUERY
      select
          count(t1.alias_id) as cnt
      from
          domain_aliasses as t1, domain as t2
      where
          t1.domain_id = t2.domain_id
      and
          t1.alias_name = ?
SQL_QUERY;

  $res_aliases = exec_query($sql, $query_alias, array($domain_name));
  // redefine query to check in the table domain/acounts if 3th level for this reseller is allowed
  $query_domain = <<<SQL_QUERY
      select
          count(domain_id) as cnt
      from
          domain
      where
          domain_name = ?
      and
          domain_created_id <> ?
SQL_QUERY;

  // redefine query to check in the table aliases if 3th level for this reseller is allowed
  $query_alias = <<<SQL_QUERY
      select
          count(t1.alias_id) as cnt
      from
          domain_aliasses as t1, domain as t2
      where
          t1.domain_id = t2.domain_id
      and
          t1.alias_name = ?
      and
          t2.domain_created_id <> ?
SQL_QUERY;

  // here we split the domain name by point separator
  $split_domain = explode(".", trim($domain_name));
  $dom_cnt = strlen(trim($domain_name));
  $dom_part_cnt = 0;
  $error = 0;

  // here starts a loop to check if the splitted domain is available for other resellers
  for($i=0; $i < count($split_domain) -1; $i++){
       $dom_part_cnt = $dom_part_cnt + strlen($split_domain[$i]) + 1;
       $idom = substr($domain_name, $dom_part_cnt);

       // execute query the redefined queries for domains/accounts and aliases tables
       $res2 = exec_query($sql, $query_domain, array($idom, $reseller_id));
       $res3 = exec_query($sql, $query_alias,  array($idom, $reseller_id));

      // do we have available record. id yes => the variable error get value different 0
      if ($res2 -> fields['cnt'] > 0 || $res3 -> fields['cnt'] > 0) {
          $error ++;
      }
  }

   // if we have :
   // db entry in the tables domain
   // AND
   // no problem with 3th level domains
   // AND
   // enduser (no reseller)
   // => the function returns OK => domain can be added
   if ($res_domain -> fields['cnt'] == 0 && $res_aliases -> fields['cnt'] == 0 && $error == 0 && $reseller_id == 0) {
       return false;
   }

   // if we have domain addion by end user
   // OR
   // some error
   // => the funcion returns ERROR
   if ($reseller_id == 0 || $error) {
       return true;
   }

   // ok we do not have end user and we do not have error => the fun goes on :-)
   // query to check if the domain does not exist as subdomain
   $query_build_subdomain = <<<SQL_QUERY
      select
          t1.subdomain_name, t2.domain_name
      from
          subdomain as t1, domain as t2
      where
          t1.domain_id = t2.domain_id
      and
          t2.domain_created_id = ?
SQL_QUERY;

   $subdomains = array();
   $res_build_sub = exec_query($sql, $query_build_subdomain, array($reseller_id));
   while (!$res_build_sub -> EOF) {
      $subdomains[] = $res_build_sub -> fields['subdomain_name'].".".$res_build_sub -> fields['domain_name'];
      $res_build_sub -> MoveNext();
   }

   if ($res_domain -> fields['cnt'] == 0 && $res_aliases -> fields['cnt'] == 0 && !in_array($domain_name, $subdomains)) {
      return false;
   } else {
      return true;
   }

} // End of ispcp_domain_exists()


function gen_manage_domain_query (&$search_query,
                                  &$count_query,
                                  $reseller_id,
                                  $start_index,
                                  $rows_per_page,
                                  $search_for,
                                  $search_common,
                                  $search_status)
{
  // IMHO, this code is an unmaintainable mess and should be replaced - Cliff

  if ($search_for === 'n/a' && $search_common === 'n/a' && $search_status === 'n/a') {
    //
    // We have pure list query;
    //
    $count_query = <<<SQL_QUERY
                select
                    count(domain_id) as cnt
                from
                    domain
                where
                    domain_created_id = '$reseller_id'
SQL_QUERY;

    $search_query = <<<SQL_QUERY
                 select
                    *
                 from

                    domain
                 where
                    domain_created_id = '$reseller_id'
                 order by
                    domain_name asc
                 limit
                    $start_index, $rows_per_page
SQL_QUERY;

  } else if ($search_for === '' && $search_status != '') {
    if ($search_status === 'all') {
      $add_query = <<<SQL_QUERY
                  domain_created_id = '$reseller_id'
SQL_QUERY;
    } else {
      $add_query = <<<SQL_QUERY
                  domain_created_id = '$reseller_id'
                and
                  domain_status = '$search_status'
SQL_QUERY;
    }

    $count_query = <<<SQL_QUERY
                select
                    count(domain_id) as cnt
                from
                    domain
                where
                   $add_query
SQL_QUERY;

    $search_query = <<<SQL_QUERY
                 select
                    *
                 from
                    domain
                 where
                    $add_query
                 order by
                    domain_name asc
                 limit
                    $start_index, $rows_per_page
SQL_QUERY;

  } else if ($search_for != '') {
    if ($search_common === 'domain_name') {
      $add_query = "where admin_name rlike '". addslashes($search_for) . "' %s";
    } else if ($search_common === 'customer_id') {
      $add_query = "where customer_id rlike '" . addslashes($search_for) . "' %s";
    } else if ($search_common === 'lname') {
      $add_query = "where (lname rlike '" . addslashes($search_for) . "' or fname rlike '" . addslashes($search_for) . "') %s";
    } else if ($search_common === 'firm') {
      $add_query = "where firm rlike '" . addslashes($search_for) . "' %s";
    } else if ($search_common === 'city') {
      $add_query = "where city rlike '" . addslashes($search_for) . "' %s";
    } else if ($search_common === 'country') {
      $add_query = "where country rlike '" . addslashes($search_for) . "' %s";
    }

    if ($search_status != 'all') {
      $add_query = sprintf($add_query, " and t1.created_by = '$reseller_id' and t2.domain_status = '$search_status'");
      $count_query = <<<SQL_QUERY
        select
            count(admin_id) as cnt
        from
            admin  as t1,
            domain as t2
        $add_query
          and
            t1.admin_id = t2.domain_admin_id
SQL_QUERY;

    } else {
      $add_query = sprintf($add_query, " and created_by = '$reseller_id'");
      $count_query = <<<SQL_QUERY
          select
              count(admin_id) as cnt
          from
              admin
          $add_query
SQL_QUERY;
    }

    $search_query = <<<SQL_QUERY
          select
              t1.admin_id, t2.*
          from
              admin as t1,
              domain as t2
          $add_query
            and
              t1.admin_id = t2.domain_admin_id
          order by
               t2.domain_name asc
          limit
               $start_index, $rows_per_page
SQL_QUERY;
  }
}


function gen_manage_domain_search_options  (&$tpl,
                                            $search_for,
                                            $search_common,
                                            $search_status)
{
	if ($search_for === 'n/a' && $search_common === 'n/a' && $search_status === 'n/a')
	{
		// we have no search and let's genarate search fields empty

		$domain_selected = "selected";
		$customerid_selected = "";
		$lastname_selected = "";
		$company_selected = "";
		$city_selected = "";
		$country_selected = "";

		$all_selected = "selected";
		$ok_selected = "";
		$suspended_selected = "";

	} if ($search_common === 'domain_name') {

		$domain_selected = "selected";
		$customerid_selected = "";
		$lastname_selected = "";
		$company_selected = "";
		$city_selected = "";
		$country_selected = "";

	} else if ($search_common === 'customer_id') {

		$domain_selected = "";
		$customerid_selected = "selected";
		$lastname_selected = "";
		$company_selected = "";
		$city_selected = "";
		$country_selected = "";
	} else if ($search_common === 'lname') {

		$domain_selected = "";
		$customerid_selected = "";
		$lastname_selected = "selected";
		$company_selected = "";
		$city_selected = "";
		$country_selected = "";

	} else if ($search_common === 'firm') {

		$domain_selected = "";
		$customerid_selected = "";
		$lastname_selected = "";
		$company_selected = "selected";
		$city_selected = "";
		$country_selected = "";

	} else if ($search_common === 'city') {

		$domain_selected = "";
		$customerid_selected = "";
		$lastname_selected = "";
		$company_selected = "";
		$city_selected = "selected";
		$country_selected = "";

	} else if ($search_common === 'country') {

		$domain_selected = "";
		$customerid_selected = "";
		$lastname_selected = "";
		$company_selected = "";
		$city_selected = "";
		$country_selected = "selected";

	} if ($search_status === 'all') {

		$all_selected = "selected";
		$ok_selected = "";
		$suspended_selected = "";

	} else if ($search_status === 'ok') {

		$all_selected = "";
		$ok_selected = "selected";
		$suspended_selected = "";

	} else if ($search_status === 'disabled') {

		$all_selected = "";
		$ok_selected = "";
		$suspended_selected = "selected";

	}

	if ($search_for === "n/a" || $search_for === '') {

			$tpl -> assign(
			                array(
									'SEARCH_FOR' => ""
								)
							);
	} else {
			$tpl -> assign(
			                array(
									'SEARCH_FOR' => stripslashes($search_for)
								)
							);
	}

	$tpl -> assign(
			                array(
									'M_DOMAIN_NAME' => tr('Domain name'),
									'M_CUSTOMER_ID' => tr('Customer ID'),
									'M_LAST_NAME' => tr('Last name'),
									'M_COMPANY' => tr('Company'),
									'M_CITY' => tr('City'),
									'M_COUNTRY' => tr('Country'),

									'M_ALL' => tr('All'),
									'M_OK' => tr('OK'),
									'M_SUSPENDED' => tr('Suspended'),
									'M_ERROR' => tr('Error'),

									// selected area

									'M_DOMAIN_NAME_SELECTED' => $domain_selected,
									'M_CUSTOMER_ID_SELECTED' => $customerid_selected,
									'M_LAST_NAME_SELECTED' => $lastname_selected,
									'M_COMPANY_SELECTED' => $company_selected,
									'M_CITY_SELECTED' => $city_selected,
									'M_COUNTRY_SELECTED' => $country_selected,

									'M_ALL_SELECTED' => $all_selected,
									'M_OK_SELECTED' => $ok_selected,
									'M_SUSPENDED_SELECTED' => $suspended_selected,
								  )
							  );

}

function gen_def_language(&$tpl, &$sql, &$user_def_language) {

	$matches = array();
    $query = <<<SQL_QUERY
        show tables
SQL_QUERY;

    $rs = exec_query($sql, $query, array());

	while (!$rs -> EOF) {
		$lang_table = $rs -> fields[0];

        if (preg_match("/lang_([A-Za-z0-9][A-Za-z0-9]+)/",$lang_table , $matches)) {

			$query = <<<SQL_QUERY
                select
                    msgstr
                from
                    $lang_table
                where
                    msgid = 'ispcp_language'
SQL_QUERY;

      $res = exec_query($sql, $query, array());

			if ($res -> RecordCount() == 0) {
				$language_name = tr('Unknown');
			} else {
				$language_name = $res->fields['msgstr'];
			}



            if ($matches[0] === $user_def_language) {

                $selected = 'selected';

            } else {

                $selected = '';

            }

            $tpl -> assign(
                            array(
                                    'LANG_VALUE' => $matches[0],
                                    'LANG_SELECTED' => $selected,
                                    'LANG_NAME' => $language_name
                                 )
                          );

            $tpl -> parse('DEF_LANGUAGE', '.def_language');
		}

        $rs -> MoveNext();
	}

}

function gen_domain_details(&$tpl, &$sql, &$domain_id)
{

	$tpl -> assign('USER_DETAILS', '');

	if (isset($_SESSION['details']) and $_SESSION['details'] == 'hide'){
		$tpl -> assign(
                            array(
                                    'TR_VIEW_DETAILS' => tr('view aliases'),
									'SHOW_DETAILS' => "show",
                                 )
                          );

		return;
	} else if (isset($_SESSION['details']) and $_SESSION['details'] === "show") {

	$tpl -> assign(
                            array(
                                    'TR_VIEW_DETAILS' => tr('hide aliases'),
									'SHOW_DETAILS' => "hide",
                                 )
                          );



	$alias_query = <<<SQL_QUERY
        select
            alias_id, alias_name
        from
            domain_aliasses
        where
            domain_id = ?
        order by
            alias_id desc
SQL_QUERY;
			$alias_rs = exec_query($sql, $alias_query, array($domain_id));

			if ($alias_rs -> RecordCount() == 0) {

				$tpl -> assign('USER_DETAILS', '');

			} else {

				while (!$alias_rs -> EOF) {

					$alias_name = $alias_rs -> fields['alias_name'];

					$tpl -> assign('ALIAS_DOMAIN', $alias_name);
					$tpl -> parse('USER_DETAILS', '.user_details');

					$alias_rs -> MoveNext();
				}

		 }

	} else {

		$tpl -> assign(
                  array(
                        'TR_VIEW_DETAILS' => tr('view aliases'),
                        'SHOW_DETAILS' => "show",
                        )
                  );

		return;
	}

}

function add_domain_extras(&$dmn_id, &$admin_id, &$sql)
{
	$query = <<<SQL_QUERY
        insert into domain_extras
            (dmn_id,
             admin_id,
             frontpage ,
             htaccess ,
             supportsystem,
             backup,
             errorpages,
             webmail,
             filemanager,
             installer)
        values
            (?,
             ?,
             '0',
             '1',
             '1',
             '1',
             '1',
             '1',
             '1',
             '0')
SQL_QUERY;

	$rs = exec_query($sql, $query, array($dmn_id, $admin_id));


}

function reseller_limits_check(&$sql, &$err_msg, $reseller_id, $hpid, $newprops="" )
{

 	if (empty($newprops)) {
	//this hosting plan exists

  		if (isset($_SESSION["ch_hpprops"])) {
    		$props = $_SESSION["ch_hpprops"];
  		} else {
    		$query = <<<SQL_QUERY
        		select
            		props
        		from
            		hosting_plans
        		where
            		id = ?
SQL_QUERY;

    		$res = exec_query($sql, $query, array($hpid));
    		$data = $res -> FetchRow();
    		$props = $data['props'];
  		}
  	} else {
  		//we want to check _before_ inserting

		$props = $newprops;

		}



  list($php_new, $cgi_new, $sub_new,
       $als_new, $mail_new, $ftp_new,
       $sql_db_new, $sql_user_new,
       $traff_new, $disk_new) = explode(";", $props);

    $query = <<<SQL_QUERY
        select
            *
        from
            reseller_props
        where
            reseller_id = ?
SQL_QUERY;

    $res = exec_query($sql, $query, array($reseller_id));
    $data = $res -> FetchRow();
    $dmn_current = $data['current_dmn_cnt'];
    $dmn_max = $data['max_dmn_cnt'];

    $sub_current = $data['current_sub_cnt'];
    $sub_max = $data['max_sub_cnt'];

    $als_current = $data['current_als_cnt'];
    $als_max = $data['max_als_cnt'];

    $mail_current = $data['current_mail_cnt'];
    $mail_max = $data['max_mail_cnt'];

    $ftp_current = $data['current_ftp_cnt'];
    $ftp_max = $data['max_ftp_cnt'];

    $sql_db_current = $data['current_sql_db_cnt'];
    $sql_db_max = $data['max_sql_db_cnt'];

    $sql_user_current = $data['current_sql_user_cnt'];
    $sql_user_max = $data['max_sql_user_cnt'];

    $traff_current = $data['current_traff_amnt'];
    $traff_max = $data['max_traff_amnt'];

    $disk_current = $data['current_disk_amnt'];
    $disk_max = $data['max_disk_amnt'];

    if ($dmn_max != 0) {
        if ($dmn_current + 1 > $dmn_max) {
            $err_msg = tr('You have reached your domain limit.<br>You can not add more domains! ');
            return;
        }
    }

    if ($sub_max != 0) {
        if ($sub_new != -1) {
            if ($sub_new == 0) {
                $err_msg = tr('You have subdomain limit!<br>You can not add user with unlimited subdomain number!');
                return;
            } else if ($sub_current + $sub_new > $sub_max) {
                $err_msg = tr('You are exceeding your subdomain limit!');
                return;
            }
        }
    }


    if ($als_max != 0) {
        if ($als_new != -1) {
            if ($als_new == 0) {
                $err_msg = tr('You have alias limit!<br>You can Not Add User With Unlimited Alias Number!');
                return;
            } else if ($als_current + $als_new > $als_max) {
                $err_msg = tr('You Are Exceeding Your Alias Limit!');
                return;
            }
        }
    }

    if ($mail_max != 0) {
        if ($mail_new == 0) {
            $err_msg = tr('You have mail account limit!<br>You can not add user with unlimited mail accunt number!');
            return;
        } else if ($mail_current + $mail_new > $mail_max) {
            $err_msg = tr('You are exceeding your mail account limit!');
            return;
        }
    }

    if ($ftp_max != 0) {
        if ($ftp_new == 0) {
            $err_msg = tr('You have FTP account limit!<br>You can not Add User With Unlimited FTP Accunt Number!');
            return;
        } else if ($ftp_current + $ftp_new > $ftp_max) {
            $err_msg = tr('You are exceeding your FTP account limit!');
            return;
        }
    }

    if ($sql_db_max != 0) {
        if ($sql_db_new != -1) {
            if ($sql_db_new == 0) {
                $err_msg = tr('You have SQL database limit!<br>You can not add user with unlimited SQL database number!');
                return;
            } else if ($sql_db_current + $sql_db_new > $sql_db_max) {
                $err_msg = tr('You are exceeding SQL database limit!');
                return;
            }
        }
    }

    if ($sql_user_max != 0) {
        if ($sql_user_new != -1) {
            if ($sql_user_new == 0) {
                $err_msg = tr('You have SQL user limit!<br>You can not add user with unlimited SQL users!');
                return;
            } else if ($sql_db_new == -1) {
                $err_msg = tr('You have disabled SQL databases for this user!<br>You can not have SQL users here!');
                return;
            } else if ($sql_user_current + $sql_user_new > $sql_user_max) {
                $err_msg = tr('You are exceeding SQL database limit!');
                return;
            }
        }
    }

    if ($traff_max != 0) {
        if ($traff_new == 0) {
            $err_msg = tr('You have traffic limit!<br>You can not add user with unlimited traffic number!');
            return;
        } else if ($traff_current + $traff_new > $traff_max) {
            $err_msg = tr('You are exceeding your traffic limit!');
            return;
        }
    }

    if ($disk_max != 0) {
        if ($disk_new == 0) {
            $err_msg = tr('You have disk limit!<br>You can not add user with unlimited disk number!');
            return;
        } else if ($disk_current + $disk_new > $disk_max) {
            $err_msg = tr('You are exceeding your disk limit!');
            return;
        }
    }

}

// Update reseller props
function au_update_reseller_props($reseller_id, $props)
{
  global $sql;

  list($php, $cgi, $sub,
       $als, $mail, $ftp,
       $sql_db, $sql_user,
       $traff, $disk) = explode(";", $props);

  $query = <<<SQL_QUERY
        select
            *
        from
            reseller_props
        where
            reseller_id = ?
SQL_QUERY;

    $res = exec_query($sql, $query, array($reseller_id));
    $data = $res -> FetchRow();

    $dmn_current = $data['current_dmn_cnt'];
    $dmn_max = $data['max_dmn_cnt'];

    $sub_current = $data['current_sub_cnt'];
    $sub_max = $data['max_sub_cnt'];

    $als_current = $data['current_als_cnt'];
    $als_max = $data['max_als_cnt'];

    $mail_current = $data['current_mail_cnt'];
    $mail_max = $data['max_mail_cnt'];

    $ftp_current = $data['current_ftp_cnt'];
    $ftp_max = $data['max_ftp_cnt'];

    $sql_db_current = $data['current_sql_db_cnt'];
    $sql_db_max = $data['max_sql_db_cnt'];

    $sql_user_current = $data['current_sql_user_cnt'];
    $sql_user_max = $data['max_sql_user_cnt'];

    $traff_current = $data['current_traff_amnt'];
    $traff_max = $data['max_traff_amnt'];

    $disk_current = $data['current_disk_amnt'];
    $disk_max = $data['max_disk_amnt'];

    $dmn = $dmn_current + 1;

    if ($sub != -1) {
        $sub += $sub_current;
    } else {
        $sub = $sub_current;
    }

    if ($als != -1) {
        $als += $als_current;
    } else {
        $als = $als_current;
    }

    $mail += $mail_current;

    $ftp += $ftp_current;

    if ($sql_db != -1) {
        $sql_db += $sql_db_current;
    } else {
        $sql_db = $sql_db_current;
    }

    if ($sql_user != -1) {
        $sql_user += $sql_user_current;
    } else {
        $sql_user = $sql_user_current;
    }

    $traff += $traff_current;
    $disk += $disk_current;

    $query = <<<SQL_QUERY
        update
            reseller_props
        set
            current_dmn_cnt = ?,
            current_sub_cnt = ?,
            current_als_cnt = ?,
            current_mail_cnt= ?,
            current_ftp_cnt = ?,
            current_sql_db_cnt = ?,
            current_sql_user_cnt = ?,
            current_traff_amnt = ?,
            current_disk_amnt = ?
        where
            reseller_id = ?

SQL_QUERY;

    $res = exec_query($sql, $query, array($dmn, $sub, $als, $mail, $ftp, $sql_db, $sql_user, $traff, $disk, $reseller_id));

} // End of au_update_reseller_props()


function send_order_emails($admin_id, $domain_name, $ufname, $ulname, $uemail, $order_id) {

	global $cfg;

	$data = get_order_email($admin_id);

	$from_name = $data['sender_name'];
	$from_email = $data['sender_email'];
	$subject = $data['subject'];
	$message = $data['message'];

	if ($from_name) {
	  	$from = $from_name . "<" . $from_email . ">";
	}
	else {
	  	$from = $from_email;
	}

	if ($ufname AND $ulname) {
	  	$to = "$ufname $ulname <$uemail>";
    	$name = "$ufname $ulname";
	}
	else {
   		if($ufname) {
			$name = $ufname;
		}
	   	else if($ulname) {
   			$name = $ulname;
   		}
		else {
	   		$name = $uname;
	   	}
	    $to = $uemail;
	}

	$subject = preg_replace("/\{DOMAIN\}/", $domain_name, $subject);
	$message = preg_replace("/\{DOMAIN\}/", $domain_name, $message);
	$message = preg_replace("/\{NAME\}/", $name, $message);

	$headers  = "From: $from\n";
	$headers .= "MIME-Version: 1.0\n" .
	        	"Content-Type: text/plain;\n" .
							"X-Mailer: ISPCP ".$cfg['Version']." Service Mailer";

	$mail_result = mail($to, $subject, $message, $headers);

	$mail_status = ($mail_result) ? 'OK' : 'NOT OK';

	// lets send mail to the reseller => new order

	$from = $to;
	$subject = "You have a new order";

	$message = <<<MSG

Dear $from_name,
you have a new order from $to

Please login into your ISPCP control panel for more details.

MSG;

	$mail_result = mail($from, $subject, $message, $headers);

}

?>