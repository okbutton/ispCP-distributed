<?php
/* $Id: db_table_exists.lib.php 9202 2006-07-27 17:14:30Z lem9 $ */
// vim: expandtab sw=4 ts=4 sts=4:

/**
 * Ensure the database and the table exist (else move to the "parent" script)
 * and display headers
 */
if (empty($is_db)) {
    if (isset($db) && strlen($db)) {
        $is_db = @PMA_DBI_select_db($db);
    } else {
        $is_db = false;
    }

    if (! $is_db) {
        // not a valid db name -> back to the welcome page
        if (! defined('IS_TRANSFORMATION_WRAPPER')) {
            $url_params = array('reload' => 1);
            if (isset($message)) {
                $url_params['message'] = $message;
            }
            PMA_sendHeaderLocation(
                $cfg['PmaAbsoluteUri'] . 'main.php'
                    . PMA_generate_common_url($url_params, '&'));
        }
        exit;
    }
} // end if (ensures db exists)

if (empty($is_table) && !defined('PMA_SUBMIT_MULT')) {
    // Not a valid table name -> back to the db_details.php
    if (isset($table) && strlen($table)) {
        $_result = PMA_DBI_try_query(
            'SHOW TABLES LIKE \'' . PMA_sqlAddslashes($table, true) . '\';',
            null, PMA_DBI_QUERY_STORE);
        $is_table = @PMA_DBI_num_rows($_result);
        PMA_DBI_free_result($_result);
    } else {
        $is_table = false;
    }

    if (! $is_table) {
        if (! defined('IS_TRANSFORMATION_WRAPPER')) {
            if (isset($table) && strlen($table)) {
                // SHOW TABLES doesn't show temporary tables, so try select
                // (as it can happen just in case temporary table, it should be
                // fast):

                // @todo should this check really only happen if IS_TRANSFORMATION_WRAPPER?
                $_result = PMA_DBI_try_query(
                    'SELECT COUNT(*) FROM `' . PMA_sqlAddslashes($table, true) . '`;',
                    null, PMA_DBI_QUERY_STORE);
                $is_table = ($_result && @PMA_DBI_num_rows($_result));
                PMA_DBI_free_result($_result);
            }

            if (! $is_table) {
                $url_params = array('reload' => 1, 'db' => $db);
                if (isset($message)) {
                    $url_params['message'] = $message;
                }
                PMA_sendHeaderLocation(
                    $cfg['PmaAbsoluteUri'] . 'db_details.php'
                        . PMA_generate_common_url($url_params, '&'));
            }
        }

        if (! $is_table) {
            exit;
        }
    }
} // end if (ensures table exists)
?>
