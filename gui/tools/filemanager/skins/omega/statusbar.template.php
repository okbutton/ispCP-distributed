<?php defined("NET2FTP") or die("Direct access to this location is not allowed."); ?>
<!-- Template /skins/omega/statusbar.php begin -->
<script type="text/javascript" src="<?php echo $net2ftp_globals["application_rootdir_url"]; ?>/skins/<?php echo $net2ftp_globals["skin"]; ?>/status/status.js"></script>
<?php require_once($net2ftp_globals["application_skinsdir"] . "/" . $net2ftp_globals["skin"] . "/status/status.template.php"); ?>
	<div id="head">
		<div id="headleft">
			<a href="http://www.net2ftp.com" target="_blank"><img src="<?php echo $net2ftp_globals["image_url"]; ?>/img/logo.png" alt="net2ftp" width="193" height="59" border="0" /></a>
		</div><div id="buttonsright">
		<div style="float: <?php echo __("right"); ?>; text-align: <?php echo __("right"); ?>;">
			<form id="StatusbarForm" method="post" action="<?php echo $net2ftp_globals["action_url"]; ?>">
<?php			printLoginInfo(); ?>
			<input type="hidden" name="state"     value="browse" />
			<input type="hidden" name="state2"    value="main" />
			<input type="hidden" name="directory" value="<?php echo $net2ftp_globals["directory_html"]; ?>" />
			<input type="hidden" name="url"       value="<?php echo printPHP_SELF("bookmark"); ?>" />
			<input type="hidden" name="text"      value="net2ftp <?php echo $net2ftp_globals["ftpserver"]; ?>" />
<?php			if ($net2ftp_globals["state"] != "bookmark") { printActionIcon("bookmark", "document.forms['StatusbarForm'].state.value='bookmark';document.forms['StatusbarForm'].submit();"); } ?>
<?php			printActionIcon("refresh",  "window.location.reload();"); ?>
<?php			printActionIcon("help",     "void(window.open('" . $net2ftp_globals["application_rootdir_url"] . "/help.html','Help','location,menubar,resizable,scrollbars,status,toolbar'));"); ?>
<?php			printActionIcon("logout",   "document.forms['StatusbarForm'].state.value='logout';document.forms['StatusbarForm'].submit();"); ?>
			</form></div>
		</div>
 	</div>
<!-- Template /skins/omega/statusbar.php end -->
