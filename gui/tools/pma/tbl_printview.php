<?php
/* $Id: tbl_printview.php,v 2.21.2.1 2006/04/12 15:23:31 cybot_tm Exp $ */

require_once('./libraries/common.lib.php');
require './libraries/tbl_properties_common.php';

/**
 * Gets the variables sent or posted to this script, then displays headers
 */
$print_view = TRUE;
if (!isset($selected_tbl)) {
    require_once('./libraries/header.inc.php');
}

// Check parameters

if (!isset($the_tables) || !is_array($the_tables)) {
    $the_tables = array();
}

/**
 * Gets the relations settings
 */
require_once('./libraries/relation.lib.php');
require_once('./libraries/transformations.lib.php');
require_once('./libraries/tbl_indexes.lib.php');

$cfgRelation  = PMA_getRelationsParam();


/**
 * Defines the url to return to in case of error in a sql statement
 */
if (isset($table)) {
    $err_url = 'tbl_properties.php?' . PMA_generate_common_url($db, $table);
} else {
    $err_url = 'db_details.php?' . PMA_generate_common_url($db);
}


/**
 * Selects the database
 */
PMA_DBI_select_db($db);


/**
 * Multi-tables printview thanks to Christophe Gesch� from the "MySQL Form
 * Generator for PHPMyAdmin" (http://sourceforge.net/projects/phpmysqlformgen/)
 */
if (isset($selected_tbl) && is_array($selected_tbl)) {
    $the_tables   = $selected_tbl;
} elseif (isset($table)) {
    $the_tables[] = $table;
}
$multi_tables     = (count($the_tables) > 1);

if ($multi_tables) {
    if (empty($GLOBALS['is_header_sent'])) {
        require_once('./libraries/header.inc.php');
    }
    $tbl_list     = '';
    foreach ($the_tables AS $key => $table) {
        $tbl_list .= (empty($tbl_list) ? '' : ', ')
                  . PMA_backquote(urldecode($table));
    }
    echo '<b>'.  $strShowTables . ':&nbsp;' . $tbl_list . '</b>' . "\n";
    echo '<hr />' . "\n";
} // end if

$tables_cnt = count($the_tables);
$counter    = 0;

foreach ($the_tables AS $key => $table) {
    $table = urldecode($table);
    if ($counter + 1 >= $tables_cnt) {
        $breakstyle = '';
    } else {
        $breakstyle = ' style="page-break-after: always;"';
    }
    $counter++;
    echo '<div' . $breakstyle . '>' . "\n";
    echo '<h1>' . $table . '</h1>' . "\n";

    /**
     * Gets table informations
     */
    $result       = PMA_DBI_query('SHOW TABLE STATUS LIKE \'' . PMA_sqlAddslashes($table, TRUE) . '\';');
    $showtable    = PMA_DBI_fetch_assoc($result);
    $num_rows     = (isset($showtable['Rows']) ? $showtable['Rows'] : 0);
    $show_comment = (isset($showtable['Comment']) ? $showtable['Comment'] : '');
    PMA_DBI_free_result($result);


    //  Gets table keys and store them in arrays
    $indexes      = array();
    $indexes_info = array();
    $indexes_data = array();
    $ret_keys = PMA_get_indexes($table, $err_url_0);

    PMA_extract_indexes($ret_keys, $indexes, $indexes_info, $indexes_data);

    /**
     * Gets fields properties
     */
    $result      = PMA_DBI_query('SHOW FIELDS FROM ' . PMA_backquote($table) . ';', null, PMA_DBI_QUERY_STORE);
    $fields_cnt  = PMA_DBI_num_rows($result);

    // Check if we can use Relations (Mike Beck)
    if (!empty($cfgRelation['relation'])) {
        // Find which tables are related with the current one and write it in
        // an array
        $res_rel = PMA_getForeigners($db, $table);

        if (count($res_rel) > 0) {
            $have_rel = TRUE;
        } else {
            $have_rel = FALSE;
        }
    } else {
           $have_rel = FALSE;
    } // end if


    /**
     * Displays the comments of the table if MySQL >= 3.23
     */
    if (!empty($show_comment)) {
        echo $strTableComments . ':&nbsp;' . $show_comment . '<br /><br />';
    }

    /**
     * Displays the table structure
     */
    ?>

<!-- TABLE INFORMATIONS -->
<table width="95%" bordercolorlight="black" border="border" style="border-collapse: collapse; background-color: white">
<tr>
    <th width="50"><?php echo $strField; ?></th>
    <th width="80"><?php echo $strType; ?></th>
    <!--<th width="50"><?php echo $strAttr; ?></th>-->
    <th width="40"><?php echo $strNull; ?></th>
    <th width="70"><?php echo $strDefault; ?></th>
    <!--<th width="50"><?php echo $strExtra; ?></th>-->
    <?php
    echo "\n";
    if ($have_rel) {
        echo '    <th>' . $strLinksTo . '</th>' . "\n";
    }
    if ($cfgRelation['commwork']) {
        echo '    <th>' . $strComments . '</th>' . "\n";
    }
    if ($cfgRelation['mimework']) {
        echo '    <th>MIME</th>' . "\n";
    }
    ?>
</tr>

    <?php
    $i = 0;
    while ($row = PMA_DBI_fetch_assoc($result)) {
        $bgcolor = ($i % 2) ?$cfg['BgcolorOne'] : $cfg['BgcolorTwo'];
        $i++;

        $type             = $row['Type'];
        // reformat mysql query output - staybyte - 9. June 2001
        // loic1: set or enum types: slashes single quotes inside options
        if (preg_match('@^(set|enum)\((.+)\)$@i', $type, $tmp)) {
            $tmp[2]       = substr(preg_replace('@([^,])\'\'@', '\\1\\\'', ',' . $tmp[2]), 1);
            $type         = $tmp[1] . '(' . str_replace(',', ', ', $tmp[2]) . ')';
            $type_nowrap  = '';

            $binary       = 0;
            $unsigned     = 0;
            $zerofill     = 0;
        } else {
            $type_nowrap  = ' nowrap="nowrap"';
            $type         = preg_replace('@BINARY@i', '', $type);
            $type         = preg_replace('@ZEROFILL@i', '', $type);
            $type         = preg_replace('@UNSIGNED@i', '', $type);
            if (empty($type)) {
                $type     = '&nbsp;';
            }

            $binary       = stristr($row['Type'], 'binary');
            $unsigned     = stristr($row['Type'], 'unsigned');
            $zerofill     = stristr($row['Type'], 'zerofill');
        }
        $strAttribute     = '&nbsp;';
        if ($binary) {
            $strAttribute = 'BINARY';
        }
        if ($unsigned) {
            $strAttribute = 'UNSIGNED';
        }
        if ($zerofill) {
            $strAttribute = 'UNSIGNED ZEROFILL';
        }
        if (!isset($row['Default'])) {
            if ($row['Null'] != ''  && $row['Null'] != 'NO') {
                $row['Default'] = '<i>NULL</i>';
            }
        } else {
            $row['Default'] = htmlspecialchars($row['Default']);
        }
        $field_name = htmlspecialchars($row['Field']);
        echo "\n";
        ?>
<tr>
    <td width="50" class="print" nowrap="nowrap">
    <?php
    if (isset($pk_array[$row['Field']])) {
        echo '    <u>' . $field_name . '</u>&nbsp;' . "\n";
    } else {
        echo '    ' . $field_name . '&nbsp;' . "\n";
    }
    ?>
    </td>
    <td width="80" class="print"<?php echo $type_nowrap; ?>><?php echo $type; ?><bdo dir="ltr"></bdo></td>
    <!--<td width="50" bgcolor="<?php echo $bgcolor; ?>" nowrap="nowrap"><?php echo $strAttribute; ?></td>-->
    <td width="40" class="print"><?php echo (($row['Null'] == '' || $row['Null'] == 'NO') ? $strNo : $strYes); ?>&nbsp;</td>
    <td width="70" class="print" nowrap="nowrap"><?php if (isset($row['Default'])) { echo $row['Default']; } ?>&nbsp;</td>
    <!--<td width="50" bgcolor="<?php echo $bgcolor; ?>" nowrap="nowrap"><?php echo $row['Extra']; ?>&nbsp;</td>-->
    <?php
    echo "\n";
    if ($have_rel) {
        echo '    <td class="print">';
        if (isset($res_rel[$field_name])) {
            echo htmlspecialchars($res_rel[$field_name]['foreign_table'] . ' -> ' . $res_rel[$field_name]['foreign_field'] );
        }
        echo '&nbsp;</td>' . "\n";
    }
    if ($cfgRelation['commwork'] || PMA_MYSQL_INT_VERSION >= 40100) {
        echo '    <td class="print">';
        $comments = PMA_getComments($db, $table);
        if (isset($comments[$field_name])) {
            echo htmlspecialchars($comments[$field_name]);
        }
        echo '&nbsp;</td>' . "\n";
    }
    if ($cfgRelation['mimework']) {
        $mime_map = PMA_getMIME($db, $table, true);

        echo '    <td class="print">';
        if (isset($mime_map[$field_name])) {
            echo htmlspecialchars(str_replace('_', '/', $mime_map[$field_name]['mimetype']));
        }
        echo '&nbsp;</td>' . "\n";
    }
    ?>
</tr>
        <?php
    } // end while
    PMA_DBI_free_result($result);

    echo "\n";
    ?>
</table>


    <?php

    if ( ! $tbl_is_view
      && ( $db != 'information_schema'
        || PMA_MYSQL_INT_VERSION < 50002 ) ) {
    
        /**
         * Displays indexes
         */
        $index_count = (isset($indexes))
                     ? count($indexes)
                     : 0;
        if ($index_count > 0) {
            echo "\n";
            ?>
    <br /><br />
    
    <!-- Indexes -->
    &nbsp;<big><?php echo $strIndexes . ':'; ?></big>
    <table bordercolorlight="black" border="border" style="border-collapse: collapse; background-color: white">
        <tr>
            <th><?php echo $strKeyname; ?></th>
            <th><?php echo $strType; ?></th>
            <th><?php echo $strCardinality; ?></th>
            <th colspan="2"><?php echo $strField; ?></th>
        </tr>
            <?php
            echo "\n";
            PMA_show_indexes($table, $indexes, $indexes_info, $indexes_data, true, true);
            echo "\n";
            ?>
    </table>
            <?php
            echo "\n";
        } // end display indexes
    
    
        /**
         * Displays Space usage and row statistics
         *
         * staybyte - 9 June 2001
         */
        if ($cfg['ShowStats']) {
            $nonisam     = FALSE;
            if (isset($showtable['Type']) && !preg_match('@ISAM|HEAP@i', $showtable['Type'])) {
                $nonisam = TRUE;
            }
            if ($nonisam == FALSE) {
                // Gets some sizes
                $mergetable     = FALSE;
                if (isset($showtable['Type']) && $showtable['Type'] == 'MRG_MyISAM') {
                    $mergetable = TRUE;
                }
                list($data_size, $data_unit)         = PMA_formatByteDown($showtable['Data_length']);
                if ($mergetable == FALSE) {
                    list($index_size, $index_unit)   = PMA_formatByteDown($showtable['Index_length']);
                }
                if (isset($showtable['Data_free']) && $showtable['Data_free'] > 0) {
                    list($free_size, $free_unit)     = PMA_formatByteDown($showtable['Data_free']);
                    list($effect_size, $effect_unit) = PMA_formatByteDown($showtable['Data_length'] + $showtable['Index_length'] - $showtable['Data_free']);
                } else {
                    unset($free_size);
                    unset($free_unit);
                    list($effect_size, $effect_unit) = PMA_formatByteDown($showtable['Data_length'] + $showtable['Index_length']);
                }
                list($tot_size, $tot_unit)           = PMA_formatByteDown($showtable['Data_length'] + $showtable['Index_length']);
                if ($num_rows > 0) {
                    list($avg_size, $avg_unit)       = PMA_formatByteDown(($showtable['Data_length'] + $showtable['Index_length']) / $showtable['Rows'], 6, 1);
                }
    
                // Displays them
                ?>
    <br /><br />
    
    <table border="0" cellspacing="0" cellpadding="0" class="noborder">
    <tr>
    
        <!-- Space usage -->
        <td class="print" valign="top">
            &nbsp;<big><?php echo $strSpaceUsage . ':'; ?></big>
            <table width="100%" bordercolorlight="black" border="border" style="border-collapse: collapse; background-color: white">
            <tr>
                <th><?php echo $strType; ?></th>
                <th colspan="2" align="center"><?php echo $strUsage; ?></th>
            </tr>
            <tr>
                <td class="print" style="padding-right: 10px"><?php echo $strData; ?></td>
                <td align="right" class="print" nowrap="nowrap"><?php echo $data_size; ?></td>
                <td class="print"><?php echo $data_unit; ?></td>
            </tr>
                <?php
                if (isset($index_size)) {
                    echo "\n";
                    ?>
            <tr>
                <td class="print" style="padding-right: 10px"><?php echo $strIndex; ?></td>
                <td align="right" class="print" nowrap="nowrap"><?php echo $index_size; ?></td>
                <td class="print"><?php echo $index_unit; ?></td>
            </tr>
                    <?php
                }
                if (isset($free_size)) {
                    echo "\n";
                    ?>
            <tr style="color: #bb0000">
                <td class="print" style="padding-right: 10px"><?php echo $strOverhead; ?></td>
                <td align="right" class="print" nowrap="nowrap"><?php echo $free_size; ?></td>
                <td class="print"><?php echo $free_unit; ?></td>
            </tr>
            <tr>
                <td class="print" style="padding-right: 10px"><?php echo $strEffective; ?></td>
                <td align="right" class="print" nowrap="nowrap"><?php echo $effect_size; ?></td>
                <td class="print"><?php echo $effect_unit; ?></td>
            </tr>
                    <?php
                }
                if (isset($tot_size) && $mergetable == FALSE) {
                    echo "\n";
                    ?>
            <tr>
                <td class="print" style="padding-right: 10px"><?php echo $strTotalUC; ?></td>
                <td align="right" class="print" nowrap="nowrap"><?php echo $tot_size; ?></td>
                <td class="print"><?php echo $tot_unit; ?></td>
            </tr>
                    <?php
                }
                echo "\n";
                ?>
            </table>
        </td>
    
        <td width="20" class="print">&nbsp;</td>
    
        <!-- Rows Statistic -->
        <td valign="top">
            &nbsp;<big><?php echo $strRowsStatistic . ':'; ?></big>
            <table width=100% bordercolorlight="black" border="border" style="border-collapse: collapse; background-color: white">
            <tr>
                <th><?php echo $strStatement; ?></th>
                <th align="center"><?php echo $strValue; ?></th>
            </tr>
                <?php
                $i = 0;
                if (isset($showtable['Row_format'])) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo ucfirst($strFormat); ?></td>
                <td align="<?php echo $cell_align_left; ?>" class="print" nowrap="nowrap">
                    <?php
                    echo '                ';
                    if ($showtable['Row_format'] == 'Fixed') {
                        echo $strFixed;
                    } elseif ($showtable['Row_format'] == 'Dynamic') {
                        echo $strDynamic;
                    } else {
                        echo $showtable['Row_format'];
                    }
                    echo "\n";
                    ?>
                </td>
            </tr>
                    <?php
                }
                if (isset($showtable['Rows'])) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                ?>
            <tr>
                <td class="print"><?php echo ucfirst($strRows); ?></td>
                <td align="right" class="print" nowrap="nowrap">
                    <?php echo number_format($showtable['Rows'], 0, $number_decimal_separator, $number_thousands_separator) . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                if (isset($showtable['Avg_row_length']) && $showtable['Avg_row_length'] > 0) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo ucfirst($strRowLength); ?>&nbsp;&oslash;</td>
                <td class="print" nowrap="nowrap">
                    <?php echo number_format($showtable['Avg_row_length'], 0, $number_decimal_separator, $number_thousands_separator) . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                if (isset($showtable['Data_length']) && $showtable['Rows'] > 0 && $mergetable == FALSE) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo ucfirst($strRowSize); ?>&nbsp;&oslash;</td>
                <td align="right" class="print" nowrap="nowrap">
                    <?php echo $avg_size . ' ' . $avg_unit . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                if (isset($showtable['Auto_increment'])) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo ucfirst($strNext); ?>&nbsp;Autoindex</td>
                <td align="right" class="print" nowrap="nowrap">
                    <?php echo number_format($showtable['Auto_increment'], 0, $number_decimal_separator, $number_thousands_separator) . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                echo "\n";
    
                if (isset($showtable['Create_time'])) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo $strStatCreateTime; ?></td>
                <td align="right" class="print" nowrap="nowrap">
                    <?php echo PMA_localisedDate(strtotime($showtable['Create_time'])) . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                echo "\n";
    
                if (isset($showtable['Update_time'])) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo $strStatUpdateTime; ?></td>
                <td align="right" class="print" nowrap="nowrap">
                    <?php echo PMA_localisedDate(strtotime($showtable['Update_time'])) . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                echo "\n";
    
                if (isset($showtable['Check_time'])) {
                    $bgcolor = ((++$i%2) ? $cfg['BgcolorTwo'] : $cfg['BgcolorOne']);
                    echo "\n";
                    ?>
            <tr>
                <td class="print"><?php echo $strStatCheckTime; ?></td>
                <td align="right" class="print" nowrap="nowrap">
                    <?php echo PMA_localisedDate(strtotime($showtable['Check_time'])) . "\n"; ?>
                </td>
            </tr>
                    <?php
                }
                echo "\n";
                ?>
            </table>
        </td>
    </tr>
    </table>
    
                <?php
            } // end if ($nonisam == FALSE)
        } // end if ($cfg['ShowStats'])
    }
    echo "\n";
    if ($multi_tables) {
        unset($ret_keys);
        unset($num_rows);
        unset($show_comment);
        echo '<hr />' . "\n";
    } // end if
    echo '</div>' . "\n";

} // end while



/**
 * Displays the footer
 */
echo "\n";
?>
<script type="text/javascript" language="javascript">
//<![CDATA[
function printPage()
{
    // Do print the page
    if (typeof(window.print) != 'undefined') {
        window.print();
    }
}
//]]>
</script>
<?php
echo '<br /><br />&nbsp;<input type="button" class="print_ignore" style="width: 100px; height: 25px" id="print" value="' . $strPrint . '" onclick="printPage()" />' . "\n";

require_once('./libraries/footer.inc.php');
?>
