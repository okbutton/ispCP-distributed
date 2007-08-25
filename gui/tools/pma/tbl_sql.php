<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 *
 * @version $Id: tbl_sql.php 10343 2007-05-02 17:38:32Z lem9 $
 */

/**
 *
 */
require_once './libraries/common.inc.php';

/**
 * Runs common work
 */
require './libraries/tbl_common.php';
$url_query .= '&amp;goto=tbl_sql.php&amp;back=tbl_sql.php';

require_once './libraries/sql_query_form.lib.php';

$err_url   = 'tbl_sql.php' . $err_url;
$goto = 'tbl_sql.php';
$back = 'tbl_sql.php';

/**
 * Get table information
 */
require_once './libraries/tbl_info.inc.php';

/**
 * Displays top menu links
 */
require_once './libraries/tbl_links.inc.php';

/**
 * Query box, bookmark, insert data from textfile
 */
PMA_sqlQueryForm(true, false, isset($_REQUEST['delimiter']) ? $_REQUEST['delimiter'] : ';');

/**
 * Displays the footer
 */
require_once './libraries/footer.inc.php';
?>
