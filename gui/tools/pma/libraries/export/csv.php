<?php
/* $Id: csv.php,v 2.9 2006/01/17 17:03:02 cybot_tm Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:

/**
 * Set of functions used to build CSV dumps of tables
 */

/**
 * Outputs comment
 *
 * @param   string      Text of comment
 *
 * @return  bool        Whether it suceeded
 */
function PMA_exportComment($text) {
    return TRUE;
}

/**
 * Outputs export footer
 *
 * @return  bool        Whether it suceeded
 *
 * @access  public
 */
function PMA_exportFooter() {
    return TRUE;
}

/**
 * Outputs export header
 *
 * @return  bool        Whether it suceeded
 *
 * @access  public
 */
function PMA_exportHeader() {
    global $what;
    global $add_character;
    global $export_separator;
    global $enclosed;
    global $escaped;

    // Here we just prepare some values for export
    if ($what == 'excel') {
        $add_character      = "\015\012";
        $export_separator          = isset($GLOBALS['excel_edition']) && $GLOBALS['excel_edition'] == 'mac' ? ';' : ',';
        $enclosed           = '"';
        $escaped            = '"';
        if (isset($GLOBALS['showexcelnames']) && $GLOBALS['showexcelnames'] == 'yes') {
            $GLOBALS['showcsvnames'] = 'yes';
        }
    } else {
        if (empty($add_character)) {
            $add_character  = $GLOBALS['crlf'];
        } else {
            $add_character  = str_replace('\\r', "\015", $add_character);
            $add_character  = str_replace('\\n', "\012", $add_character);
            $add_character  = str_replace('\\t', "\011", $add_character);
        } // end if
        $export_separator          = str_replace('\\t', "\011", $export_separator);
    }
    return TRUE;
}

/**
 * Outputs database header
 *
 * @param   string      Database name
 *
 * @return  bool        Whether it suceeded
 *
 * @access  public
 */
function PMA_exportDBHeader($db) {
    return TRUE;
}

/**
 * Outputs database footer
 *
 * @param   string      Database name
 *
 * @return  bool        Whether it suceeded
 *
 * @access  public
 */
function PMA_exportDBFooter($db) {
    return TRUE;
}

/**
 * Outputs create database database
 *
 * @param   string      Database name
 *
 * @return  bool        Whether it suceeded
 *
 * @access  public
 */
function PMA_exportDBCreate($db) {
    return TRUE;
}

/**
 * Outputs the content of a table in CSV format
 *
 * @param   string      the database name
 * @param   string      the table name
 * @param   string      the end of line sequence
 * @param   string      the url to go back in case of error
 * @param   string      SQL query for obtaining data
 *
 * @return  bool        Whether it suceeded
 *
 * @access  public
 */
function PMA_exportData($db, $table, $crlf, $error_url, $sql_query) {
    global $what;
    global $add_character;
    global $export_separator;
    global $enclosed;
    global $escaped;

    // Gets the data from the database
    $result      = PMA_DBI_query($sql_query, null, PMA_DBI_QUERY_UNBUFFERED);
    $fields_cnt  = PMA_DBI_num_fields($result);

    // If required, get fields name at the first line
    if (isset($GLOBALS['showcsvnames']) && $GLOBALS['showcsvnames'] == 'yes') {
        $schema_insert = '';
        for ($i = 0; $i < $fields_cnt; $i++) {
            if ($enclosed == '') {
                $schema_insert .= stripslashes(PMA_DBI_field_name($result, $i));
            } else {
                $schema_insert .= $enclosed
                               . str_replace($enclosed, $escaped . $enclosed, stripslashes(PMA_DBI_field_name($result, $i)))
                               . $enclosed;
            }
            $schema_insert     .= $export_separator;
        } // end for
        $schema_insert  =trim(substr($schema_insert, 0, -1));
        if (!PMA_exportOutputHandler($schema_insert . $add_character)) {
            return FALSE;
        }
    } // end if

    // Format the data
    while ($row = PMA_DBI_fetch_row($result)) {
        $schema_insert = '';
        for ($j = 0; $j < $fields_cnt; $j++) {
            if (!isset($row[$j]) || is_null($row[$j])) {
                $schema_insert .= $GLOBALS[$what . '_replace_null'];
            } elseif ($row[$j] == '0' || $row[$j] != '') {
                // loic1 : always enclose fields
                if ($what == 'excel') {
                    $row[$j]       = ereg_replace("\015(\012)?", "\012", $row[$j]);
                }
                if ($enclosed == '') {
                    $schema_insert .= $row[$j];
                } else {
                    $schema_insert .= $enclosed
                                   . str_replace($enclosed, $escaped . $enclosed, $row[$j])
                                   . $enclosed;
                }
            } else {
                $schema_insert .= '';
            }
            if ($j < $fields_cnt-1) {
                $schema_insert .= $export_separator;
            }
        } // end for

        if (!PMA_exportOutputHandler($schema_insert . $add_character)) {
            return FALSE;
        }
    } // end while
    PMA_DBI_free_result($result);

    return TRUE;
} // end of the 'PMA_getTableCsv()' function
?>
