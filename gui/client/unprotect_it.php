<?php
/**
 *  ispCP (OMEGA) - Virtual Hosting Control System | Omega Version
 *
 *  @copyright 	2001-2006 by moleSoftware GmbH
 *  @copyright 	2006-2008 by ispCP | http://isp-control.net
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


require '../include/ispcp-lib.php';

check_login(__FILE__);


/* do we have a proper cdir? */
if (!isset($_GET['cdir'])) {
	header( "Location: protected_areas.php" );
	die();
}
$domain_name = $_SESSION['user_logged'];
$cdir = $_GET['cdir'];

unlink($cfg['FTP_HOMEDIR'].'/'.$domain_name.$cdir.'.htaccess');

set_page_message( tr('Protected area was deleted successful!'));

header( "Location: protected_areas.php?cur_dir=$cdir" );
die();
?>