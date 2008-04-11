<?php
/**
 * functions.php
 *
 * @author Jimmy Conner <jimmy@sqmail.org>
 * @copyright Copyright &copy; 2005, Jimmy Conner (Licensed under the GNU GPL see "LICENSE")
 *
 * @package plugins
 * @subpackage notes
 * @version $Id: functions.php,v 1.1 2005/01/05 15:02:26 cigamit Exp $
 */

function notes_add_link() {
   bindtextdomain('notes', SM_PATH . 'plugins/notes/locale');
   textdomain('notes');
   displayInternalLink('plugins/notes/notes.php', _("Notes"), 'right');
   echo "&nbsp;&nbsp;\n";
   bindtextdomain('squirrelmail', SM_PATH . 'locale');
   textdomain('squirrelmail');
}

?>