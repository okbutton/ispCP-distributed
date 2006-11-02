<?php
/* $Id: db_details_export.php 7908 2005-11-24 09:12:17Z nijel $ */
// vim: expandtab sw=4 ts=4 sts=4:
/**
 * dumps a database
 *
 * @uses    libraries/db_details_common.inc.php
 * @uses    libraries/db_details_db_info.inc.php
 * @uses    libraries/display_export.lib.php
 * @uses    $tables     from libraries/db_details_db_info.inc.php
 */

/**
 * Gets some core libraries
 */
require_once('./libraries/common.lib.php');

$sub_part  = '_export';
require_once('./libraries/db_details_common.inc.php');
$url_query .= '&amp;goto=db_details_export.php';
require_once('./libraries/db_details_db_info.inc.php');

/**
 * Displays the form
 */
$export_page_title = $strViewDumpDB;

// exit if no tables in db found
if ( $num_tables < 1 ) {
    echo $strDatabaseNoTable;
    require('./libraries/footer.inc.php');
    exit;
} // end if

$multi_values = '<div align="center"><select name="table_select[]" size="6" multiple="multiple">';
$multi_values .= "\n";

foreach ( $tables as $each_table ) {
    if ( PMA_MYSQL_INT_VERSION >= 50000 && is_null($each_table['Engine']) ) {
        // Don't offer to export views yet.
        continue;
    }
    if ( ! empty( $selectall )
      || ( isset( $tmp_select ) 
           && false !== strpos( $tmp_select, '|' . $each_table['Name'] . '|') ) ) {
        $is_selected = ' selected="selected"';
    } else {
        $is_selected = '';
    }
    $table_html   = htmlspecialchars( $each_table['Name'] );
    $multi_values .= '                <option value="' . $table_html . '"' 
        . $is_selected . '>' . $table_html . '</option>' . "\n";
} // end for
$multi_values .= "\n";
$multi_values .= '</select></div>';

$checkall_url = 'db_details_export.php?'
              . PMA_generate_common_url( $db )
              . '&amp;goto=db_details_export.php';

$multi_values .= '<br />
        <a href="' . $checkall_url . '&amp;selectall=1" onclick="setSelectOptions(\'dump\', \'table_select[]\', true); return false;">' . $strSelectAll . '</a>
        /
        <a href="' . $checkall_url . '" onclick="setSelectOptions(\'dump\', \'table_select[]\', false); return false;">' . $strUnselectAll . '</a>';

$export_type = 'database';
require_once('./libraries/display_export.lib.php');

/**
 * Displays the footer
 */
require_once('./libraries/footer.inc.php');
?>
