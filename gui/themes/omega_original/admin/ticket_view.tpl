<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_SUPPORT_SYSTEM}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
</head>

<body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;padding:0;margin:0;">
<tr>
<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" width="195" height="53" border="0" alt="ispCP Logogram" /></td>
<td style="height: 56px; width:100%; background-color: #0f0f0f"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" width="582" height="53" border="0" alt="" /></td>
<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" width="73" height="56" border="0" alt="" /></td>
</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
	    <td colspan="2" style="vertical-align: top;"><table style="width: 100%; padding:0;margin:0;" cellspacing="0">
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
		<td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_support.png" width="25" height="25" alt="" /></td>
        <td colspan="2" class="title">{TR_VIEW_SUPPORT_TICKET}</td>
    </tr>
</table>
	</td>
    <td width="27" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40">&nbsp;</td>
        <td valign="top"><table width="100%" cellpadding="5" cellspacing="5">
          <!-- BDP: page_message -->
          <tr>
            <td class="title"><span  class="message">{MESSAGE}</span></td>
          </tr>
          <!-- EDP: page_message -->
          <!-- BDP: tickets_list -->
          <tr>
            <td nowrap="nowrap" class="content3"> {TR_TICKET_URGENCY}: {URGENCY}<br />
              {TR_TICKET_SUBJECT}: {SUBJECT}</td>
          </tr>
          <!-- BDP: tickets_item -->
          <tr>
            <td nowrap="nowrap" class="content2"><span class="content">{TR_TICKET_FROM} : {FROM}</span><br />
              {TR_TICKET_DATE} : {DATE}</td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="content">{TICKET_CONTENT}</td>
          </tr>
          <!-- EDP: tickets_item -->
        </table></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
<table width="100%" cellpadding="5" cellspacing="5">
	<tr>
		<td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_doc.png" width="25" height="25" alt="" /></td>
        <td colspan="2" class="title">{TR_NEW_TICKET_REPLY}</td>
    </tr>
</table>
	</td>
    <td width="27" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40">&nbsp;</td>
        <td valign="top"><form action="ticket_view.php?ticket_id={ID}&amp;screenwidth={SCREENWIDTH}" method="post" name="question_frm" id="question_frm">
          <table width="100%" cellspacing="5">
            <tr>
              <td class="content"><textarea name="user_message" style="width:80%" class="textinput2" cols="80" rows="20"></textarea>
                      <input name="subject" type="hidden" value="{SUBJECT}" />
                      <input name="urgency" type="hidden" value="{URGENCY_ID}" />
              </td>
            </tr>
            <tr>
              <td><input name="Button" type="button" class="button" value="{TR_REPLY}" onclick="return sbmt(document.forms[0],'send_msg');" />
                &nbsp;&nbsp;&nbsp;
                <input name="Button" type="button" class="button" value="{TR_ACTION}" onclick="return sbmt(document.forms[0],'{ACTION}');" />
              </td>
            </tr>
            <!-- EDP: tickets_list -->
          </table>
          <!-- end of content -->
          <input name="uaction" type="hidden" value="" />
          <input name="screenwidth" type="hidden" value="{SCREENWIDTH}" />
        </form></td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table></td>
				</tr>
			</table></td>
	</tr>
</table>
</body>
</html>
