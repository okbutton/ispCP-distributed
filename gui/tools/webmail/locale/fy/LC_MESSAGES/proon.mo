��    |      �  �   �      x
     y
     �
     �
     �
  1   �
     �
     �
  '        *  :  ,    g  �  x  X  a  
   �  $   �     �     �           	          +  
   9     D  	   Q     [     g     p     }     �     �     �     �  �   �  �   [  �   �  '  �  �   �     p  2   �     �  �  �  �   �  m   7  K  �  �   �  g  �      �   1  �   �  Z  �     �!  �  �#     �%     �%     �%     �%     �%     &     &     8&  5   @&     v&     �&     �&  �  �&     h(     w(  	   �(     �(     �(     �(  n  �(     %,  	   >,     H,     V,  ^   _,     �,     �,     �,     �,     �,     -  	   -     -  �   <-     �-     .     .  %  :.     `/  �   |/  x  j0    �1  �   �3  v  �4  I  K;  '  �<     �>    �>     �?     �?     �?     @  =   @  �  T@    4B    @C  \  RE    �F     �H     �H     �H  -   �H  (   �H     I     'I     /I     HI  !   TI  &   vI  +   �I     �I  W  �I     %K     -K     5K     KK  -   _K     �K     �K  ,   �K     �K  7  �K    M  �  (N  k  P     ~Q     �Q     �Q     �Q     �Q     �Q     �Q     �Q     R     R     %R     3R  
   ?R     JR  
   aR     lR     sR     wR     �R  �   �R  �   OS  �   �S  `  �T  �   �U     �V  <   �V     �V    �V  �   �Y  {   �Z  z  ![  �   �\  �  �]  Y  _  �   fa  �   b  G  �b    �c  �  f     h     h     h     6h     Mh  #   gh  "   �h  	   �h  6   �h     �h     i  !   i  �  :i     �j     k  	   !k     +k     Dk  	   Kk  4  Uk     �n  	   �n     �n     �n  f   �n  
   7o     Bo     Vo  "   co     �o     �o     �o  '   �o  �   �o     �p  !   �p  (   �p  E  q  '   Ur  �   }r  {  ls  �  �t  �   �v    �w  
  �~  �  �  )   [�  �   ��     }�     ��     ��     ��  E   ΃    �    �    4�  x  H�  =  ��     ��  
   �  	   �  7   �  3   N�     ��     ��  &   ��     ��  !   ɍ  (   �  -   �     B�         @      ]   U   +   )   t   o   R      r       e   Y          D   y   x      m   P   5       W   f   >       '       9   0   .           T   %      b                p   n   I          ?   ;   g   v   a   3      =   s              G   
                Q   	       \   8             7   2           *           w   h   C   j   S   :          1   z   !          X   #       ,   <       `   6           &   $       _   B       "                         -       V   E   q       H              ^       N       O       (      [   A   L   {      |   M   4                  l   J   K   k   d   c      /   u   Z                        i   F    (none) 2 hours 3 and one third hours 6 and one quarter days 6 and one quarter days plus 3 and one third hours 6 days 6 days plus 2 hours <i>Refresh main </i>Folders<i> list</i> ? A button is normally placed in the SquirrelMail left pane, beneath the list of folders, which enables you to quickly get to this page.  If this box is checked, that button is not drawn in the left pane.  You can still reach this page by selecting 'Options', 'Folder Preferences', and 'Options for Pruning Folders'. A count span counts messages in a folder.  The count may not be negative.  For safety, a value of 0 is treated the same as no value being specified.  Unlike a date span or a size span, a count span is always just a simple numeric value with no additional type of notation. A date span is a relative time duration and is specified as a combination of days and hours.  The overall time duration may not be negative.  For safety, a value of 0 is treated the same as no value being specified.  A simple number is interpreted as a number of days.  If there is a slash ('<code>/</code>'), the number after the slash is interpreted as a number of hours. If days and hours are both specified, they are simply added together.  Some examples are shown in the table below. A size span counts total bytes in a folder.  The size may not be negative.  For safety, a value of 0 is treated the same as no value being specified.  A size consists of a number and an optional suffix character.  The suffix character indicates a multiplier, as shown in the table below.  A number without a suffix gets a default suffix of 'm'. ATTENTION! Action Buttons and Per-Folder Values Before Bottom of Page CAUTION! Consider by Date Consider by Size Count Pruning Count Span Date Pruning Date Span Description Disabled Email Report Enabled First Folder Folder Table Folder doesn't exist. For a 'might be spam' quarantine folder, prune messages older than 30 days, and prune the folder to no more than 2 megabytes.  Again, do not protect unseen messages. For a high-traffic mailing list folder, which you only skim from time to time, prune messages older than a week, including unseen messages. For the 'Drafts' folder, prune anything older than 6 months on the grounds that if you haven't gotten around to finishing a note in that amount of time, you're never going to. For the 'Sent' folder, prune messages older than a week, including unseen messages.  This assumes you don't use your 'Sent' folder as a general collecting area.  If you haven't needed to retrieve something from there in a week (because you forgot to save a copy elsewhere), it can be tossed out. For the 'Trash' folder, prune messages older than 3 days.  Prune the 'Trash' folder to no more than 500 kilobytes or 20 total messages.  Include unseen messages in the pruning. Help and Explanations Here are some examples of fairly typical settings. INBOX If any pruning is requested for the Trash folder along with other folders, this preference controls the ordering.  'First' means that the Trash folder is pruned first, so at the end of a pruning session, it will hold the messages pruned from other folders.  'Last' means that the Trash folder is pruned last, so any messages moved there via pruning will then be subject to a second pruning at the end.  'Natural' means that the Trash folder will be pruned according to its natural order in the list of folders; in other words, it gets no special treatment with respect to ordering.  If no choice is made, the default is 'First'.  This setting makes no practical difference unless 'Prune via Trash' is selected. If disable this box is checked, pruning by message count will not be done.  Any per-folder values for the count span column will still be displayed, but they cannot be updated. If there is both a site setting and a user setting for a given folder, the minimum of the two values is used. If this box is checked, a report summarizing automatic pruning will be made part of the message-list panel.  In contrast to the email notification, a report is made even if no messages were pruned and no errors occurred.  The on-screen notification contains a more verbose version of the same information as the email notification. If this box is checked, a report summarizing automatic pruning will be put into the INBOX as a new message.  An email report is not made if no messages were pruned and no errors occurred. If this box is checked, messages pruned from other folders will be sent to the Trash folder.  Messages pruned from the Trash folder will be discarded.  If this box is not checked, messages pruned from all folders will be discarded immediately.  This setting is independent of the overall SquirrelMail setting for using the Trash folder when deleting messages. If this box is checked, pruning may also consider unsubscribed folders.  If not checked, only subscribed folders are considered, whether for manual pruning or automatic pruning (you can still use the per-folder 'Show Effect' or 'Prune Now' buttons).  This may be handy if you have unsubscribed folders which receive messages in some way other than by manually refiling things to them.  You can only add settings for a folder by subscribing to it, at least temporarily, but settings for unsubscribed folders are used if this box is checked. If this disable box is checked, pruning by message date will not be done.  Any per-folder values for the date span column will still be displayed, but they cannot be updated. If this disable box is checked, pruning by message size will not be done.  Any per-folder values for the size span column will still be displayed, but they cannot be updated. If this item is selected for a given folder, the folder will not be automatically pruned.  It will only be pruned through manual action by you.  Manual action means selecting either 'Prune All Folders' or 'Prune Now' from the pruning options form.  Automatic pruning means sign-on pruning as well as periodic pruning (if that option is selected). If this item is selected for a given folder, unseen (i.e., unread) messages have no special protection against pruning.  If not selected (the default), then the pruning process will not prune any unseen messages in the corresponding folder.  You might consider allowed unseen messages to be pruned from spam quanantine folders and folders which receive mailing list traffic which you don't always read.  You should be especially careful of the date, size, and count spans you specify for folders with this box checked. In effect, this action is the same as automatic pruning, except that it's triggered manually (and email reports are not made).  This action button is similar to the 'Prune Now' action button, except that the entire list of folders (and their invididual settings) is used.  Folders without at least one span value specified are silently skipped.  If some folders have erroneous values, an error message is shown for them, but other (non-error) folders are still pruned. Item Last Left Pane Prune Link Manual Only Messages (pruned): Messages (to prune): Messages automatically pruned: Natural None of the span values has been set for this folder. Nonexistent Folders On-Screen Report Options for Pruning Folders Ordinarily, there is one pruning attempt at SquirrelMail sign-on time.  If you want the sign-on prunings to be done less often, you can specify a number here.  For example, a value of 3 means 'every 3rd sign-on'.  No value specified or a value of 0 means 'every sign-on'.  The local SquirrelMail site administrator may have specified a maximum value for sign-on pruning frequency, in which case that takes precedence if it is lower. Problem with ' Prune All Folders Prune Now Prune via Trash Pruned Pruning ... Pruning can be done manually from this options page, or it can be done periodically and automatically.  This item specifies the recurring time period.  The format is the same as for the date span values for individual folders.  If not specified, no automatic/periodic pruning will be done; so, you can think of this field as an on/off switch for automatic pruning.  For safety, a value of 0 is treated the same as no value specified.  The local SquirrelMail site administrator may have specified a minimum pruning interval, in which case that takes precedence if it is lower.  The recurring interval is measured from the SquirrelMail session sign-on, so automatic pruning attempts will be made at the specified intervals thereafter.  The actual pruning happens coincident with some screen update activity, so an idle SquirrelMail session will not be doing any automatic pruning. Recurring Prune Interval Remainder Same as blank Save All Set a recurring pruning interval of 24 hours, just in case you stay logged on for a long time. Setting Show All Effects Show Effect Sign-on Prune Frequency Site Setting Size Pruning Size Span Size and Count Pruning Order Some folders WERE NOT pruned due to improper date, size, or count spans, or possibly other problems.  See the folder list below for details.  Those without problems WERE pruned. Subscribed Folders The count span is malformed. The date span is malformed. The following table describes user preferences that can affect how pruning is done or not done for you in particular.  The behavior might be changed or limited by site settings controlled by your local administrator.  Descriptions here are in the same order as the User Preferences form above. The size span is malformed. This action button immediately prunes the associated folder.  The number of messages which were pruned is displayed.  If there is not at least one span value specified for the folder, an error message is shown and no messages are pruned. This action button is similar to the 'Show Effect' action button, except that the entire list of folders (and their individual settings) is used.  Folders without at least one span value specified are silently skipped.  The numbers reported for the Trash folder do not take into account any messages that might be sent to the Trash folder as a result of pruning other folders. This action button saves all user preference values and per-folder settings.  If there are errors detected in the user options or per-folder settings, the save is not done.  As an aid to the user, the button has a different appearance when there are known differences between the values on this page and the values that have already been saved in the past.  That really only applies when the page has been redrawn after one of the action buttons.  The button appearance is not dynamically updated as you edit values on the page. This action button simulates pruning of the associated folder.  The number of messages which would have been pruned is displayed.  If there is not at least one span value specified for the folder, an error message is shown. This is an explanation for the user preferences and per-folder data which control selective automatic pruning of folders.  Pruning means the deletion of messages either because they are older than a certain date or to bring a folder to within a certain total size limit or number of messages.<ul><li>Pruning first considers message dates (if there is a user-specified date span value for that folder).  A message's date is the time since it was received by the mail server (this so-called 'internal date' is preserved if you move a message between folders).  Messages are deleted if they have an internal date older than the age indicated by the date span value.</li><li>Pruning next considers total folder size (if there is a user-specified folder size span).  If the folder is over that size limit, additional messages are pruned until the folder is at or below it.</li><li>Pruning finally considers the number of messages in the folder (if there is a user-specified count span).  If a folder has more than that many messages, additional messages are pruned until the folder is at or below the limit.</li></ul><p>In all those pruning cases, unread messages are normally protected and not pruned.  That protection can be removed on a folder-by-folder basis.  Pruning behavior may be flexibly controlled using a variety of other user preferences, each of which is described more fully below.  Unsubscribed and non-existent folders are listed if there is any user preference or site preference given for that folder; this is to avoid a surprise if you suddenly start using a folder of some name and would not otherwise realize that it had pruning options. This options page is normally constructed using colors from the user-chosen SquirrelMail theme, both to make a pleasing display and to highlight important information.  For some themes, this actually makes things on this page difficult to read.  If this box is checked, this options page will be built without most of the colors. This page allows you to conveniently prune messages from any or all folders by using a variety of criteria.  Messages can be pruned manually from this page, or they can be pruned automatically at sign-on and every so often.  Before using the automatic pruning, it would be a good idea to test your settings manually from this page to be sure they do what you want them to do.  Automatic pruning is enabled by giving an appropriate value for the 'Recurring Prune Interval' option, though sign-on pruning is done even if you don't give a value for that. Trash Pruning Order Unless you just clicked on a 'Pruning...' link, you have been automatically brought to this page because your site has installed a SquirrelMail plugin which provides automatic pruning of folders.  By default, no automatic pruning action will happen for you. Unseen, too Unsubscribed Folders Use Theme Colors User Preferences Values were NOT saved due to a problem in one or more fields. When considering which messages to prune by size span and/or by count span, there are two possible orders in which to consider them.  They can be considered by date, in which case messages are pruned from oldest to newest until the size or message count limit for the folder is met.  Or, they can be considered by size, in which case messages are pruned from largest to smallest until the size or message count limit is met.  If neither is selected, the default order is by date. When misconfigured, this tool can delete a lot of messages in a hurry.  If you haven't used it before, you should read through the help and explanations given in the bottom part of this page before you do use it.  Configured properly, it's a safe and convenient tool. You have been brought to this page because one of your SquirrelMail preference items has been automatically converted.  (This is due to a change on this site from using the 'auto_prune_sent' plugin to using the upwardly compatible 'proon' plugin.)  See the entry for the 'Sent' folder in the Folder Table below (scroll down).  Your preferences have already been updated and saved, reflecting the settings as shown.  If you leave things as-is, some messages in your 'Sent' folder may be deleted on future sign-ons to SquirrelMail. You may, of course, change any settings on this page and 'Save All'.  You can return to this page in the future by selecting the 'Pruning...' button (below your list of folders in the left-hand frame) or by selecting a similar link from the 'Options->Folder Preferences' page.  You should not be automatically brought to this page on future logins. Your local SquirrelMail administrator may have specified site settings for one or more options or per-folders items.  In such a case where there is a site setting, it supersedes the user setting (except as noted for particular items below).  Since the site settings are administered separately, your user settings are shown and can be edited even if site settings supersede them.  The site settings, if any, are shown immediately below the corresponding user setting in the User Preferences table and the Folder Table. ^ by Date by Size lowercase, 1,000,000 (the layman's megabytes) lowercase, 1000 (the layman's kilobytes) maximum minimum proon autopruning report same as 'm' uppercase or lowercase, 1 (bytes) uppercase, 1024 (the geek's kilobytes) uppercase, 1024*1024 (the geek's megabytes) yes Project-Id-Version: proon
POT-Creation-Date: 2005-10-24 21:15+0300
PO-Revision-Date: 2007-04-14 11:51+0200
Last-Translator: Rinse de Vries <rinsedevries@kde.nl>
Language-Team: Frisian <squirrelmail-i18n@lists.sourceforge.net>
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
X-Generator: KBabel 1.11.4
 (gjint) 2 oeren 3 en ien tredde oeren 6 en in kwart dagen 6 en in kwart dagen plus 3 en ientredde oeren 6 dagen 6 dagen en 2 oeren <i>Haadlist mei </i>mappen<i> ferfarskje</i> ? In knop wurdt ornaris yn it lofterpaniel fan SquirrelMail setten, ûnder de mappenlist. Sa hawwe jo fluch tagong ta dizze side. As dit fakje selektearre is, sil de knop net yn it lofterpaniel setten wurde. Jo kinne de side noch altyd berikke troch 'Opsjes', 'Mapfoarkarren' en 'Opsjes foar snoeien fan mappen'.  In kwantum-limyt telt it oantal berjochten yn in map. It oantal mei net negatyf wêze. Om feilichheidsredenen wurdt 0 sjoen as 'gjin wearde opjûn'. Oars as de leeftyds- en gruttelimyt is in kwantum-limyt altyd in ienfâldich getal sûnder oanfoljend type of oanfoljende notaasje. In leeftydslimyt is in relative tiidsduer en wurdt opjûn as in kombinaasje fan dagen en oeren. De totale tiidsduer mei net negatyf wêze. Foar de feilichheid wurdt 0 sjoen as 'gjin wearde opjûn'. In ienfâldich getal wurdt sjoen as it oantal dagen. As der in skeane streek (slash) ('<code>/</code>') brûkt wurdt, wurdt it getal nei de skeane streek sjoen as it oantal urn. As dagen en oeren tegearre opjûn wurde, dan wurde se gearfoege. Yn de tabel hjirûnder stean in pear foarbylden. In gruttelimyt telt it oantal bytes yn in map. De grutte mei net negatyf wêze. Om feilichheidsredenen wurdt 0 sjoen as 'gjin wearde opjûn'. In opjûne grutte bestiet út in getal en opsjoneel letterteken as efterheaksel. It efterheaksel jout de te brûken ienheid oan, lykas yn ûndersteande tabel. In getal sûnder efterheaksel krijt automatysk 'm' as ienheid. TINK DEROM ! Aksjeknoppen en wearden per map Derfoar Underoan side TINK DEROM!! Op leeftyd besjen Op grutte besjen Snoeien op kwantum Kwantum-limyt Snoeien op leeftyd Leeftydslimyt Beskriuwing Utskeakele Rapport middels e-mail Ynskeakele Earste Map Mappentabel Map bestiet net. Foar de karantênemap mei mooglike spam, snoei berjochten âlder as 30 dagen fuort, en snoei de map oant in maksimale grutte fan 2 megabyte. Nochris, beskermje net-lêzen berjochten net. Foar in map mei in drukke mailinglist dy't jo allinnich sa no en dan trochrinne, snoei berjochten âlder as in wike fuort, ynklusyf de net-lêzen berjochten. Foar de Konseptenmap, snoei alles âlder as 6 moannen fuort. Want at sa'n berjocht dan noch net ferstjoerd is, sil it der letter ek wol net fan komme. Foar de map mei ferstjoerde items, wiskje berjochten âlder as ien wike, ynklusyf net-lêzen berjochten. Dit giet der fanút dat jo jo map mei Ferstjoerde items net brûke as bewarmap. As jo langer as in wike net de behoefte hân hawwe om eat út dy map werom te heljen (bg. omdat jo fergetten hawwe in kopy derfan op te slaan), dan kin it wiske wurde. Foar de  jiskefetmap, snoei berjochten âlder as 3 dagen fuort. Snoei it jiskefet oant in maksimum grutte fan 500 kilobytes of 20 berjochten. Snoei ek net-lêzen berjochten fuort. Help en útlis Dit binne inkele foarbylden fan frij wênstige ynstellingen. INBOX As neist de oare mappen ek de jiskefetmap snoeid wurdt bepaalt dizze foarkar de folchoarder. 'Earst' betsjut dat de jiskefetmap as earste snoeid wurdt sadat dizze oan de ein fan it snoeien de fuortsnoeide triemmen fan de oare mappen befet. 'Lêst' betsjut dat it jiskefet as lêste snoeid wurdt. Dat betsjut dat berjochten dy't by it snoeien yn it jiskefet smiten binne in twadde snoeibeurt ûndergean. 'Natuerlijk' betsjut dat it jiskefet snoeid wurde sil neffens de natuerlike oardering fan de mappen yn de list. Mei oare wurden, de map krijt gjin spesjale behanneling foar wat de snoeifolchoarder oanbelanget. As der gjin kar makke is, wurdt 'Earst' as standert brûkt. Dizze ynstelling makket yn de praktyk gjin ferskil, of it moat wêze dat 'Snoeien troch jiskefet' selektearre is. As dit útskeakelfakje selektearre is sil it snoeien op berjochtoantal net útfierd wurde. De kwantumlimyt sil foar elke map werjûn wurde, mar kin net bywurke wurde. As der én in side-ynstelling én in brûkers-ynstelling foar de map definiearre is, dan wurdt de lytste fan de twa brûkt. As dit fakje selektearre is sil der in gearfetting fan it automatysk snoeien yn it berjochtenlist-paniel setten wurde. Yn tsjinstelling ta in e-mailnotifikaasje ferskynt der ek in gearfetting as der gjin berjochten fuortsnoeid binne en him gjin fouten foardien hawwe. De on-screen gearfetting hat in wiidweidiger ferzje fan deselde ynformaasje dy't foar de e-mail brûkt wurdt.  As dit karfakje selektearre is, sil der in gearfetting foar it automatysk snoeien as nij berjocht  ferskine yn jo INBOX. Der wurdt gjin gearfetting opsteld as der gjin berjochten fuortsnoeid binne en him gjin fouten foardien hawwe. As dit fakje selektearre is sille berjochten dy't út de oare mappen snoeid binne yn it jiskefet smiten wurde. Berjochten dy't út de jiskefetmap snoeid wurde sille wiske wurde. As dit fakje net selektearre is sille berjochten fuortendaliks wiske wurde. Dizze ynstelling is ûnôfhinklik fan de globale SquirrelMail-ynstelling foar it brûken fan de jiskefetmap by it wiskjen fan berjochten. As dit fakje selektearre is, kin it snoeiproses ek net-ynskreaune mappen besjen. As net-selektearre wurde allinnich ynskreaune mappen besjoen, likefolle oft der hânmjittich of automatysk snoeid wurdt. (Jo kinne noch altyd per map de knoppen 'Effekt toane' en 'No snoeie' brûke.) Dit kin handich wêze as jo net-ynskreaune mappen hawwe wêryn't jo op in manier berjochten ûntfange dy't oars is as hânmjittich foljen. Jo kinne allinnich ynstellingen oan in map taheakje as jo dizze ynskriuwe, teminsten tydlik, mar de ynstellingen foar net-ynskreaune mappen wurde brûkt as dit fakje selektearre is. As dit útskeakelfakje selektearre is sil it snoeien op berjochtleeftyd net útfierd wurde. De leeftydslimyt sil foar elke map werjûn wurde, mar kin net bywurke wurde. As dit útskeakelfakje selektearre is, sil it snoeien op berjochtgrutte net útfierd wurde. De gruttelimyt sil foar elke map werjûn wurde, maar kin net bywurke wurde. As dit item foar in bepaalde map selektearre is, dan sil dy net automatysk snoeid wurde. De map sil allinnich snoeid wurde as jo soks hânmjittich opdrage. Dit dogge jo troch 'Alle mappen snoeie; of 'No snoeie' te selektearjen. Automatysk snoeie betsjut snoeie by it ynlogjen en ek periodyk snoeie (as dy opsje selektearre is). As dit item foar in bepaalde map selektearre is, dan krije net-lêzen berjochten gjin spesjale beskerming tsjin fuortsnoeien. As net selektearre (standert) sil it snoeiproces gjin net-lêzen berjochten út dy map wiskje. Jo kinne yn berie nimme om ta te litten dat net-lêzen berjochten wiske wurde út mappen mei drokke mailinglisten dy't jo net folle lêze of berjochten yn karantêne fanwege mooglike spamynhâld. Wês tige foarsichtich mei de leeftyds-, grutte- en kwantum-limiten dy't jo opjouwe foar mappen mei dit item selektearre. It effekt fan dizze aksje is itselde as automatysk snoeien, met as ferskil dat jo him hânmjittich oanroppe (en der gjin e-mailrapporten opsteld wurde). Dizze aksjeknop is fergelykber mei de aksjeknop 'No snoeie', mei as útsûndering dat de folsleine mappenlist (en de individuele ynstellingen per map) brûkt wurde. Mappen sûnder in opjûne limyt wurde stilswijend oerslein. As inkele mappen foute wearden hawwe sil der in foutmelding foar toand wurde, mar oare (net-foute) mappen wurde wol snoeid. Item Lêste Snoeiknop yn lofterpaniel Allinnich hânmjittich Berjochten (fuortsnoeid): Berjochten (noch fuort te snoeien): Berjochten automatysk fuortsnoeid: Natuerlik Net ien fan de limytwearden is foar dizze map ynsteld. Net-besteande mappen Rapport op it skerm Opsjes foar it snoeien fan mappen Gewoanwei wurdt der snoeid op it momint dat jo ynlogje by SquirrelMail. As jo wolle dat dit minder faak dien wurdt kinne jo hjir in getal opjaan. Bygelyks de wearde 3 betsjut 'elke tredde kear dat ynlogge wurdt'. As jo gjin wearde, of de wearde 0, opjouwe sil der by elke login snoeid wurde. Jo sidebehearder fan SquirrelMail kin in maksimumwearde opjûn hawwe foar it snoeien by ynlogjen. Dizze sil tapast wurde as dy in legere snoeifrekwinsje brûkt. Probleem mei ' Alle mappen snoeie No snoeie Snoeien middels jiskefet Snoeid Snoeie... It snoeien kin hânmjittich fan dizze side ôf útfierd wurde of periodyk en automatysk. Dit item bepaalt de weromkomende tiidsperioade. De opmak is itselde as foar de leeftydslimiten foar individuele mappen. As jo neat opjouwe sil der gjin automatysk/periodyk snoeien barre. Jo kinne dit fjild dus sjen as in oan/útskeakelder foar it automatysk snoeien. Om feilichheidsredenen wurdt 0 sjoen as 'gjin wearde opjûn'. Jo SquirrelMail-systeembehearder kin in minimaal snoei-ynterfal opjûn hawwe. As dizze leger is as dy fan josels, sil dy brûkt wurde. It weromkom-ynterfal wurdt mjitten fan it momint fan ynlogjen by SquirrelMail ôf. It automatysk opskjinjen bart dus op de opjûne ynterfals dernei. It eigentlike snoeien bart by it ferfarskjen fan it skerm, dus yn in ynaktive SquirrelMail-sesje sil net snoeid wurde. Weromkom-ynterfal foar snoeien Oerbleaun Itselde as wyt Alles opslaan Stel in weromkommend snoei-ynterfal fan 24 oeren yn, foar it gefal dat jo langere tiid ynlogge bliuwe. Ynstelling Alle effekten toane Effekt toane Frekwinsje fan snoeien by ynlogjen Side-ynstelling Snoeien op grutte Limytgrutte Snoeifolchoarder foar grutte en kwantum Inkele mappen binne net snoeid fanwege ferkearde leeftyd-, grutte- of kwantum-limiten of mooglike oare problemen. Sjoch de mappenlist hjirûnder foar details. De mappen dy't gjin problemen joegen binne WOL snoeid. Ynskreaune mappen De limyt is ferkeard formulearre. De leeftydlimyt is ferkeard formulearre. De folgjende tabel beskriuwt brûker-foarkarren dy't ynfloed hawwe kinne op hoe't it snoeien wol/net foar jo dien wurdt. It gedrach kin wizige wurde of beheind troch side-ynstellingen dy't troch jo systeembehearder opjûn binne. De beskriuwingen binne yn deselde folchoarder as it formulier foar brûker-foarkarren hjirboppe. De gruttelimyt is ferkeard formulearre. Dizze aksjeknop snoeit fuortendaliks de byhearrende map. It oantal berjochten dat fuortsnoeid is sil werjûn wurde. As der net teminsten ien limyt foar de map oanjûn is sil in foutmelding toand wurde. Der wurde dan gjin berjochten wiske. Dizze aksjeknop is te fergelykjen mei de aksjeknop 'Effekt toane', mei as ferskil dat de folsleine mappenlist (en de individuele ynstellingen per map) brûkt wurdt. Mappen dy't gjin inkele limyt ynsteld hawwe wurde stilswijend oerslein. De oantallen foar de jiskefetmap binne ynklusyf berjochten dy't yn it jiskefet smiten wurde sille as resultaat fan it snoeien fan oare mappen. Dizze aksjeknop slaat alle brûkersfoarkarren en per-map-ynstellingen op. As der  fouten fûn binne yn dizze foarkarren en ynstellingen sil der net opslein wurde. Om jo fan tsjinst te wêzen hat de knop in oar uterlik at der bekende ferskillen binne tusken de wearden op dizze side en de wearden dy't yn it ferline opslein binne. Dat is lykwols allinnich sa as de side opnij laden is nei ien fan de aksjeknoppen. It knoputerlik wurdt net dynamysk bywurke as jo wearden op de side wizigje. Dizze aksjeknop simulearret it snoeien fan de byhearrende map. It oantal berjochten dat fuortsnoeid wêze soe wurdt dan werjûn. As der net teminsten ien limyt foar dy map opjûn, is sil der in foutmelding ferskine. Der is in útlis oanwêzich foar de brûkers-foarkarren en per-map-gegevens dy't it automatysk snoeien fan mappen selektyf bestjoere. Snoeien betsjut it wiskjen fan berjochten omdat se óf âlder binne as in bepaalde leeftyd óf om de grutte fan in map te ferlytsjen ta in bepaalde grutte of bepaald oantal berjochten. <ul><li>Snoeien besjocht earst de berjochtdatums (as der in brûker-definiearre leeftydslimyt foar dy map opjûn  is). De datum fan in berjocht is it momint wêrop it ûntfongen is troch de mailtsjinner (dizze saneamde 'ynterne datum' wurdt behâlden as jo berjochten tusken mappen ferpleatse). Berjochten wurde wiske as se in  ynterne datum hawwe dy't âlder is as de leeftyd dy't troch leeftydslimyt bepaald wurdt. </li><li>It snoeien besjocht dêrnei de totale grutte fan de map (as der in brûker-definiearre gruttelimyt opjûn is). As de map de maksimale grutte oerskriuwt wurde der safolle oerstallige berjochten wiske oant de map wer op of ûnder de limyt sit.</li><li>It snoeien besjocht ek noch it oantal berjochten yn in map (as der in brûker-definiearre grutte-limyt opjûn is). As der mear berjochten yn de map sitte as de oanjûne limyt, dan wurde safolle oerstallige berjochten wiske oant de map wer op of ûnder de limyt sit. </li></ul><p>Yn al dizze gefallen wurde net-lêzen berjochten beskerme en net fuortsnoeid. Dizze beskerming kin per map wiske wurde. It snoeigedrach kin fleksibel ynsteld wurde mei help fan ferskate oare brûkers-foarkarren. Dy wurde hjirûnder wiidweidiger beskreaun. Utskreaune en net-besteande mappen wurde werjûn as der in brûkers-foarkar of site-foarkar foar dy map opjûn is. Dit om foar te kommen dat jo ûnaangenaam ferrast wurde as jo bg. in map mei dy namme brûken gean en jo te let yn'e gaten krije dat dêrmei it snoeien aktivearre is. Dizze opsjesside is ornaris opboud mei help fan de kleuren fan it SquirrelMail-tema dat jo útsocht hawwe. Lykwols, by guon tema's wurde ûnderdielen fan dizze side minder lêsber. As dit fakje selektearre is sil de opsjesside opboud wurde sûnder de measte kleuren. Dizze side makket it mooglik om út inkele of alle mappen berjochten automatysk te wiskjen (fuortsnoeie) middels de troch jo stelde kriteria. Jo kinne fan dizze side ôf berjochten hânmjittich fuortsnoeie, of jo kinne se automatysk fuortsnoeie litte by it ynlogjen en om de safolle tiid. Eardat jo automatysk snoeien brûke is it in goed idee om jo ynstellingen earst hânmjittich op dizze side te testen sadat jo wis binne dat se dogge wat jo wolle. Automatysk snoeien is aktivearre at jo in geskikte wearde foar de opsje 'Ynterfal foar iderkear wer snoeie' opjûn hawwe. It snoeien by ynlogjen wurdt lykwols ek dien as jo hjrfoar gjin wearde opjûn hawwe. Folchoarder foar snoeien middels jiskefet Behalven at jo op in 'Snoeie...' link klikt hawwe, binne jo automatysk nei dizze side brocht omdat jo side in SquirrelMail-plugin ynstallearre hat dêr't jo automatysk jo mappen mei snoeie kinne. Standert sil der by jo net automatysk snoeid wurde. Ynklusyf net-lêzen Net-ynskreaune mappen Temakleuren brûke Brûkers-foarkarren Wearden binne NET opslein fanwege in probleem yn ien of mear fjilden. Der binne twa mooglike folchoarders foar it besjen hokker berjochten fuortsnoeid wurde sille, op basis fan leeftyd en/of oantal. Der kin op leeftyd besjoen wurde, wêrby berjochten fuortsnoeid wurde fan de âldste oant de nijste, oant de limyt foar it oantal berjochten berikt is. Of se kinne besjoen wurde op grutte, wêrby berjochten fuortsnoeid wurde fan grutste nei lytste oant de limyt foar berjochtgrutte of berjochtoantal berikt is. As net ien fan beiden selektearre is, giet it selektearjen standert op datum. By ferkearde ynstellingen kin dit helpmiddel yn in sucht in hiele protte berjochten wiskje. As jo it noch nea earder brûkt hawwe, lês dan goed de dokumintaasje troch dy't ûnderoan dizze side stiet, foardat jo it tapasse. By goed ynstellen is it in feilich en handich helpmiddel. Jo binne nei dizze side tabrocht omdat ien fan jo SquirrelMail-foarkarren automatysk omsetten is. (Dit is dien fanwege in opwurdearring fan de plugin 'auto_prune_sent' nei de plugin 'proon', dy't kompetibel mei de foarrige is.). Sjoch it item foar de map 'Ferstjoerd' yn de mappentabel hjirûnder (sko omleech). Jo foarkarren binne al bywurke en opslein, mei de toande ynstellingen as risseltaat. As jo alles litte sa't it is, dan kinne inkele berjochten yn jo Ferstjoerd-map wiske wurde as jo yn'e takomst ynlogje by SquirrelMail. Uteraard kinne jo ynstellingen op dizze side wizigje en 'alles opslaan'. Jo kinne yn'e takomst weromgean nei dizze side troch op de knop 'Snoeien...' te klikken (dizze stiet ûnder jo list mei mappen yn it lofter kader) of troch in fergelykbere link te selektearjen op de side 'Ynstellingen->Mappenfoarkarren'. By takomstige logins sille jo net mear nei dizze side laat wurde. Jo SquirrelMail-systeembehearder kin side-ynstellingen opjûn hawwe foar ien of mear opsjes of per-map-items. As der sa in side-ynstelling oanmakke is, dan wurdt dy brûkt ynstee fan de brûkers-ynstelling (útsein bepaalde items hjirûnder). Omdat dizze ynstellingen apart beheard wurde kinne jo jo brûkers-ynstellingen sjen en wizigje, ek as der in side-ynstelling foar bestiet dy't se oerstallich makket. De side-ynstellingen, as dy der binne, wurde fuortendaliks toand ûnder de byhearrende brûkers-ynstellingen yn de tabel foar brûkers-foarkarren en de mappentabel. ^ op leeftyd op grutte lytse letters, 1000.000 (megabytes foar de gewoane man) lytse letters, 1000 (kilobytes foar de gewoane man) maksimum minimum Rapport foar automatysk snoeie (proon) itselde as 'm' haad- of lytse letters, 1 (bytes) haadletters, 1024 (kilobytes foar geeks) haadletters, 1024*1024 (megabytes foar geeks) ja 