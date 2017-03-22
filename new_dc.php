<?php
session_start();
require_once 'common.php';
require_once 'common_js.php';
	
//////////////
$link=connect();

menu();
echo '<form method=post action=edit_dc.php><table border=1>';
echo '<tr><th colspan=3 >IPD Number will be unique to identify the patient</th></tr>';
echo '<tr><th colspan=3 >Write patient IPD number to prepare new Discharge card</th></tr>';
echo	'<tr>';
echo 		'<td>IPD:</td><td><input size=15 name=id  type=text placeholder="(IPD) indoor number"></td>';
//echo 	'</tr>';
//echo	'<tr>';
echo 		'<td><input type=submit name=action value=new_discharge_card></td>';
echo 	'</tr>';
echo '<tr><th colspan=3 >If IPD number exist in database, its details will be displayed</th></tr>';
echo 	'</table></form>';

echo '<table class=border style="background-color:lightblue;">
<tr><th>Note</th>
</tr><tr>
<td>If you wish to separate Operated from Non-Operated patients, write a specific word in operative notes (e.g OT) and search for it in OT field during search</td>
</tr><tr><td>In non-operated patient keep OT field empty</td></tr>
<table>';

?>
