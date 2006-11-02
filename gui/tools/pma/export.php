<?php
/* $Id: export.php 9054 2006-05-15 22:01:55Z nijel $ */
// vim: expandtab sw=4 ts=4 sts=4:

/**
 * Get the variables sent or posted to this script and a core script
 */
require_once('./libraries/common.lib.php');
require_once('./libraries/zip.lib.php');
require_once('./libraries/plugin_interface.lib.php');

PMA_checkParameters(array('what', 'export_type'));

// Scan plugins
$export_list = PMA_getPlugins('./libraries/export/', array('export_type' => $export_type, 'single_table' => isset($single_table)));

// Backward compatbility
$type = $what;

// Check export type
if (!isset($export_list[$type])) {
    die('Bad type!');
}

// Does export require to be into file?
if (isset($export_list[$type]['force_file']) && ! isset($asfile)) {
    $message = $strExportMustBeFile;
    $GLOBALS['show_error_header'] = true;
    $js_to_run = 'functions.js';
    require_once('./libraries/header.inc.php');
    if ($export_type == 'server') {
        $active_page = 'server_export.php';
        require('./server_export.php');
    } elseif ($export_type == 'database') {
        $active_page = 'db_details_export.php';
        require('./db_details_export.php');
    } else {
        $active_page = 'tbl_properties_export.php';
        require('./tbl_properties_export.php');
    }
    exit();
}

// Generate error url and check for needed variables
if ($export_type == 'server') {
    $err_url = 'server_export.php?' . PMA_generate_common_url();
} elseif ($export_type == 'database' && isset($db) && strlen($db)) {
    $err_url = 'db_details_export.php?' . PMA_generate_common_url($db);
} elseif ($export_type == 'table' && isset($db) && strlen($db) && isset($table) && strlen($table)) {
    $err_url = 'tbl_properties_export.php?' . PMA_generate_common_url($db, $table);
} else {
    die('Bad parameters!');
}

// Get the functions specific to the export type
require('./libraries/export/' . PMA_securePath($type) . '.php');

/**
 * Increase time limit for script execution and initializes some variables
 */
@set_time_limit($cfg['ExecTimeLimit']);
if (!empty($cfg['MemoryLimit'])) {
    @ini_set('memory_limit', $cfg['MemoryLimit']);
}

// Start with empty buffer
$dump_buffer = '';
$dump_buffer_len = 0;

// We send fake headers to avoid browser timeout when buffering
$time_start = time();


/**
 * Output handler for all exports, if needed buffering, it stores data into
 * $dump_buffer, otherwise it prints thems out.
 *
 * @param   string  the insert statement
 *
 * @return  bool    Whether output suceeded
 */
function PMA_exportOutputHandler($line)
{
    global $time_start, $dump_buffer, $dump_buffer_len, $save_filename;

    // Kanji encoding convert feature
    if ($GLOBALS['output_kanji_conversion']) {
        $line = PMA_kanji_str_conv($line, $GLOBALS['knjenc'], isset($GLOBALS['xkana']) ? $GLOBALS['xkana'] : '');
    }
    // If we have to buffer data, we will perform everything at once at the end
    if ($GLOBALS['buffer_needed']) {

        $dump_buffer .= $line;
        if ($GLOBALS['onfly_compression']) {

            $dump_buffer_len += strlen($line);

            if ($dump_buffer_len > $GLOBALS['memory_limit']) {
                if ($GLOBALS['output_charset_conversion']) {
                    $dump_buffer = PMA_convert_string($GLOBALS['charset'], $GLOBALS['charset_of_file'], $dump_buffer);
                }
                // as bzipped
                if ($GLOBALS['compression'] == 'bzip'  && @function_exists('bzcompress')) {
                    $dump_buffer = bzcompress($dump_buffer);
                }
                // as a gzipped file
                elseif ($GLOBALS['compression'] == 'gzip' && @function_exists('gzencode')) {
                    // without the optional parameter level because it bug
                    $dump_buffer = gzencode($dump_buffer);
                }
                if ($GLOBALS['save_on_server']) {
                    $write_result = @fwrite($GLOBALS['file_handle'], $dump_buffer);
                    if (!$write_result || ($write_result != strlen($dump_buffer))) {
                        $GLOBALS['message'] = sprintf($GLOBALS['strNoSpace'], htmlspecialchars($save_filename));
                        $GLOBALS['show_error_header'] = TRUE;
                        return FALSE;
                    }
                } else {
                    echo $dump_buffer;
                }
                $dump_buffer = '';
                $dump_buffer_len = 0;
            }
        } else {
            $time_now = time();
            if ($time_start >= $time_now + 30) {
                $time_start = $time_now;
                header('X-pmaPing: Pong');
            } // end if
        }
    } else {
        if ($GLOBALS['asfile']) {
            if ($GLOBALS['save_on_server'] && strlen($line) > 0) {
                $write_result = @fwrite($GLOBALS['file_handle'], $line);
                if (!$write_result || ($write_result != strlen($line))) {
                    $GLOBALS['message'] = sprintf($GLOBALS['strNoSpace'], htmlspecialchars($save_filename));
                    $GLOBALS['show_error_header'] = TRUE;
                    return FALSE;
                }
                $time_now = time();
                if ($time_start >= $time_now + 30) {
                    $time_start = $time_now;
                    header('X-pmaPing: Pong');
                } // end if
            } else {
                // We export as file - output normally
                if ($GLOBALS['output_charset_conversion']) {
                    $line = PMA_convert_string($GLOBALS['charset'], $GLOBALS['charset_of_file'], $line);
                }
                echo $line;
            }
        } else {
            // We export as html - replace special chars
            echo htmlspecialchars($line);
        }
    }
    return TRUE;
} // end of the 'PMA_exportOutputHandler()' function

// Will we save dump on server?
$save_on_server = isset($cfg['SaveDir']) && !empty($cfg['SaveDir']) && !empty($onserver);

// Ensure compressed formats are associated with the download feature
if (empty($asfile)) {
    if ($save_on_server) {
        $asfile = TRUE;
    } elseif (isset($compression) && ($compression == 'zip' | $compression == 'gzip' | $compression == 'bzip')) {
        $asfile = TRUE;
    } else {
        $asfile = FALSE;
    }
} else {
    $asfile = TRUE;
}

// Defines the default <CR><LF> format. For SQL always use \n as MySQL wants this on all platforms.
if ($what == 'sql') {
    $crlf = "\n";
} else {
    $crlf = PMA_whichCrlf();
}

$output_kanji_conversion = function_exists('PMA_kanji_str_conv') && $type != 'xls';

// Do we need to convert charset?
$output_charset_conversion = $asfile &&
    $cfg['AllowAnywhereRecoding'] && $allow_recoding
    && isset($charset_of_file) && $charset_of_file != $charset
    && $type != 'xls';

// Set whether we will need buffering
$buffer_needed = isset($compression) && ($compression == 'zip' | $compression == 'gzip' | $compression == 'bzip');

// Use on fly compression?
$onfly_compression = $GLOBALS['cfg']['CompressOnFly'] && isset($compression) && ($compression == 'gzip' | $compression == 'bzip');
if ($onfly_compression) {
    $memory_limit = trim(@ini_get('memory_limit'));
    // 2 MB as default
    if (empty($memory_limit)) {
        $memory_limit = 2 * 1024 * 1024;
    }

    if (strtolower(substr($memory_limit, -1)) == 'm') {
        $memory_limit = (int)substr($memory_limit, 0, -1) * 1024 * 1024;
    } elseif (strtolower(substr($memory_limit, -1)) == 'k') {
        $memory_limit = (int)substr($memory_limit, 0, -1) * 1024;
    } elseif (strtolower(substr($memory_limit, -1)) == 'g') {
        $memory_limit = (int)substr($memory_limit, 0, -1) * 1024 * 1024 * 1024;
    } else {
        $memory_limit = (int)$memory_limit;
    }

    // Some of memory is needed for other thins and as treshold.
    // Nijel: During export I had allocated (see memory_get_usage function)
    //        approx 1.2MB so this comes from that.
    if ($memory_limit > 1500000) {
        $memory_limit -= 1500000;
    }

    // Some memory is needed for compression, assume 1/3
    $memory_limit /= 8;
}

// Generate filename and mime type if needed
if ($asfile) {
    $pma_uri_parts = parse_url($cfg['PmaAbsoluteUri']);
    if ($export_type == 'server') {
        if (isset($remember_template)) {
            setcookie('pma_server_filename_template', $filename_template, 0, $GLOBALS['cookie_path'], '', $GLOBALS['is_https']);
        }
        $filename = str_replace('__SERVER__', $GLOBALS['cfg']['Server']['host'], strftime($filename_template));
    } elseif ($export_type == 'database') {
        if (isset($remember_template)) {
            setcookie('pma_db_filename_template', $filename_template, 0, $GLOBALS['cookie_path'], '', $GLOBALS['is_https']);
        }
        $filename = str_replace('__DB__', $db, str_replace('__SERVER__', $GLOBALS['cfg']['Server']['host'], strftime($filename_template)));
    } else {
        if (isset($remember_template)) {
            setcookie('pma_table_filename_template', $filename_template, 0, $GLOBALS['cookie_path'], '', $GLOBALS['is_https']);
        }
        $filename = str_replace('__TABLE__', $table, str_replace('__DB__', $db, str_replace('__SERVER__', $GLOBALS['cfg']['Server']['host'], strftime($filename_template))));
    }

    // convert filename to iso-8859-1, it is safer
    if (!(isset($cfg['AllowAnywhereRecoding']) && $cfg['AllowAnywhereRecoding'] && $allow_recoding)) {
        $filename = PMA_convert_string($charset, 'iso-8859-1', $filename);
    } else {
        $filename = PMA_convert_string($convcharset, 'iso-8859-1', $filename);
    }

    // Grab basic dump extension and mime type
    $filename  .= '.' . $export_list[$type]['extension'];
    $mime_type  = $export_list[$type]['mime_type'];

    // If dump is going to be compressed, set correct encoding or mime_type and add
    // compression to extension
    $content_encoding = '';
    if (isset($compression) && $compression == 'bzip') {
        $filename  .= '.bz2';
        // browsers don't like this:
        //$content_encoding = 'x-bzip2';
        $mime_type = 'application/x-bzip2';
    } elseif (isset($compression) && $compression == 'gzip') {
        $filename  .= '.gz';
        // Needed to avoid recompression by server modules like mod_gzip.
        // It seems necessary to check about zlib.output_compression
        // to avoid compressing twice
        if (!@ini_get('zlib.output_compression')) {
            $content_encoding = 'x-gzip';
            $mime_type = 'application/x-gzip';
        }
    } elseif (isset($compression) && $compression == 'zip') {
        $filename  .= '.zip';
        $mime_type = 'application/zip';
    }
}

// Open file on server if needed
if ($save_on_server) {
    $save_filename = PMA_userDir($cfg['SaveDir']) . preg_replace('@[/\\\\]@', '_', $filename);
    unset($message);
    if (file_exists($save_filename) && empty($onserverover)) {
        $message = sprintf($strFileAlreadyExists, htmlspecialchars($save_filename));
        $GLOBALS['show_error_header'] = TRUE;
    } else {
        if (is_file($save_filename) && !is_writable($save_filename)) {
            $message = sprintf($strNoPermission, htmlspecialchars($save_filename));
            $GLOBALS['show_error_header'] = TRUE;
        } else {
            if (!$file_handle = @fopen($save_filename, 'w')) {
                $message = sprintf($strNoPermission, htmlspecialchars($save_filename));
                $GLOBALS['show_error_header'] = TRUE;
            }
        }
    }
    if (isset($message)) {
        $js_to_run = 'functions.js';
        require_once('./libraries/header.inc.php');
        if ($export_type == 'server') {
            $active_page = 'server_export.php';
            require('./server_export.php');
        } elseif ($export_type == 'database') {
            $active_page = 'db_details_export.php';
            require('./db_details_export.php');
        } else {
            $active_page = 'tbl_properties_export.php';
            require('./tbl_properties_export.php');
        }
        exit();
    }
}

/**
 * Send headers depending on whether the user chose to download a dump file
 * or not
 */
if (!$save_on_server) {
    if ($asfile ) {
        // Download
        if (!empty($content_encoding)) {
            header('Content-Encoding: ' . $content_encoding);
        }
        header('Content-Type: ' . $mime_type);
        header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        // lem9: Tested behavior of
        //       IE 5.50.4807.2300
        //       IE 6.0.2800.1106 (small glitch, asks twice when I click Open)
        //       IE 6.0.2900.2180
        //       Firefox 1.0.6
        // in http and https
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        if (PMA_USR_BROWSER_AGENT == 'IE') {
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Pragma: no-cache');
        }
    } else {
        // HTML
        $backup_cfgServer = $cfg['Server'];
        require_once('./libraries/header.inc.php');
        $cfg['Server'] = $backup_cfgServer;
        unset($backup_cfgServer);
        echo "\n" . '<div align="' . $cell_align_left . '">' . "\n";
        //echo '    <pre>' . "\n";
        echo '    <form name="nofunction">' . "\n"
           // remove auto-select for now: there is no way to select
           // only a part of the text; anyway, it should obey
           // $cfg['TextareaAutoSelect']
           //. '        <textarea name="sqldump" cols="50" rows="30" onclick="this.select();" id="textSQLDUMP" wrap="OFF">' . "\n";
           . '        <textarea name="sqldump" cols="50" rows="30" id="textSQLDUMP" wrap="OFF">' . "\n";
    } // end download
}

// Check if we have something to export
if ($export_type == 'database') {
    $tables     = PMA_DBI_get_tables($db);
    $num_tables = count($tables);
    if ($num_tables == 0) {
        $message = $strNoTablesFound;
        $js_to_run = 'functions.js';
        require_once('./libraries/header.inc.php');
        if ($export_type == 'server') {
            $active_page = 'server_export.php';
            require('./server_export.php');
        } elseif ($export_type == 'database') {
            $active_page = 'db_details_export.php';
            require('./db_details_export.php');
        } else {
            $active_page = 'tbl_properties_export.php';
            require('./tbl_properties_export.php');
        }
        exit();
    }
}

// Fake loop just to allow skip of remain of this code by break, I'd really
// need exceptions here :-)
do {

// Add possibly some comments to export
if (!PMA_exportHeader()) {
    break;
}

// Will we need relation & co. setup?
$do_relation = isset($GLOBALS[$what . '_relation']);
$do_comments = isset($GLOBALS[$what . '_comments']);
$do_mime     = isset($GLOBALS[$what . '_mime']);
if ($do_relation || $do_comments || $do_mime) {
    require_once('./libraries/relation.lib.php');
    $cfgRelation = PMA_getRelationsParam();
}
if ($do_mime) {
    require_once('./libraries/transformations.lib.php');
}

// Include dates in export?
$do_dates   = isset($GLOBALS[$what . '_dates']);

/**
 * Builds the dump
 */
// Gets the number of tables if a dump of a database has been required
if ($export_type == 'server') {
    /**
     * Gets the databases list - if it has not been built yet
     */
    if ($server > 0 && empty($dblist)) {
        PMA_availableDatabases();
    }

    if (isset($db_select)) {
        $tmp_select = implode($db_select, '|');
        $tmp_select = '|' . $tmp_select . '|';
    }
    // Walk over databases
    foreach ($dblist AS $current_db) {
        if ((isset($tmp_select) && strpos(' ' . $tmp_select, '|' . $current_db . '|'))
            || !isset($tmp_select)) {
            if (!PMA_exportDBHeader($current_db)) {
                break 2;
            }
            if (!PMA_exportDBCreate($current_db)) {
                break 2;
            }
            $tables = PMA_DBI_get_tables($current_db);
            $views = array();
            foreach ($tables as $table) {
                // if this is a view, collect it for later; views must be exported
                // after the tables
                if (PMA_Table::isView($current_db, $table)) {
                    $views[] = $table;
                    continue;
                }
                $local_query  = 'SELECT * FROM ' . PMA_backquote($current_db) . '.' . PMA_backquote($table);
                if (isset($GLOBALS[$what . '_structure'])) {
                    if (!PMA_exportStructure($current_db, $table, $crlf, $err_url, $do_relation, $do_comments, $do_mime, $do_dates)) {
                        break 3;
                    }
                }
                if (isset($GLOBALS[$what . '_data'])) {
                    if (!PMA_exportData($current_db, $table, $crlf, $err_url, $local_query)) {
                        break 3;
                    }
                }
            }
            foreach($views as $view) {
                // no data export for a view
                if (isset($GLOBALS[$what . '_structure'])) {
                    if (!PMA_exportStructure($current_db, $view, $crlf, $err_url, $do_relation, $do_comments, $do_mime, $do_dates)) {
                        break 3;
                    }
                }
            }
            if (!PMA_exportDBFooter($current_db)) {
                break 2;
            }
        }
    }
} elseif ($export_type == 'database') {
    if (!PMA_exportDBHeader($db)) {
        break;
    }

    if (isset($table_select)) {
        $tmp_select = implode($table_select, '|');
        $tmp_select = '|' . $tmp_select . '|';
    }
    $i = 0;
    $views = array();
    foreach ($tables as $table) {
        // if this is a view, collect it for later; views must be exported after
        // the tables
        if (PMA_Table::isView($db, $table)) {
            $views[] = $table;
            continue;
        }
        $local_query  = 'SELECT * FROM ' . PMA_backquote($db) . '.' . PMA_backquote($table);
        if ((isset($tmp_select) && strpos(' ' . $tmp_select, '|' . $table . '|'))
            || !isset($tmp_select)) {

            if (isset($GLOBALS[$what . '_structure'])) {
                if (!PMA_exportStructure($db, $table, $crlf, $err_url, $do_relation, $do_comments, $do_mime, $do_dates)) {
                    break 2;
                }
            }
            if (isset($GLOBALS[$what . '_data'])) {
                if (!PMA_exportData($db, $table, $crlf, $err_url, $local_query)) {
                    break 2;
                }
            }
        }
    }
    foreach ($views as $view) {
        // no data export for a view
        if (isset($GLOBALS[$what . '_structure'])) {
            if (!PMA_exportStructure($db, $view, $crlf, $err_url, $do_relation, $do_comments, $do_mime, $do_dates)) {
                break 2;
            }
        }
    }

    if (!PMA_exportDBFooter($db)) {
        break;
    }
} else {
    if (!PMA_exportDBHeader($db)) {
        break;
    }
    // We export just one table

    if ($limit_to > 0 && $limit_from >= 0) {
        $add_query  = ' LIMIT '
                    . (($limit_from > 0) ? $limit_from . ', ' : '')
                    . $limit_to;
    } else {
        $add_query  = '';
    }

    if (!empty($sql_query)) {
        // only preg_replace if needed
        if (!empty($add_query)) {
            // remove trailing semicolon before adding a LIMIT
            $sql_query = preg_replace('%;\s*$%', '', $sql_query);
        }
        $local_query = $sql_query . $add_query;
        PMA_DBI_select_db($db);
    } else {
        $local_query  = 'SELECT * FROM ' . PMA_backquote($db) . '.' . PMA_backquote($table) . $add_query;
    }

    if (isset($GLOBALS[$what . '_structure'])) {
        if (!PMA_exportStructure($db, $table, $crlf, $err_url, $do_relation, $do_comments, $do_mime, $do_dates)) {
            break;
        }
    }
    // I think we have to export data for a single view; for example PDF report
    //if (isset($GLOBALS[$what . '_data']) && ! PMA_table::isView($db, $table)) {
    if (isset($GLOBALS[$what . '_data'])) {
        if (!PMA_exportData($db, $table, $crlf, $err_url, $local_query)) {
            break;
        }
    }
    if (!PMA_exportDBFooter($db)) {
        break;
    }
}
if (!PMA_exportFooter()) {
    break;
}

} while (FALSE);
// End of fake loop

if ($save_on_server && isset($message)) {
    $js_to_run = 'functions.js';
    require_once('./libraries/header.inc.php');
    if ($export_type == 'server') {
        $active_page = 'server_export.php';
        require('./server_export.php');
    } elseif ($export_type == 'database') {
        $active_page = 'db_details_export.php';
        require('./db_details_export.php');
    } else {
        $active_page = 'tbl_properties_export.php';
        require('./tbl_properties_export.php');
    }
    exit();
}

/**
 * Send the dump as a file...
 */
if (!empty($asfile)) {
    // Convert the charset if required.
    if ($output_charset_conversion) {
        $dump_buffer = PMA_convert_string($GLOBALS['charset'], $GLOBALS['charset_of_file'], $dump_buffer);
    }

    // Do the compression
    // 1. as a gzipped file
    if (isset($compression) && $compression == 'zip') {
        if (@function_exists('gzcompress')) {
            $zipfile = new zipfile();
            $zipfile -> addFile($dump_buffer, substr($filename, 0, -4));
            $dump_buffer = $zipfile -> file();
        }
    }
    // 2. as a bzipped file
    elseif (isset($compression) && $compression == 'bzip') {
        if (@function_exists('bzcompress')) {
            $dump_buffer = bzcompress($dump_buffer);
            if ($dump_buffer === -8) {
                require_once('./libraries/header.inc.php');
                echo sprintf($strBzError, '<a href="http://bugs.php.net/bug.php?id=17300" target="_blank">17300</a>');
                require_once('./libraries/footer.inc.php');
            }
        }
    }
    // 3. as a gzipped file
    elseif (isset($compression) && $compression == 'gzip') {
        if (@function_exists('gzencode')) {
            // without the optional parameter level because it bug
            $dump_buffer = gzencode($dump_buffer);
        }
    }

    /* If ve saved on server, we have to close file now */
    if ($save_on_server) {
        $write_result = @fwrite($file_handle, $dump_buffer);
        fclose($file_handle);
        if (strlen($dump_buffer) !=0 && (!$write_result || ($write_result != strlen($dump_buffer)))) {
            $message = sprintf($strNoSpace, htmlspecialchars($save_filename));
        } else {
            $message = sprintf($strDumpSaved, htmlspecialchars($save_filename));
        }

        $js_to_run = 'functions.js';
        require_once('./libraries/header.inc.php');
        if ($export_type == 'server') {
            $active_page = 'server_export.php';
            require_once('./server_export.php');
        } elseif ($export_type == 'database') {
            $active_page = 'db_details_export.php';
            require_once('./db_details_export.php');
        } else {
            $active_page = 'tbl_properties_export.php';
            require_once('./tbl_properties_export.php');
        }
        exit();
    } else {
        echo $dump_buffer;
    }
}
/**
 * Displays the dump...
 */
else {
    /**
     * Close the html tags and add the footers in dump is displayed on screen
     */
    //echo '    </pre>' . "\n";
    echo '</textarea>' . "\n"
       . '    </form>' . "\n";
    echo '</div>' . "\n";
    echo "\n";
?>
<script type="text/javascript" language="javascript">
//<![CDATA[
    var bodyWidth=null; var bodyHeight=null;
    if (document.getElementById('textSQLDUMP')) {
        bodyWidth  = self.innerWidth;
        bodyHeight = self.innerHeight;
        if (!bodyWidth && !bodyHeight) {
            if (document.compatMode && document.compatMode == "BackCompat") {
                bodyWidth  = document.body.clientWidth;
                bodyHeight = document.body.clientHeight;
            } else if (document.compatMode && document.compatMode == "CSS1Compat") {
                bodyWidth  = document.documentElement.clientWidth;
                bodyHeight = document.documentElement.clientHeight;
            }
        }
        document.getElementById('textSQLDUMP').style.width=(bodyWidth-50) + 'px';
        document.getElementById('textSQLDUMP').style.height=(bodyHeight-100) + 'px';
    }
//]]>
</script>
<?php
    require_once('./libraries/footer.inc.php');
} // end if
?>
