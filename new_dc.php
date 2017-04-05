<?php
session_start();
require_once 'common.php';
require_once 'common_js.php';
	
//////////////
$link=connect();

function get_prototype($link)
{
	$sql='select ipd,diagnosis from pt
					where ipd like \'PROTOTYPE%\'
					order by ipd';

	if(!$result=mysqli_query($link,$sql)){echo mysqli_error($link);return FALSE;}
	echo '<select name=prototype>';
	while($ar=mysqli_fetch_assoc($result))
	{
	echo '<option value=\''.$ar['ipd'].'\'>'.$ar['ipd'].'-'.$ar['diagnosis'].'</option>';
	}
	echo '</select>';
}

menu();
echo '<form method=post action=edit_dc.php><table border=1>';
echo '<tr><th colspan=3 >IPD Number will be unique to identify the patient</th></tr>';
echo '<tr><th colspan=3 >Write patient IPD number to prepare new Discharge card</th></tr>';
echo	'<tr>';
echo 		'<td>IPD:</td><td><input size=15 name=id  type=text placeholder="(IPD) indoor number"></td>';
echo 	'</tr>';
echo	'<tr>';
echo 		'<td>Prototype:</td><td>';
				$sql='select ipd,concate(ipd,\'-\',diagnosis) from pt where ipd like \'PROTOTYPE%\'';
				get_prototype($link);
echo 		'</td>';
echo 	'</tr>';
echo	'<tr>';
echo 		'<td></td><td><input type=submit name=action value=new_discharge_card></td>';
echo 	'</tr>';
echo '<tr><th colspan=3 >If IPD number exist in database, its details will be displayed</th></tr>';
echo 	'</table></form>';

echo '<table class=border style="background-color:lightblue;">
<tr><th>Note</th>
</tr><tr>
<td>If you wish to separate Operated from Non-Operated patients,<br> 
write a specific word in operative notes (e.g OT) and search for it in OT field during search</td>
</tr><tr><td>In non-operated patient keep OT field empty</td></tr>
<tr><th>New Feature Added</th></tr>
<tr><td>Select prototype from the dropdown menu</td></tr>
<tr><td>Details of prototype will be copied to new patient</td></tr>
<tr><td>To add new prototypes just write Dummy pateint entry with IPD number PROTOTYPEXXX</td></tr>
<tr><td>PROTOTYPE000 is blank</td></tr>
<tr><td>For example to prepare a TUR Prostate case create a dummy case with IPD PROTOTYPE012</td></tr>
<table>';

?>
