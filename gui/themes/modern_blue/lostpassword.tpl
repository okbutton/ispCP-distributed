<html>
 <head>
  <title>{TR_MAIN_INDEX_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
  <meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
  <link href="{THEME_COLOR_PATH}/css/vhcs.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="{THEME_COLOR_PATH}/css/vhcs.js"></script>
 </head>
 <body text="#000000">
  <table width="100%" height="100%"  border="0" cellpadding="0" cellspacing="0" bgcolor="#334163">
   <tr>
    <td height="551">
     <table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr bgcolor="#334163">
       <td width="1">&nbsp;</td>
       <td align="right">
        <span class="login_time">{TR_TIME}</span>&nbsp;&nbsp;&nbsp;<br>
        <span class="login_bottom">{TR_DATE}</span>&nbsp;&nbsp;&nbsp;
       </td>
      </tr>
      <tr>
       <td width="1" background="{THEME_COLOR_PATH}/images/login/content_background.gif"><img src="{THEME_COLOR_PATH}/images/login/content_background.gif" width="1" height="348"></td>
       <td height="348" align="center" background="{THEME_COLOR_PATH}/images/login/content_background.gif">
        <form name="frm" action="lostpassword.php" method="post">
        <table border="00" cellspacing="0" cellpadding="0">
         <tr>
          <td width="20" rowspan="6"><img src="images/isp_logo.gif"></td>
          <td width="20" rowspan="6">&nbsp;</td>
          <td width="2" rowspan="6" background="{THEME_COLOR_PATH}/images/login/content_line.gif"><img src="{THEME_COLOR_PATH}/images/trans.gif" width="2" height="2"></td>
          <td width="20" rowspan="6">&nbsp;</td>
          <td colspan="2"><strong><div class="login_text">{TR_IMGCAPCODE}<br />{TR_CAPCODE}</div></strong></td>
         </tr>
         <tr>
          <td colspan="2"><input name="capcode" type="text" class="textinput" ID="capcode" style="width:210px" value=""></td>
         </tr>
         <tr>
          <td width="210" colspan="6" class="imgcapcode_description_text"><p>{TR_IMGCAPCODE_DESCRIPTION}</p></td>
         </tr>
         <tr>
          <td><br></td>
         </tr>
         <tr>
          <td colspan="2"><strong>
           <div class="login_text">{TR_USERNAME}</div>
          </td>
         </tr>
         <tr>
          <td width="161" colspan="2"><input name="uname" type="text" class="textinput" id="uname3" style="width:210px" value=""></td>
         </tr>
         <tr>
          <td colspan="2">&nbsp;</td>
          <td background="{THEME_COLOR_PATH}/images/login/content_line.gif">&nbsp;</td>
          <td colspan="3">&nbsp;</td>
         </tr>
         <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td background="{THEME_COLOR_PATH}/images/login/content_line.gif">&nbsp;</td>
          <td>&nbsp;</td>
          <td align="left" valign="bottom"><input type="submit" name="Submit" class="button" value="   {TR_SEND}   "></td>
          <td align="left" valign="bottom"><a class="login" href="index.php">{TR_BACK}</a></td>
         </tr>
        </table>
        </form>
       </td>
      </tr>
      <tr>
       <td width="1" height="2" background="{THEME_COLOR_PATH}/images/login/content_down.gif"><img src="{THEME_COLOR_PATH}/images/login/content_down.gif" width="2" height="2"></td>
       <td height="2" background="{THEME_COLOR_PATH}/images/login/content_down.gif"><img src="{THEME_COLOR_PATH}/images/login/content_down.gif" width="2" height="2"></td>
      </tr>
      <tr>
       <td width="1" bgcolor="#334163">&nbsp;</td>
       <td bgcolor="#334163"><a href="http://www.vhcs.net" target="_blank"><img src="{THEME_COLOR_PATH}/images/login/vhcs_logo.gif" alt="VHCS - Virtual Hosting Control System - Control Panel" width="68" height="60" border="0"></a></td>
      </tr>
     </table>
    </td>
   </tr>
  </table>
 </body>
</html>

