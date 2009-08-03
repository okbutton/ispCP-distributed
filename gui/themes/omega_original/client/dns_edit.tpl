<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_EDIT_DNS_PAGE_TITLE}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
<script type="text/javascript">
<!--
function action_delete(url, alias_or_subdomain) {
	if (!confirm(sprintf("{TR_MESSAGE_DELETE}", alias_or_subdomain)))
		return false;
	location = url;
}
//-->
</script>
<style type="text/css">
tr.DNS {
	display: none;
}
</style>
</head>
<body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<script type="text/javascript">
/* <![CDATA[ */

	var oStyleSheet;
	if (document.styleSheets) {
		for (var i = 0; i < document.styleSheets.length; i++) {
			if (document.styleSheets[i].href != null && document.styleSheets[i].href.indexOf('demostyles.css') + 1) {
				oStyleSheet = document.styleSheets[i];
				break;
			}
		}
		if (!oStyleSheet) {
			oStyleSheet = document.styleSheets[document.styleSheets.length-1];
		}
	}

	function showNoDOMSSWarning() { alert('Your browser does not support DOM 2 Style Sheets'); }
	function showNoSSWarning() { alert('Your browser does not support document.styleSheets'); }
	function showNoSSFoundWarning() { alert('Your browser does not have any stylesheets in the document.styleSheets collection'); }
	function showNoDemoWarning() { alert('Your browser does not allow me to find the demonstration stylesheet'); }
	function showNoBothSSWarning() { alert('Your browser does not correctly support DOM 2 Style Sheets or the Internet Explorer stylesheets model'); }


	var lastRule = null;

	function dns_type_changed(sender) {
		if(!document.styleSheets) { showNoSSWarning(); return; }
		if(!document.styleSheets.length) { showNoSSFoundWarning(); return; }
		if(!oStyleSheet) { showNoDemoWarning(); return; }
		if(!oStyleSheet.insertRule || !oStyleSheet.cssRules || !oStyleSheet.cssRules.length) { showNoDOMSSWarning(); return; }
		try {
			if (lastRule != null) {
				oStyleSheet.deleteRule(lastRule);
			}
			lastRule = oStyleSheet.insertRule('tr.DNS_'+sender+' { display : table-row;}', oStyleSheet.cssRules.length);
		} catch(e) {
			showNoDOMSSWarning();
		}
	}

	var IPADDRESS = "[0-9\.]";
	var IPv6ADDRESS = "[0-9a-f:A-F]";
	var NUMBERS = "[0-9]";

	function filterChars(e, allowed){
		e = e || window.event;
		var keynum = e ? e.which : event.keyCode;

		if ((keynum == 8) || (keynum == 0)) {
			return true;
		}
		var keychar = String.fromCharCode(keynum);

		if (e.ctrlKey && ((keychar="C") || (keychar="c") || (keychar="V") || (keychar="v"))) {
			return true;
		}
		var re = new RegExp(allowed);
		return re.test(keychar);
	}

/* ]]> */
</script>
<!-- ToolTip -->
<div id="fwd_help" style="background-color:#ffffe0;border: 1px #000000 solid;display:none;margin:5px;padding:5px;font-size:11px;width:200px;position:absolute;">{TR_FWD_HELP}</div>
<!-- ToolTip end -->
<!-- BDP: logged_from -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="20" nowrap="nowrap" class="backButton">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="16" height="16" border="0" style="vertical-align:middle" alt="" /></a> {YOU_ARE_LOGGED_AS}</td>
	</tr>
</table>
<!-- EDP: logged_from -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;padding:0;margin:0 auto;">
	<tr>
		<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" width="195" height="56" border="0" alt="ispCP Logogram" /></td>
		<td style="height: 56px; width:100%; background-color: #0f0f0f"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" width="582" height="56" border="0" alt="" /></td>
		<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" width="73" height="56" border="0" alt="" /></td>
	</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
		<td colspan="2" style="vertical-align: top;">
			<table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
				<tr style="height:95px;">
					<td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
					<td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" width="73" height="95" border="0" alt="" /></td>
				</tr>
				<tr>
					<td colspan="3">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left">
									<table width="100%" cellpadding="5" cellspacing="5">
										<tr>
											<td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_domains.png" width="25" height="25" alt="" /></td>
											<td colspan="2" class="title">{TR_MANAGE_DOMAIN_DNS}</td>
										</tr>
									</table>
								</td>
								<td width="27" align="right">&nbsp;</td>
							</tr>
							<tr>
								<td>
									<form name="edit_alias_frm" method="post" action="{ACTION_MODE}">
										<table width="100%" cellpadding="5" cellspacing="5">
											<tr>
												<td width="25">&nbsp;</td>
												<td colspan="2" class="content3"><b>{TR_EDIT_DNS}</b></td>
											</tr>
											<!-- BDP: page_message -->
											<tr>
												<td>&nbsp;</td>
												<td colspan="2" class="title"><span class="message">{MESSAGE}</span></td>
											</tr>
											<!-- EDP: page_message -->
											<!-- BDP: add_record -->
											<tr>
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DOMAIN}</td>
												<td class="content"><select name="alias_id">{SELECT_ALIAS}</select></td>
											</tr>
											<!-- EDP: add_record -->
											<tr>
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_TYPE}</td>
												<td class="content"><select id="dns_type" onchange="dns_type_changed(this.value)" name="type">{SELECT_DNS_TYPE}</select></td>
											</tr>
											<tr>
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_CLASS}</td>
												<td class="content"><select name="class">{SELECT_DNS_CLASS}</select></td>
											</tr>
											<tr class="DNS DNS_A DNS_AAAA DNS_CNAME">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_NAME}</td>
												<td class="content"><input type="text" name="dns_name" value="{DNS_NAME}" /></td>
											</tr>
											<tr class="DNS DNS_SRV">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_NAME}</td>
												<td class="content"><input type="text" name="dns_srv_name" value="{DNS_SRV_NAME}" /></td>
											</tr>
											<tr class="DNS DNS_A">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_IP_ADDRESS}</td>
												<td class="content"><input type="text" onkeypress="return filterChars(event, IPADDRESS);" name="dns_A_address" value="{DNS_ADDRESS}" /></td>
											</tr>
											<tr class="DNS DNS_AAAA">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_IP_ADDRESS_V6}</td>
												<td class="content"><input type="text" onkeypress="return filterChars(event, IPv6ADDRESS);" name="dns_AAAA_address" value="{DNS_ADDRESS_V6}" /></td>
											</tr>
											<tr class="DNS DNS_SRV">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_PROTOCOL}</td>
												<td class="content"><select name="srv_proto" id="srv_protocol">{SELECT_DNS_SRV_PROTOCOL}</select></td>
											</tr>
											<tr class="DNS DNS_SRV">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_TTL}</td>
												<td class="content"><input type="text" onkeypress="return filterChars(event, NUMBERS);" name="dns_srv_ttl" value="{DNS_SRV_TTL}" /></td>
											</tr>
											<tr class="DNS DNS_SRV DNS_MX">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_PRIO}</td>
												<td class="content"><input type="text" onkeypress="return filterChars(event, NUMBERS);" name="dns_srv_prio" value="{DNS_SRV_PRIO}" /></td>
											</tr>
											<tr class="DNS DNS_SRV">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_WEIGHT}</td>
												<td class="content"><input type="text" onkeypress="return filterChars(event, NUMBERS);" name="dns_srv_weight" value="{DNS_SRV_WEIGHT}" /></td>
											</tr>
											<tr class="DNS DNS_SRV DNS_MX">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_HOST}</td>
												<td class="content"><input type="text" name="dns_srv_host" value="{DNS_SRV_HOST}" /></td>
											</tr>
											<tr class="DNS DNS_SRV">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_SRV_PORT}</td>
												<td class="content"><input type="text" onkeypress="return filterChars(event, NUMBERS);" name="dns_srv_port" value="{DNS_SRV_PORT}" /></td>
											</tr>
											<tr class="DNS DNS_CNAME">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_CNAME}</td>
												<td class="content"><input type="text" name="dns_cname" value="{DNS_CNAME}" />.</td>
											</tr>
											<tr class="DNS DNS_CERT DNS_DNAME DNS_GPOS DNS_KEY DNS_KX DNS_NAPTR DNS_NSAP DNS_NS DNS_NXT DNS_PTR DNS_PX DNS_SIG DNS_TXT">
												<td width="25">&nbsp;</td>
												<td width="200" class="content2">{TR_DNS_PLAIN}</td>
												<td class="content"><input type="text" name="dns_plain_data" value="{DNS_PLAIN}" />.</td>
											</tr>
											<tr>
												<td width="25">&nbsp;</td>
												<td colspan="2">
													<!-- BDP: form_edit_mode -->
													<input name="Submit" type="submit" class="button" value="  {TR_MODIFY}  " />
													<input type="hidden" name="uaction" value="modify" />
													<!-- EDP: form_edit_mode -->
													<!-- BDP: form_add_mode -->
													<input name="Submit" type="submit" class="button" value="  {TR_ADD}  " />
													<input type="hidden" name="uaction" value="add" />
													<!-- EDP: form_add_mode -->
													&nbsp;&nbsp;&nbsp;
													<input name="Submit" type="submit" class="button" onclick="MM_goToURL('parent','domains_manage.php');return document.MM_returnValue" value=" {TR_CANCEL} " />
												</td>
											</tr>
										</table>
									</form>
								</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<script type="text/javascript">
/* <![CDATA[ */

	dns_type_changed(document.getElementById('dns_type').value);

/* ]]> */
</script>
</body>
</html>