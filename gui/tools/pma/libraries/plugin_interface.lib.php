<?php
/* $Id: plugin_interface.lib.php,v 1.3 2006/01/17 17:02:30 cybot_tm Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:

/**
 * Generic plugin interface.
 */

/**
 * array PMA_getPlugins(string $plugins_dir, mixed $plugin_param)
 *
 * Reads all plugin information from directory $plugins_dir.
 *
 * @uses    ksort()
 * @uses    opendir()
 * @uses    readdir()
 * @uses    is_file()
 * @uses    eregi()
 * @param   string  $plugins_dir    directrory with plugins
 * @param   mixed   $plugin_param   parameter to plugin by which they can decide whether they can work
 * @return  array                   list of plugins
 */
function PMA_getPlugins($plugins_dir, $plugin_param)
{
    /* Scan for plugins */
    $plugin_list = array();
    if ($handle = @opendir($plugins_dir)) {
        $is_first = 0;
        while ($file = @readdir($handle)) {
            if (is_file($plugins_dir . $file) && eregi('\.php$', $file)) {
                include $plugins_dir . $file;
            }
        }
    }
    ksort($plugin_list);
    return $plugin_list;
}

/**
 * string PMA_getString(string $name)
 *
 * returns locale string for $name or $name if no locale is found
 *
 * @uses    $GLOBALS
 * @param   string  $name   for local string
 * @return  string          locale string for $name
 */
function PMA_getString($name)
{
    return isset($GLOBALS[$name]) ? $GLOBALS[$name] : $name;
}

/**
 * string PMA_pluginCheckboxCheck(string $section, string $opt)
 *
 * returns html input tag option 'checked' if plugin $opt should be set by config or request
 *
 * @uses    $_REQUEST
 * @uses    $GLOBALS['cfg']
 * @uses    $GLOBALS['timeout_passed']
 * @param   string  $section    name of config section in
 *                              $GLOBALS['cfg'][$section] for plugin
 * @param   string  $opt        name of option
 * @return  string              hmtl input tag option 'checked'
 */
function PMA_pluginCheckboxCheck($section, $opt)
{
    if ((isset($GLOBALS['timeout_passed']) && $GLOBALS['timeout_passed'] && isset($_REQUEST[$opt])) ||
        (isset($GLOBALS['cfg'][$section][$opt]) && $GLOBALS['cfg'][$section][$opt])) {
        return ' checked="checked"';
    }
    return '';
}

/**
 * string PMA_pluginGetDefault(string $section, string $opt)
 *
 * returns default value for option $opt
 *
 * @uses    htmlspecialchars()
 * @uses    $_REQUEST
 * @uses    $GLOBALS['cfg']
 * @uses    $GLOBALS['timeout_passed']
 * @param   string  $section    name of config section in
 *                              $GLOBALS['cfg'][$section] for plugin
 * @param   string  $opt        name of option
 * @return  string              default value for option $opt
 */
function PMA_pluginGetDefault($section, $opt)
{
    if (isset($GLOBALS['timeout_passed']) && $GLOBALS['timeout_passed'] && isset($_REQUEST[$opt])) {
        return htmlspecialchars($_REQUEST[$opt]);
    } elseif (isset($GLOBALS['cfg'][$section][$opt])) {
        return htmlspecialchars($GLOBALS['cfg'][$section][$opt]);
    }
    return '';
}

/**
 * string PMA_pluginIsActive(string $section, string $opt, string $val)
 *
 * returns html input tag option 'checked' if option $opt should be set by config or request
 *
 * @uses    $_REQUEST
 * @uses    $GLOBALS['cfg']
 * @uses    $GLOBALS['timeout_passed']
 * @param   string  $section    name of config section in
 *                              $GLOBALS['cfg'][$section] for plugin
 * @param   string  $opt        name of option
 * @param   string  $val        value of option to check against
 * @return  string              html input tag option 'checked'
 */
function PMA_pluginIsActive($section, $opt, $val)
{
    if ( ! empty($GLOBALS['timeout_passed']) && isset($_REQUEST[$opt])) {
        if ($_REQUEST[$opt] == $val) {
            return ' checked="checked"';
        }
    } elseif (isset($GLOBALS['cfg'][$section][$opt]) &&  $GLOBALS['cfg'][$section][$opt] == $val) {
        return ' checked="checked"';
    }
    return '';
}

/**
 * string PMA_pluginGetChoice(string $section, string $name, array &$list)
 *
 * returns html radio form element for plugin choice
 *
 * @uses    PMA_pluginIsActive()
 * @uses    PMA_getString()
 * @param   string  $section    name of config section in
 *                              $GLOBALS['cfg'][$section] for plugin
 * @param   string  $name       name of radio element
 * @param   array   &$list      array with plugin configuration defined in plugin file
 * @return  string              html input radio tag
 */
function PMA_pluginGetChoice($section, $name, &$list)
{
    $ret = '';
    foreach ($list as $plugin_name => $val) {
        $ret .= '<!-- ' . $plugin_name . ' -->' . "\n";
        $ret .= '<input type="radio" name="' . $name . '" value="' . $plugin_name . '"'
            . ' id="radio_plugin_' . $plugin_name . '"'
            . ' onclick="if(this.checked) { hide_them_all();'
                    .' document.getElementById(\'' . $plugin_name . '_options\').style.display = \'block\'; };'
                .' return true"'
            . PMA_pluginIsActive($section, $name, $plugin_name) . '/>' . "\n";
        $ret .= '<label for="radio_plugin_' . $plugin_name . '">'
            . PMA_getString($val['text']) . '</label>' . "\n";
        $ret .= '<br /><br />' . "\n";
    }
    return $ret;
}

/**
 * string PMA_pluginGetOneOption(string $section, string $plugin_name, string $id, array &$opt)
 *
 * returns single option in a table row
 *
 * @uses    PMA_getString()
 * @uses    PMA_pluginCheckboxCheck()
 * @uses    PMA_pluginGetDefault()
 * @param   string  $section        name of config section in
 *                                  $GLOBALS['cfg'][$section] for plugin
 * @param   string  $plugin_name    unique plugin name
 * @param   string  $id             option id
 * @param   array   &$opt           plugin option details
 * @return  string                  table row with option
 */
function PMA_pluginGetOneOption($section, $plugin_name, $id, &$opt)
{
    $ret = '';
    $ret .= '<tr>';
    if ($opt['type'] == 'bool') {
        $ret .= '<td colspan="2">';
        $ret .= '<input type="checkbox" name="' . $plugin_name . '_' . $opt['name'] . '"'
            . ' value="something" id="checkbox_' . $plugin_name . '_' . $opt['name'] . '"'
            . ' ' . PMA_pluginCheckboxCheck($section, $plugin_name . '_' . $opt['name']) .' />';
        $ret .= '<label for="checkbox_' . $plugin_name . '_' . $opt['name'] . '">'
            . PMA_getString($opt['text']) . '</label>';
        $ret .= '</td>';
    } elseif ($opt['type'] == 'text') {
        $ret .= '<td>';
        $ret .= '<label for="text_' . $plugin_name . '_' . $opt['name'] . '">'
            . PMA_getString($opt['text']) . '</label>';
        $ret .= '</td><td>';
        $ret .= '<input type="text" name="' . $plugin_name . '_' . $opt['name'] . '"'
            . ' value="' . PMA_pluginGetDefault($section, $plugin_name . '_' . $opt['name']) . '"'
            . ' id="text_' . $plugin_name . '_' . $opt['name'] . '"'
            . (isset($opt['size']) ? ' size="' . $opt['size'] . '"' : '' )
            . (isset($opt['len']) ? ' maxlength="' . $opt['len'] . '"' : '' ) . ' />';
        $ret .= '</td>';
    } else {
        /* This should be seen only by plugin writers, so I do not thing this
         * needs translation. */
        $ret .= '<td colspan="2">';
        $ret .= 'UNKNOWN OPTION IN IMPORT PLUGIN ' . $plugin_name . '!';
        $ret .= '</td>';
    }
    $ret .= '</tr>';
    return $ret;
}

/**
 * string PMA_pluginGetOptions(string $section, array &$list)
 *
 * return html fieldset with editable options for plugin
 *
 * @uses    PMA_getString()
 * @uses    PMA_pluginGetOneOption()
 * @param   string  $section    name of config section in $GLOBALS['cfg'][$section]
 * @param   array   &$list      array with plugin configuration defined in plugin file
 * @return  string              html fieldset with plugin options
 */
function PMA_pluginGetOptions($section, &$list)
{
    $ret = '';
    // Options for plugins that support them
    foreach ($list as $plugin_name => $val) {
        $ret .= '<fieldset id="' . $plugin_name . '_options" class="options">';
        $ret .= '<legend>' . PMA_getString($val['options_text']) . '</legend>';
        if (isset($val['options'])) {
            $ret .= '<table class="form">';
            $ret .= '<tbody>';
            foreach ($val['options'] as $id => $opt) {
                $ret .= PMA_pluginGetOneOption($section, $plugin_name, $id, $opt);
            }
            $ret .= '</tbody>';
            $ret .= '</table>';
        } else {
            $ret .= $GLOBALS['strNoOptions'];
        }
        $ret .= '</fieldset>';
    }
    return $ret;
}

function PMA_pluginGetJavascript(&$list) {
    $ret = '
    <script type="text/javascript" language="javascript">
    //<![CDATA[
    function hide_them_all() {
        ';
    foreach ($list as $plugin_name => $val) {
        $ret .= 'document.getElementById("' . $plugin_name . '_options").style.display = "none";' . "\n";
    }
    $ret .= '
    }

    function init_options() {
        hide_them_all();
        ';
    foreach ($list as $plugin_name => $val) {
        $ret .= 'if (document.getElementById("radio_plugin_' . $plugin_name . '").checked) {' . "\n";
        $ret .= 'document.getElementById("' . $plugin_name . '_options").style.display = "block";' . "\n";
        $ret .= ' } else ' . "\n";
    }
    $ret .= '
        {
            ;
        }
    }

    function match_file(fname) {
        farr = fname.toLowerCase().split(".");
        if (farr.length != 0) {
            len = farr.length
            if (farr[len - 1] == "gz" || farr[len - 1] == "bz2" || farr[len -1] == "zip") len--;
            switch (farr[len - 1]) {
                ';
    foreach ($list as $plugin_name => $val) {
        $ret .= 'case "' . $val['extension'] . '" :';
        $ret .= 'document.getElementById("radio_plugin_' . $plugin_name . '").checked = true;';
        $ret .= 'init_options();';
        $ret .= 'break;' . "\n";
    }
    $ret .='
            }
        }
    }
    //]]>
    </script>
    ';
    return $ret;
}
?>
