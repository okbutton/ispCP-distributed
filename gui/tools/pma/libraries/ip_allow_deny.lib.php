<?php
/* $Id: ip_allow_deny.lib.php,v 2.7.2.1 2006/04/11 16:33:33 cybot_tm Exp $ */
// vim: expandtab sw=4 ts=4 sts=4:

/**
 * This library is used with the server IP allow/deny host authentication
 * feature
 */


/**
 * Gets the "true" IP address of the current user
 *
 * @return  string   the ip of the user
 *
 * @access  private
 */
function PMA_getIp()
{
    global $REMOTE_ADDR;
    global $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED;
    global $HTTP_VIA, $HTTP_X_COMING_FROM, $HTTP_COMING_FROM;

    // Get some server/environment variables values
    if (empty($REMOTE_ADDR) && PMA_getenv('REMOTE_ADDR')) {
        $REMOTE_ADDR = PMA_getenv('REMOTE_ADDR');
    }
    if (empty($HTTP_X_FORWARDED_FOR) && PMA_getenv('HTTP_X_FORWARDED_FOR')) {
        $HTTP_X_FORWARDED_FOR = PMA_getenv('HTTP_X_FORWARDED_FOR');
    }
    if (empty($HTTP_X_FORWARDED) && PMA_getenv('HTTP_X_FORWARDED')) {
        $HTTP_X_FORWARDED = PMA_getenv('HTTP_X_FORWARDED');
    }
    if (empty($HTTP_FORWARDED_FOR) && PMA_getenv('HTTP_FORWARDED_FOR')) {
        $HTTP_FORWARDED_FOR = PMA_getenv('HTTP_FORWARDED_FOR');
    }
    if (empty($HTTP_FORWARDED) && PMA_getenv('HTTP_FORWARDED')) {
        $HTTP_FORWARDED = PMA_getenv('HTTP_FORWARDED');
    }
    if (empty($HTTP_VIA) && PMA_getenv('HTTP_VIA')) {
        $HTTP_VIA = PMA_getenv('HTTP_VIA');
    }
    if (empty($HTTP_X_COMING_FROM) && PMA_getenv('HTTP_X_COMING_FROM')) {
        $HTTP_X_COMING_FROM = PMA_getenv('HTTP_X_COMING_FROM');
    }
    if (empty($HTTP_COMING_FROM) && PMA_getenv('HTTP_COMING_FROM')) {
        $HTTP_COMING_FROM = PMA_getenv('HTTP_COMING_FROM');
    }

    // Gets the default ip sent by the user
    if (!empty($REMOTE_ADDR)) {
        $direct_ip = $REMOTE_ADDR;
    }

    // Gets the proxy ip sent by the user
    $proxy_ip     = '';
    if (!empty($HTTP_X_FORWARDED_FOR)) {
        $proxy_ip = $HTTP_X_FORWARDED_FOR;
    } elseif (!empty($HTTP_X_FORWARDED)) {
        $proxy_ip = $HTTP_X_FORWARDED;
    } elseif (!empty($HTTP_FORWARDED_FOR)) {
        $proxy_ip = $HTTP_FORWARDED_FOR;
    } elseif (!empty($HTTP_FORWARDED)) {
        $proxy_ip = $HTTP_FORWARDED;
    } elseif (!empty($HTTP_VIA)) {
        $proxy_ip = $HTTP_VIA;
    } elseif (!empty($HTTP_X_COMING_FROM)) {
        $proxy_ip = $HTTP_X_COMING_FROM;
    } elseif (!empty($HTTP_COMING_FROM)) {
        $proxy_ip = $HTTP_COMING_FROM;
    } // end if... elseif...

    // Returns the true IP if it has been found, else FALSE
    if (empty($proxy_ip)) {
        // True IP without proxy
        return $direct_ip;
    } else {
        $is_ip = preg_match('|^([0-9]{1,3}\.){3,3}[0-9]{1,3}|', $proxy_ip, $regs);
        if ($is_ip && (count($regs) > 0)) {
            // True IP behind a proxy
            return $regs[0];
        } else {
            // Can't define IP: there is a proxy but we don't have
            // information about the true IP
            return FALSE;
        }
    } // end if... else...
} // end of the 'PMA_getIp()' function


/**
 * Based on IP Pattern Matcher
 * Originally by J.Adams <jna@retina.net>
 * Found on <http://www.php.net/manual/en/function.ip2long.php>
 * Modified by Robbat2 <robbat2@users.sourceforge.net>
 *
 * Matches:
 * xxx.xxx.xxx.xxx        (exact)
 * xxx.xxx.xxx.[yyy-zzz]  (range)
 * xxx.xxx.xxx.xxx/nn     (CIDR)
 *
 * Does not match:
 * xxx.xxx.xxx.xx[yyy-zzz]  (range, partial octets not supported)
 *
 * @param   string   string of IP range to match
 * @param   string   string of IP to test against range
 *
 * @return  boolean    always true
 *
 * @access  public
 */
function PMA_ipMaskTest($testRange, $ipToTest)
{
   $result = TRUE;

   if (preg_match('|([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)/([0-9]+)|', $testRange, $regs)) {
       // performs a mask match
       $ipl    = ip2long($ipToTest);
       $rangel = ip2long($regs[1] . '.' . $regs[2] . '.' . $regs[3] . '.' . $regs[4]);

       $maskl  = 0;

       for ($i = 0; $i < 31; $i++) {
           if ($i < $regs[5] - 1) {
               $maskl = $maskl + pow(2, (30 - $i));
           } // end if
       } // end for

       if (($maskl & $rangel) == ($maskl & $ipl)) {
           return TRUE;
       } else {
           return FALSE;
       }
   } else {
       // range based
       $maskocts = explode('.', $testRange);
       $ipocts   = explode('.', $ipToTest);

       // perform a range match
       for ($i = 0; $i < 4; $i++) {
            if (preg_match('|\[([0-9]+)\-([0-9]+)\]|', $maskocts[$i], $regs)) {
                if (($ipocts[$i] > $regs[2])
                    || ($ipocts[$i] < $regs[1])) {
                    $result = FALSE;
                } // end if
            } else {
                if ($maskocts[$i] <> $ipocts[$i]) {
                    $result = FALSE;
                } // end if
            } // end if/else
       } //end for
   } //end if/else

   return $result;
} // end of the "PMA_IPMaskTest()" function


/**
 * Runs through IP Allow/Deny rules the use of it below for more information
 *
 * @param   string 'allow' | 'deny' type of rule to match
 *
 * @return  bool   Matched a rule ?
 *
 * @access  public
 *
 * @see     PMA_getIp()
 */
function PMA_allowDeny($type)
{
    global $cfg;

    // Grabs true IP of the user and returns if it can't be found
    $remote_ip = PMA_getIp();
    if (empty($remote_ip)) {
        return FALSE;
    }

    // copy username
    $username  = $cfg['Server']['user'];

    // copy rule database
    $rules     = $cfg['Server']['AllowDeny']['rules'];

    // lookup table for some name shortcuts
    $shortcuts = array(
        'all'       => '0.0.0.0/0',
        'localhost' => '127.0.0.1/8'
    );

    // Provide some useful shortcuts if server gives us address:
    if (PMA_getenv('SERVER_ADDR')) {
        $shortcuts['localnetA'] = PMA_getenv('SERVER_ADDR') . '/8';
        $shortcuts['localnetB'] = PMA_getenv('SERVER_ADDR') . '/16';
        $shortcuts['localnetC'] = PMA_getenv('SERVER_ADDR') . '/24';
    }

    foreach ($rules AS $rule) {
        // extract rule data
        $rule_data = explode(' ', $rule);

        // check for rule type
        if ($rule_data[0] != $type) {
            continue;
        }

        // check for username
        if (($rule_data[1] != '%') //wildcarded first
            && ($rule_data[1] != $username)) {
            continue;
        }

        // check if the config file has the full string with an extra
        // 'from' in it and if it does, just discard it
        if ($rule_data[2] == 'from') {
            $rule_data[2] = $rule_data[3];
        }

        // Handle shortcuts with above array
        // DON'T use "array_key_exists" as it's only PHP 4.1 and newer.
        if (isset($shortcuts[$rule_data[2]])) {
            $rule_data[2] = $shortcuts[$rule_data[2]];
        }

        // Add code for host lookups here
        // Excluded for the moment

        // Do the actual matching now
        if (PMA_ipMaskTest($rule_data[2], $remote_ip)) {
            return TRUE;
        }
    } // end while

    return FALSE;
} // end of the "PMA_AllowDeny()" function

?>
