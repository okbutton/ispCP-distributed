<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_CLIENT_EDIT_EMAIL_PAGE_TITLE}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/jquery.js"></script>
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/jquery.ispcpTooltips.js"></script>
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>

<script type="text/javascript">
/*<![CDATA[*/
	$(document).ready(function(){
		// Tooltips - begin
		$('#fwd_help').ispCPtooltips({msg:"{TR_FWD_HELP}"});
		// Tooltips - end
	});

	function begin_js() {
		if (typeof(document.forms[0].elements['mail_forward']) != 'undefined') {
			if (document.forms[0].elements['mail_forward'].checked == false) {
				document.forms[0].elements['forward_list'].disabled = true;
			}
		}
	}

	function changeType(what) {
		if (what == "forward") {
			if (document.forms[0].elements['forward_list'].disabled == true) {
			 	document.forms[0].elements['forward_list'].disabled = false;
			} else {
				document.forms[0].elements['forward_list'].disabled = true;
			}
		}
	}
/*]]>*/
</script>
</head>

 <body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/ftp_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/email_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif'); begin_js();">

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;padding:0;margin:0 auto;">
<!-- BDP: logged_from -->
<tr>
 <td colspan="3" height="20" nowrap="nowrap" class="backButton">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="16" height="16" border="0" style="vertical-align:middle" alt="" /></a> {YOU_ARE_LOGGED_AS}</td>
</tr>
<!-- EDP: logged_from -->
  <tr>
   <td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" width="195" height="56" border="0" alt="ispCP Logogram" /></td>
   <td style="height: 56px; width:100%; background-color: #0f0f0f"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" width="582" height="56" border="0" alt="" /></td>
   <td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" width="73" height="56" border="0" alt="" /></td>
  </tr>
  <tr>
   <td style="width: 195px; vertical-align: top;">{MENU}</td>
   <td colspan="2" style="vertical-align: top;">
    <table style="width: 100%; padding:0;margin:0;" cellspacing="0">
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
            <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_doc.png" width="25" height="25" alt="" /></td>
            <td colspan="2" class="title">{TR_EDIT_EMAIL_ACCOUNT}</td>
           </tr>
          </table>
         </td>
         <td width="27" align="right">&nbsp;</td>
        </tr>
        <tr>
         <td>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
           <tr>
            <td width="40">&nbsp;</td>
             <td valign="top">
              <form name="edit_mail_acc_frm" method="post" action="mail_edit.php?id={MAIL_ID}">
              <table width="100%" cellpadding="3" cellspacing="3">
               <!-- BDP: page_message -->
               <tr>
                <td colspan="2" class="title"><span class="message">{MESSAGE}</span></td>
               </tr>
               <!-- EDP: page_message -->
               <tr>
                <td class="title">{EMAIL_ACCOUNT}</td>
               </tr>
              </table>
              <!-- BDP: normal_mail -->
              <table width="100%" cellpadding="5" cellspacing="5">
               <tr>
                <td width="200" class="content2"><label for="pass">{TR_PASSWORD}</label></td>
                <td class="content">
                 <input type="password" name="pass" id="pass" value="" style="width:210px" class="textinput" />
                </td>
               </tr>
               <tr>
                <td width="200" class="content2"><label for="pass_rep">{TR_PASSWORD_REPEAT}</label></td>
                <td class="content">
                 <input type="password" name="pass_rep" id="pass_rep" value="" style="width:210px" class="textinput" />
                </td>
               </tr>
               <tr>
                <td nowrap="nowrap" class="content2" colspan="2">
                 &nbsp;&nbsp;<input type="checkbox" name="mail_forward" id="mail_forward" value="1" {FORWARD_MAIL_CHECKED} onclick="changeType('forward');" /><label for="mail_forward">{TR_FORWARD_MAIL}</label>
                </td>
               </tr>
               <tr>
                <td class="content2" style="width:200px;vertical-align:top;">
                 <label for="forward_list">{TR_FORWARD_TO}</label> <img id="fwd_help" src="{THEME_COLOR_PATH}/images/icons/help.png" width="16" height="16" alt="" />
                </td>
                <td nowrap="nowrap" class="content">
                 <textarea name="forward_list" id="forward_list" cols="35" rows="10" wrap="virtual" style="width:400px">{FORWARD_LIST}</textarea>
                </td>
               </tr>
              </table>
              <!-- EDP: normal_mail -->
              <!-- BDP: forward_mail -->
              <table width="100%" cellpadding="5" cellspacing="5">
               <tr>
                <td class="content2" style="width:125px;vertical-align:top;">
                 {TR_FORWARD_TO} <img id="fwd_help" src="{THEME_COLOR_PATH}/images/icons/help.png" width="16" height="16" />
                </td>
                <td class="content"><textarea name="forward_list" cols="35" rows="5" style="width:210px">{FORWARD_LIST}</textarea></td>
               </tr>
              </table>
              <!-- EDP: forward_mail -->
              <br />
              <input name="Button" type="button" class="button" value="  {TR_SAVE}  " onclick="return sbmt(document.forms[0],'{ACTION}');" />
              <input type="hidden" name="id" value="{MAIL_ID}" />
              <input type="hidden" name="mail_type" value="{MAIL_TYPE}" />
              <input type="hidden" name="mail_account" value="{EMAIL_ACCOUNT}" />
              <input type="hidden" name="uaction" value="{ACTION}" />
              </form>
             </td>
            </tr>
           </table>
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
 </body>
</html>
