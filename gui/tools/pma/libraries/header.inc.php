<?php
/* $Id: header.inc.php,v 2.6 2006/01/17 17:02:30 cybot_tm Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:

require_once('./libraries/common.lib.php');

if (empty($GLOBALS['is_header_sent'])) {

    /**
     * Gets a core script and starts output buffering work
     */
    require_once('./libraries/common.lib.php');
    require_once('./libraries/ob.lib.php');
    if ($GLOBALS['cfg']['OBGzip']) {
        $GLOBALS['ob_mode'] = PMA_outBufferModeGet();
        if ($GLOBALS['ob_mode']) {
            PMA_outBufferPre($GLOBALS['ob_mode']);
        }
    }

    // garvin: For re-usability, moved http-headers and stylesheets
    // to a seperate file. It can now be included by header.inc.php,
    // querywindow.php.

    require_once('./libraries/header_http.inc.php');
    require_once('./libraries/header_meta_style.inc.php');

    // generate title
    $title     = '';
    if ($cfg['ShowHttpHostTitle']) {
        $title .= (empty($GLOBALS['cfg']['SetHttpHostTitle']) && isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $GLOBALS['cfg']['SetHttpHostTitle']) . ' / ';
    }
    if (!empty($GLOBALS['cfg']['Server']) && isset($GLOBALS['cfg']['Server']['host'])) {
        $title.=str_replace('\'', '\\\'', $GLOBALS['cfg']['Server']['host']);
    }
    if (isset($GLOBALS['db'])) {
        $title .= ' / ' . str_replace('\'', '\\\'', $GLOBALS['db']);
    }
    if (isset($GLOBALS['table'])) {
        $title .= (empty($title) ? '' : ' ') . ' / ' . str_replace('\'', '\\\'', $GLOBALS['table']);
    }
    $title .= ' | phpMyAdmin ' . PMA_VERSION;
    ?>
    <script type="text/javascript" language="javascript">
    <!--
    // Updates the title of the frameset if possible (ns4 does not allow this)
    if (typeof(parent.document) != 'undefined' && typeof(parent.document) != 'unknown'
        && typeof(parent.document.title) == 'string') {
        parent.document.title = '<?php echo PMA_sanitize($title); ?>';
    }
    <?php
    // Add some javascript instructions if required
    if (isset($js_to_run) && $js_to_run == 'functions.js') {
        echo "\n";
        ?>
    // js form validation stuff
    var errorMsg0   = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strFormEmpty']); ?>';
    var errorMsg1   = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strNotNumber']); ?>';
    var noDropDbMsg = '<?php echo((!$GLOBALS['cfg']['AllowUserDropDatabase']) ? str_replace('\'', '\\\'', $GLOBALS['strNoDropDatabases']) : ''); ?>';
    var confirmMsg  = '<?php echo(($GLOBALS['cfg']['Confirm']) ? str_replace('\'', '\\\'', $GLOBALS['strDoYouReally']) : ''); ?>';
    var confirmMsgDropDB  = '<?php echo(($GLOBALS['cfg']['Confirm']) ? str_replace('\'', '\\\'', $GLOBALS['strDropDatabaseStrongWarning']) : ''); ?>';
    //-->
    </script>
    <script src="./js/functions.js" type="text/javascript" language="javascript"></script>
        <?php
    } elseif (isset($js_to_run) && $js_to_run == 'user_password.js') {
        echo "\n";
        ?>
    // js form validation stuff
    var jsHostEmpty       = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strHostEmpty']); ?>';
    var jsUserEmpty       = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strUserEmpty']); ?>';
    var jsPasswordEmpty   = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strPasswordEmpty']); ?>';
    var jsPasswordNotSame = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strPasswordNotSame']); ?>';
    //-->
    </script>
    <script src="./js/user_password.js" type="text/javascript" language="javascript"></script>
        <?php
    } elseif (isset($js_to_run) && $js_to_run == 'server_privileges.js') {
        echo "\n";
        ?>
    // js form validation stuff
    var jsHostEmpty       = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strHostEmpty']); ?>';
    var jsUserEmpty       = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strUserEmpty']); ?>';
    var jsPasswordEmpty   = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strPasswordEmpty']); ?>';
    var jsPasswordNotSame = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strPasswordNotSame']); ?>';
    //-->
    </script>
    <script src="./js/server_privileges.js" type="text/javascript" language="javascript"></script>
    <script src="./js/functions.js" type="text/javascript" language="javascript"></script>
        <?php
    } elseif (isset($js_to_run) && $js_to_run == 'indexes.js') {
        echo "\n";
        ?>
    // js index validation stuff
    var errorMsg0   = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strFormEmpty']); ?>';
    var errorMsg1   = '<?php echo str_replace('\'', '\\\'', $GLOBALS['strNotNumber']); ?>';
    //-->
    </script>
    <script src="./js/indexes.js" type="text/javascript" language="javascript"></script>
        <?php
    } elseif (isset($js_to_run) && $js_to_run == 'tbl_change.js') {
        echo "\n";
        ?>
    //-->
    </script>
    <script src="./js/tbl_change.js" type="text/javascript" language="javascript"></script>
        <?php
    } else {
        echo "\n";
        ?>
    //-->
    </script>
        <?php
    }
    echo "\n";

    // Reloads the navigation frame via JavaScript if required
    PMA_reloadNavigation();
    ?>
        <script src="./js/tooltip.js" type="text/javascript"
            language="javascript"></script>
        <meta name="OBGZip" content="<?php echo ($cfg['OBGzip'] ? 'true' : 'false'); ?>" />
    </head>

    <body>
    <div id="TooltipContainer" onmouseover="holdTooltip();" onmouseout="swapTooltip('default');"></div>
    <?php

    // Include possible custom headers
    require_once('./libraries/header_custom.inc.php');

    if (!defined('PMA_DISPLAY_HEADING')) {
        define('PMA_DISPLAY_HEADING', 1);
    }

    /**
     * Display heading if needed. Design can be set in css file.
     */

    if (PMA_DISPLAY_HEADING) {
        $server_info = (!empty($GLOBALS['cfg']['Server']['verbose'])
                        ? $GLOBALS['cfg']['Server']['verbose']
                        : $GLOBALS['cfg']['Server']['host'] . (empty($GLOBALS['cfg']['Server']['port'])
                                                               ? ''
                                                               : ':' . $GLOBALS['cfg']['Server']['port']
                                                              )
                       );
        $item = '<a href="%1$s?%2$s" class="item">';
        if ( $GLOBALS['cfg']['NavigationBarIconic'] ) {
            $separator = '        <span class="separator"><img class="icon" src="' . $GLOBALS['pmaThemeImage'] . 'item_ltr.png" width="5" height="9" alt="-" /></span>' . "\n";
            $item .= '        <img class="icon" src="' . $GLOBALS['pmaThemeImage'] . '%5$s" width="16" height="16" alt="" /> ' . "\n";
        } else {
            $separator = '        <span class="separator"> - </span>' . "\n";
        }

        if ( $GLOBALS['cfg']['NavigationBarIconic'] !== true ) {
            $item .= '%4$s: ';
        }
        $item .= '%3$s</a>' . "\n";

        echo '<div id="serverinfo">' . "\n";
        printf( $item,
                $GLOBALS['cfg']['DefaultTabServer'],
                PMA_generate_common_url(),
                htmlspecialchars($server_info),
                $GLOBALS['strServer'],
                's_host.png' );

        if (isset($GLOBALS['db']) && strlen($GLOBALS['db'])) {

            echo $separator;
            printf( $item,
                    $GLOBALS['cfg']['DefaultTabDatabase'],
                    PMA_generate_common_url($GLOBALS['db']),
                    htmlspecialchars($GLOBALS['db']),
                    $GLOBALS['strDatabase'],
                    's_db.png' );

            if (isset($GLOBALS['table']) && strlen($GLOBALS['table'])) {
                require_once('./libraries/tbl_properties_table_info.inc.php');

                echo $separator;
                printf( $item,
                        $GLOBALS['cfg']['DefaultTabTable'],
                        PMA_generate_common_url($GLOBALS['db'], $GLOBALS['table']),
                        htmlspecialchars($GLOBALS['table']),
                        (isset($GLOBALS['tbl_is_view']) && $GLOBALS['tbl_is_view'] ? $GLOBALS['strView'] : $GLOBALS['strTable']),
                        (isset($GLOBALS['tbl_is_view']) && $GLOBALS['tbl_is_view'] ? 'b_views' : 's_tbl') . '.png' );

                /**
                 * Displays table comment
                 * @uses $show_comment from libraries/tbl_properties_table_info.inc.php
                 * @uses $GLOBALS['avoid_show_comment'] from tbl_relation.php
                 */
                if (!empty($show_comment) && !isset($GLOBALS['avoid_show_comment'])) {
                    if (strstr($show_comment, '; InnoDB free')) {
                        $show_comment = preg_replace('@; InnoDB free:.*?$@', '', $show_comment);
                    }
                    echo '<span class="table_comment" id="span_table_comment">'
                        .'&quot;' . htmlspecialchars($show_comment)
                        .'&quot;</span>' . "\n";
                } // end if
            } else {
                // no table selected, display database comment if present
                /**
                 * Settings for relations stuff
                 */
                require_once('./libraries/relation.lib.php');
                $cfgRelation = PMA_getRelationsParam();

                // Get additional information about tables for tooltip is done
                // in libraries/db_details_db_info.inc.php only once
                if ($cfgRelation['commwork']) {
                    $comment = PMA_getComments( $GLOBALS['db'] );

                    /**
                     * Displays table comment
                     */
                    if ( is_array( $comment ) ) {
                        echo '<span class="table_comment"'
                            .' id="span_table_comment">&quot;'
                            .htmlspecialchars(implode(' ', $comment))
                            .'&quot;</span>' . "\n";
                    } // end if
                }
            }
        }
        echo '</div>';

    }
    /**
     * Sets a variable to remember headers have been sent
     */
    $GLOBALS['is_header_sent'] = TRUE;
}
?>
