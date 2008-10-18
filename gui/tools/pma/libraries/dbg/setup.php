<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * @version $Id: setup.php 11365 2008-07-01 19:21:28Z lem9 $
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * checks for DBG extension and tries to load if not loaded
 *
 * allways use $GLOBALS here, as this script is included by footer.inc.hp
 * which can also be included from inside a function
 */
if ($GLOBALS['cfg']['DBG']['php']) {
    /**
     * Loads the DBG extension if needed
     */
    if (! @extension_loaded('dbg') && ! PMA_dl('dbg')) {
        $message = PMA_Message::error('strCantLoad');
        $message->addParam('DBG');
        $message->addMessage('<a href="./Documentation.html#faqdbg" target="documentation">', false);
        $message->addString('strDocu');
        $message->addMessage('</a>', false);
        $message->display();
    } else {
        $GLOBALS['DBG'] = true;
    }
}
?>
