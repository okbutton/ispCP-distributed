<?php
/* $Id: Config.class.php,v 1.21.2.7.2.13 2006/05/12 16:30:56 lem9 Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:

class PMA_Config
{
    /**
     * @var string  default config source
     */
    var $default_source = './libraries/config.default.php';

    /**
     * @var array   configuration settings
     */
    var $settings = array();

    /**
     * @var string  config source
     */
    var $source = '';

    /**
     * @var int     source modification time
     */
    var $source_mtime = 0;

    /**
     * @var boolean
     */
    var $error_config_file = false;

    /**
     * @var boolean
     */
    var $error_config_default_file = false;

    /**
     * @var boolean
     */
    var $error_pma_uri = false;

    /**
     * @var array
     */
    var $default_server = array();

    /**
     * @var boolean wether init is done or mot
     * set this to false to force some initial checks
     * like checking for required functions
     */
    var $done = false;

    /**
     * constructor
     *
     * @param   string  source to read config from
     */
    function __construct($source = null)
    {
        $this->settings = array();

        // functions need to refresh in case of config file changed goes in
        // PMA_Config::load()
        $this->load($source);

        // other settings, independant from config file, comes in
        $this->checkSystem();

        $this->checkIsHttps();
    }

    /**
     * sets system and application settings
     */
    function checkSystem()
    {
        $this->set('PMA_VERSION', '2.8.0.4');
        /**
         * @deprecated
         */
        $this->set('PMA_THEME_VERSION', 2);
        /**
         * @deprecated
         */
        $this->set('PMA_THEME_GENERATION', 2);

        $this->checkPhpVersion();
        $this->checkWebServerOs();
        $this->checkWebServer();
        $this->checkGd2();
        $this->checkClient();
        $this->checkUpload();
        $this->checkUploadSize();
        $this->checkOutputCompression();
    }

    /**
     * wether to use gzip output compression or not
     */
    function checkOutputCompression()
    {
        // If zlib output compression is set in the php configuration file, no
        // output buffering should be run
        if ( @ini_get('zlib.output_compression') ) {
            $this->set('OBGzip', false);
        }

        // disable output-buffering (if set to 'auto') for IE6, else enable it.
        if ( strtolower($this->get('OBGzip')) == 'auto' ) {
            if ( $this->get('PMA_USR_BROWSER_AGENT') == 'IE'
              && $this->get('PMA_USR_BROWSER_VER') >= 6
              && $this->get('PMA_USR_BROWSER_VER') < 7 ) {
                $this->set('OBGzip', false);
            } else {
                $this->set('OBGzip', true);
            }
        }
    }

    /**
     * Determines platform (OS), browser and version of the user
     * Based on a phpBuilder article:
     * @see http://www.phpbuilder.net/columns/tim20000821.php
     */
    function checkClient()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
        } elseif (!isset($HTTP_USER_AGENT)) {
            $HTTP_USER_AGENT = '';
        }

        // 1. Platform
        if (strstr($HTTP_USER_AGENT, 'Win')) {
            $this->set('PMA_USR_OS', 'Win');
        } elseif (strstr($HTTP_USER_AGENT, 'Mac')) {
            $this->set('PMA_USR_OS', 'Mac');
        } elseif (strstr($HTTP_USER_AGENT, 'Linux')) {
            $this->set('PMA_USR_OS', 'Linux');
        } elseif (strstr($HTTP_USER_AGENT, 'Unix')) {
            $this->set('PMA_USR_OS', 'Unix');
        } elseif (strstr($HTTP_USER_AGENT, 'OS/2')) {
            $this->set('PMA_USR_OS', 'OS/2');
        } else {
            $this->set('PMA_USR_OS', 'Other');
        }

        // 2. browser and version
        // (must check everything else before Mozilla)

        if (preg_match('@Opera(/| )([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[2]);
            $this->set('PMA_USR_BROWSER_AGENT', 'OPERA');
        } elseif (preg_match('@MSIE ([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'IE');
        } elseif (preg_match('@OmniWeb/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'OMNIWEB');
        //} elseif (ereg('Konqueror/([0-9].[0-9]{1,2})', $HTTP_USER_AGENT, $log_version)) {
        // Konqueror 2.2.2 says Konqueror/2.2.2
        // Konqueror 3.0.3 says Konqueror/3
        } elseif (preg_match('@(Konqueror/)(.*)(;)@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[2]);
            $this->set('PMA_USR_BROWSER_AGENT', 'KONQUEROR');
        } elseif (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)
                   && preg_match('@Safari/([0-9]*)@', $HTTP_USER_AGENT, $log_version2)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1] . '.' . $log_version2[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'SAFARI');
        } elseif (preg_match('@Mozilla/([0-9].[0-9]{1,2})@', $HTTP_USER_AGENT, $log_version)) {
            $this->set('PMA_USR_BROWSER_VER', $log_version[1]);
            $this->set('PMA_USR_BROWSER_AGENT', 'MOZILLA');
        } else {
            $this->set('PMA_USR_BROWSER_VER', 0);
            $this->set('PMA_USR_BROWSER_AGENT', 'OTHER');
        }
    }

    /**
     * Whether GD2 is present
     */
    function checkGd2()
    {
        if ( $this->get('GD2Available') == 'yes' ) {
            $this->set('PMA_IS_GD2', 1);
        } elseif ( $this->get('GD2Available') == 'no' ) {
            $this->set('PMA_IS_GD2', 0);
        } else {
            if (!@extension_loaded('gd')) {
                PMA_dl('gd');
            }
            if (!@function_exists('imagecreatetruecolor')) {
                $this->set('PMA_IS_GD2', 0);
            } else {
                if (@function_exists('gd_info')) {
                    $gd_nfo = gd_info();
                    if (strstr($gd_nfo["GD Version"], '2.')) {
                        $this->set('PMA_IS_GD2', 1);
                    } else {
                        $this->set('PMA_IS_GD2', 0);
                    }
                } else {
                    /* We must do hard way... */
                    ob_start();
                    phpinfo(INFO_MODULES); /* Only modules */
                    $a = strip_tags(ob_get_contents());
                    ob_end_clean();
                    /* Get GD version string from phpinfo output */
                    if (preg_match('@GD Version[[:space:]]*\(.*\)@', $a, $v)) {
                        if (strstr($v, '2.')) {
                            $this->set('PMA_IS_GD2', 1);
                        } else {
                            $this->set('PMA_IS_GD2', 0);
                        }
                    } else {
                        $this->set('PMA_IS_GD2', 0);
                    }
                }
            }
        }
    }

    /**
     * Whether the Web server php is running on is IIS
     */
    function checkWebServer()
    {
        if ( isset( $_SERVER['SERVER_SOFTWARE'] )
          && stristr($_SERVER['SERVER_SOFTWARE'], 'Microsoft/IIS') ) {
            $this->set('PMA_IS_IIS', 1);
        } else {
            $this->set('PMA_IS_IIS', 0);
        }
    }

    /**
     * Whether the os php is running on is windows or not
     */
    function checkWebServerOs()
    {
        if ( defined('PHP_OS') && stristr(PHP_OS, 'win') ) {
            $this->set('PMA_IS_WINDOWS', 1);
        } else {
            $this->set('PMA_IS_WINDOWS', 0);
        }
    }

    /**
     * detects PHP version
     */
    function checkPhpVersion()
    {
        $match = array();
        if ( ! preg_match('@([0-9]{1,2}).([0-9]{1,2}).([0-9]{1,2})@',
                phpversion(), $match) ) {
            $result = preg_match('@([0-9]{1,2}).([0-9]{1,2})@',
                phpversion(), $match);
        }
        if ( isset( $match ) && ! empty( $match[1] ) ) {
            if ( ! isset( $match[2] ) ) {
                $match[2] = 0;
            }
            if ( ! isset( $match[3] ) ) {
                $match[3] = 0;
            }
            $this->set('PMA_PHP_INT_VERSION',
                (int) sprintf('%d%02d%02d', $match[1], $match[2], $match[3]));
        } else {
            $this->set('PMA_PHP_INT_VERSION', 0);
        }
        $this->set('PMA_PHP_STR_VERSION', phpversion());
    }

    /**
     * re-init object after loadiong from session file
     * checks config file for changes and relaods if neccessary
     */
    function __wakeup()
    {
        if (file_exists($this->getSource()) && $this->source_mtime !== filemtime($this->getSource())
          || $this->error_config_file || $this->error_config_default_file ) {
            $this->settings = array();
            $this->load($this->getSource());
            $this->checkSystem();
        }

        // check for https needs to be done everytime,
        // as https and http uses same session so this info can not be stored
        // in session
        $this->checkIsHttps();

        $this->checkCollationConnection();
    }

    /**
     * loads default values from default source
     *
     * @uses    file_exists()
     * @uses    $this->default_source
     * @uses    $this->error_config_default_file
     * @uses    $this->settings
     * @return  boolean     success
     */
    function loadDefaults()
    {
        $cfg = array();
        if ( ! file_exists($this->default_source) ) {
            $this->error_config_default_file = true;
            return false;
        }
        include $this->default_source;

        $this->default_server = $cfg['Servers'][1];
        unset( $cfg['Servers'] );

        $this->settings = PMA_array_merge_recursive($this->settings, $cfg);

        $this->error_config_default_file = false;

        return true;
    }

    /**
     * loads configuration from $source, usally the config file
     * should be called on object creation and from __wakeup if config file
     * has changed
     *
     * @param   string $source  config file
     */
    function load($source = null)
    {
        $this->loadDefaults();

        if ( null !== $source ) {
            $this->setSource($source);
        }

        if ( ! $this->checkConfigSource() ) {
            return false;
        }

        $cfg = array();

        /**
         * Parses the configuration file
         */
        $old_error_reporting = error_reporting(0);
        if ( function_exists('file_get_contents') ) {
            $eval_result =
                eval( '?>' . file_get_contents($this->getSource()) );
        } else {
            $eval_result =
                eval( '?>' . implode("\n", file($this->getSource())) );
        }
        error_reporting($old_error_reporting);

        if ( $eval_result === false ) {
            $this->error_config_file = true;
        } else  {
            $this->error_config_file = false;
            $this->source_mtime = filemtime($this->getSource());
        }

        /**
         * @TODO check validity of $_COOKIE['pma_collation_connection']
         */
        if ( ! empty( $_COOKIE['pma_collation_connection'] ) ) {
            $this->set('collation_connection',
                strip_tags($_COOKIE['pma_collation_connection']) );
        } else {
            $this->set('collation_connection',
                $this->get('DefaultConnectionCollation') );
        }

        $this->checkCollationConnection();
        //$this->checkPmaAbsoluteUri();
        $this->settings = PMA_array_merge_recursive($this->settings, $cfg);
        return true;
    }

    /**
     * set source
     * @param   string  $source
     */
    function setSource($source)
    {
        $this->source = trim($source);
    }

    /**
     * checks if the config folder still exists and terminates app if true
     */
    function checkConfigFolder()
    {
        // Refuse to work while there still might be some world writable dir:
        if (is_dir('./config')) {
            die('Remove "./config" directory before using phpMyAdmin!');
        }
    }

    /**
     * check config source
     *
     * @return  boolean wether source is valid or not
     */
    function checkConfigSource()
    {
        if ( ! file_exists($this->getSource()) ) {
            // do not trigger error here
            // https://sf.net/tracker/?func=detail&aid=1370269&group_id=23067&atid=377408
            /*
            trigger_error(
                'phpMyAdmin-ERROR: unkown configuration source: ' . $source,
                E_USER_WARNING);
            */
            $this->source_mtime = 0;
            return false;
        }

        if ( ! is_readable($this->getSource()) ) {
            $this->source_mtime = 0;
            die('Existing configuration file (' . $this->getSource() . ') is not readable.');
        }

        // Check for permissions (on platforms that support it):
        $perms = @fileperms($this->getSource());
        if (!($perms === false) && ($perms & 2)) {
            // This check is normally done after loading configuration
            $this->checkWebServerOs();
            if ($this->get('PMA_IS_WINDOWS') == 0) {
                $this->source_mtime = 0;
                die('Wrong permissions on configuration file, should not be world writable!');
            }
        }

        return true;
    }

    /**
     * returns specific config setting
     * @param   string  $setting
     * @return  mixed   value
     */
    function get($setting)
    {
        if ( isset( $this->settings[$setting] ) ) {
            return $this->settings[$setting];
        }
        return null;
    }

    /**
     * sets configuration variable
     *
     * @uses    $this->settings
     * @param   string  $setting    configuration option
     * @param   string  $value      new value for configuration option
     */
    function set($setting, $value)
    {
        $this->settings[$setting] = $value;
    }

    /**
     * returns source for current config
     * @return  string  config source
     */
    function getSource()
    {
        return $this->source;
    }

    /**
     * old PHP 4 style constructor
     *
     * @deprecated
     */
    function PMA_Config($source = null)
    {
        $this->__construct($source);
    }

    /**
     * $cfg['PmaAbsoluteUri'] is a required directive else cookies won't be
     * set properly and, depending on browsers, inserting or updating a
     * record might fail
     */
    function checkPmaAbsoluteUri()
    {
        // Setup a default value to let the people and lazy syadmins work anyway,
        // they'll get an error if the autodetect code doesn't work
        $pma_absolute_uri = $this->get('PmaAbsoluteUri');
        if ( strlen($pma_absolute_uri) < 1 ) {
            $url = array();

            // At first we try to parse REQUEST_URI, it might contain full URI
            if ( ! empty($_SERVER['REQUEST_URI'] ) ) {
                $url = parse_url($_SERVER['REQUEST_URI']);
            }

            // If we don't have scheme, we didn't have full URL so we need to
            // dig deeper
            if ( empty( $url['scheme'] ) ) {
                // Scheme
                if ( ! empty( $_SERVER['HTTP_SCHEME'] ) ) {
                    $url['scheme'] = $_SERVER['HTTP_SCHEME'];
                } else {
                    $url['scheme'] =
                        !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off'
                            ? 'https'
                            : 'http';
                }

                // Host and port
                if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
                    if ( strpos($_SERVER['HTTP_HOST'], ':') !== false ) {
                        list( $url['host'], $url['port'] ) =
                            explode(':', $_SERVER['HTTP_HOST']);
                    } else {
                        $url['host'] = $_SERVER['HTTP_HOST'];
                    }
                } elseif ( ! empty( $_SERVER['SERVER_NAME'] ) ) {
                    $url['host'] = $_SERVER['SERVER_NAME'];
                } else {
                    $this->error_pma_uri = true;
                    return false;
                }

                // If we didn't set port yet...
                if ( empty( $url['port'] ) && ! empty( $_SERVER['SERVER_PORT'] ) ) {
                    $url['port'] = $_SERVER['SERVER_PORT'];
                }

                // And finally the path could be already set from REQUEST_URI
                if ( empty( $url['path'] ) ) {
                    if (!empty($_SERVER['PATH_INFO'])) {
                        $path = parse_url($_SERVER['PATH_INFO']);
                    } else {
                        // PHP_SELF in CGI often points to cgi executable, so use it
                        // as last choice
                        $path = parse_url($_SERVER['PHP_SELF']);
                    }
                    $url['path'] = $path['path'];
                }
            }

            // Make url from parts we have
            $pma_absolute_uri = $url['scheme'] . '://';
            // Was there user information?
            if (!empty($url['user'])) {
                $pma_absolute_uri .= $url['user'];
                if (!empty($url['pass'])) {
                    $pma_absolute_uri .= ':' . $url['pass'];
                }
                $pma_absolute_uri .= '@';
            }
            // Add hostname
            $pma_absolute_uri .= $url['host'];
            // Add port, if it not the default one
            if ( ! empty( $url['port'] )
              && ( ( $url['scheme'] == 'http' && $url['port'] != 80 )
                || ( $url['scheme'] == 'https' && $url['port'] != 443 ) ) ) {
                $pma_absolute_uri .= ':' . $url['port'];
            }
            // And finally path, without script name, the 'a' is there not to
            // strip our directory, when path is only /pmadir/ without filename.
            // Backslashes returned by Windows have to be changed.
            // Only replace backslashes by forward slashes if on Windows,
            // as the backslash could be valid on a non-Windows system.
            if ($this->get('PMA_IS_WINDOWS') == 1) {
                $path = str_replace("\\", "/", dirname($url['path'] . 'a'));
            } else {
                $path = dirname($url['path'] . 'a');
            }

            // To work correctly within transformations overview:
            if (defined('PMA_PATH_TO_BASEDIR') && PMA_PATH_TO_BASEDIR == '../../') {
                if ($this->get('PMA_IS_WINDOWS') == 1) {
                    $path = str_replace("\\", "/", dirname(dirname($path)));
                } else {
                    $path = dirname(dirname($path));
                }
            }
            // in vhost situations, there could be already an ending slash
            if (substr($path, -1) != '/') {
                $path .= '/';
            }
            $pma_absolute_uri .= $path;

            // We used to display a warning if PmaAbsoluteUri wasn't set, but now
            // the autodetect code works well enough that we don't display the
            // warning at all. The user can still set PmaAbsoluteUri manually.
            // See
            // http://sf.net/tracker/?func=detail&aid=1257134&group_id=23067&atid=377411

        } else {
            // The URI is specified, however users do often specify this
            // wrongly, so we try to fix this.

            // Adds a trailing slash et the end of the phpMyAdmin uri if it
            // does not exist.
            if (substr($pma_absolute_uri, -1) != '/') {
                $pma_absolute_uri .= '/';
            }

            // If URI doesn't start with http:// or https://, we will add
            // this.
            if ( substr($pma_absolute_uri, 0, 7) != 'http://'
              && substr($pma_absolute_uri, 0, 8) != 'https://' ) {
                $pma_absolute_uri =
                    (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off'
                        ? 'https'
                        : 'http')
                    . ':' . (substr($pma_absolute_uri, 0, 2) == '//' ? '' : '//')
                    . $pma_absolute_uri;
            }
        }

        $this->set('PmaAbsoluteUri', $pma_absolute_uri);
    }

    /**
     * check selected collation_connection
     * @TODO check validity of $_REQUEST['collation_connection']
     */
    function checkCollationConnection()
    {
        // (could be improved by executing it after the MySQL connection only if
        //  PMA_MYSQL_INT_VERSION >= 40100 )
        if ( ! empty( $_REQUEST['collation_connection'] ) ) {
            $this->set('collation_connection',
                strip_tags($_REQUEST['collation_connection']) );
        }
    }

    /**
     * checks if upload is enabled
     *
     */
    function checkUpload()
    {
        $this->set('enable_upload', true);
        if ( strtolower(@ini_get('file_uploads')) == 'off'
          || @ini_get('file_uploads') == 0 ) {
            $this->set('enable_upload', false);
        }
    }

    /**
     * Maximum upload size as limited by PHP
     * Used with permission from Moodle (http://moodle.org) by Martin Dougiamas
     *
     * this section generates $max_upload_size in bytes
     */
    function checkUploadSize()
    {
        if ( ! $filesize = ini_get('upload_max_filesize') ) {
            $filesize = "5M";
        }

        if ( $postsize = ini_get('post_max_size') ) {
            $this->set('max_upload_size',
                min(get_real_size($filesize), get_real_size($postsize)) );
        } else {
            $this->set('max_upload_size', get_real_size($filesize));
        }
    }

    /**
     * check for https
     */
    function checkIsHttps()
    {
        $this->set('is_https', PMA_Config::isHttps());
    }

    /**
     * @static
     */
    function isHttps()
    {
        $is_https = false;

        $url = array();

        // At first we try to parse REQUEST_URI, it might contain full URI
        if ( ! empty($_SERVER['REQUEST_URI'] ) ) {
            $url = parse_url($_SERVER['REQUEST_URI']);
        }

        // If we don't have scheme, we didn't have full URL so we need to
        // dig deeper
        if ( empty( $url['scheme'] ) ) {
            // Scheme
            if ( ! empty( $_SERVER['HTTP_SCHEME'] ) ) {
                $url['scheme'] = $_SERVER['HTTP_SCHEME'];
            } else {
                $url['scheme'] =
                    !empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off'
                        ? 'https'
                        : 'http';
            }
        }

        if ( isset( $url['scheme'] )
          && $url['scheme'] == 'https' ) {
            $is_https = true;
        } else {
            $is_https = false;
        }

        return $is_https;
    }

    /**
     * detect correct cookie path
     */
    function checkCookiePath()
    {
        $this->set('cookie_path', PMA_Config::getCookiePath());
    }

    /**
     * @static
     */
    function getCookiePath()
    {
        static $cookie_path = null;

        if ( null !== $cookie_path ) {
            return $cookie_path;
        }

        if ( ! empty($_SERVER['REQUEST_URI'] ) ) {
            $url = parse_url($_SERVER['REQUEST_URI']);
        }

        // If we don't have path
        if ( empty( $url['path'] ) ) {
            if (!empty($_SERVER['PATH_INFO'])) {
                $url = parse_url($_SERVER['PATH_INFO']);
            } else {
                // PHP_SELF in CGI often points to cgi executable, so use it
                // as last choice
                $url = parse_url($_SERVER['PHP_SELF']);
            }
        }

        $cookie_path   = substr($url['path'], 0,
            strrpos($url['path'], '/')) . '/';

        return $cookie_path;
    }

    /**
     * enables backward compatibility
     */
    function enableBc()
    {
        $GLOBALS['cfg']             =& $this->settings;
        $GLOBALS['default_server']  =& $this->default_server;
        $GLOBALS['collation_connection'] = $this->get('collation_connection');
        $GLOBALS['is_upload']       = $this->get('enable_upload');
        $GLOBALS['max_upload_size'] = $this->get('max_upload_size');
        $GLOBALS['cookie_path']     = $this->get('cookie_path');
        $GLOBALS['is_https']        = $this->get('is_https');

        $defines = array(
            'PMA_VERSION',
            'PMA_THEME_VERSION',
            'PMA_THEME_GENERATION',
            'PMA_PHP_STR_VERSION',
            'PMA_PHP_INT_VERSION',
            'PMA_IS_WINDOWS',
            'PMA_IS_IIS',
            'PMA_IS_GD2',
            'PMA_USR_OS',
            'PMA_USR_BROWSER_VER',
            'PMA_USR_BROWSER_AGENT',
             );

        foreach ( $defines as $define ) {
            if ( ! defined($define) ) {
                define($define, $this->get($define));
            }
        }
    }

    /**
     * @todo finish
     */
    function save() {}
}
?>
