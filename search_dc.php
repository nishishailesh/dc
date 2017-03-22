<?php
session_start();

require_once 'common.php';
require_once 'common_js.php';

echo '<html><head>';
		

echo '</head>';	
echo '<body>';

/////////////////////////////////


function search_patient($link)
{
echo '<form method=post>';

echo '<table class=border style="background:lightgray;" align=center>
<tr><th colspan=6>New Civil Hospital Surat</th></tr>
<tr><th  colspan=6>Discharge Card<br>(For clinicians only)</th></tr>';

echo 	'<tr>';
echo 		'<td>MRD</td><td><input type=text name=mrd ></td>';
echo 		'<td>Name</td><td><input type=text name=name ></td>';
echo 		'<td>IPD</td><td><input type=text name=ipd ></td>';
echo 	'</tr>';

echo 	'<tr>';
echo 		'<td>Dept</td><td>';
					mk_select_from_table($link,'department','','');
echo 		'</td>';
echo 		'<td>Unit</td><td>';
					mk_select_from_table($link,'unit','','');
echo 		'</td>';
echo 		'<td>Location</td><td>';
					mk_select_from_table($link,'location','','');
echo 		'</td>';
echo 	'</tr>';
echo	'<tr>';
echo 		'<td>clinicians:</td><td colspan=5>';
					mk_select_from_table($link,'clinician','',200);
echo 		'</td></tr><tr>';
echo 		'<td>Diagnosis:</td>';

echo 		'<td colspan=5><input style="width:95%;" name=diagnosis
					type=text"></td>';
echo 	'</tr>';


echo 	'<tr>';
echo 		'<td>DOA</td><td>
					<input size=10 type=text
						name=doa id=doa
						 >';
echo	'</td>';
echo 		'<td>DOO</td><td>
					<input size=10 type=text 
						name=doo id=doo
						 >';
echo	'</td>';
echo 		'<td>DOD</td><td>
					<input size=10 type=text 
						name=dod id=dod
						 >';
echo	'</td>';
echo 	'</tr>';




echo 		'</tr>';


echo	'<tr><td>';
echo 		'LCDC</td><td><input size=8  name=LCDC_no	
						type=text placeholder=LCDC_no>
			</td>';	
echo 		'<td>HPE</td><td><input name=HPE_no	size=10 placeholder=HPE_no></td>';
echo 		'<td>MLC</td><td><input name=MLC_no 
						type=text placeholder=MLC_no size=10></td>';
echo 	'</tr>';
echo 	'<tr><td>OT<td colspan=10><input type=text name=OT placeholder="Write word to find"></td></tr>';
echo 	'<tr><td align=center colspan=6><input type=submit  name=action value=search></td></tr>';	
echo 	'</table>';

echo '<table class=border style="background-color:lightblue;"><tr>
<td>If you wish to separate Operated from Non-Operated patients, write a specific word in operative notes (e.g OT) and search for it in OT field above</td>
</tr><tr><td>In non-operated patient keep OT field empty</td></tr>
<table>';

echo '</form>';
	
}

function copy_non_empty_element($post)
{
	$ret=array();
	foreach($post as $key=>$value)
	{
		if(strlen($value)>0 && $key!='action')
		{
			//if($key=='doa' || $key=='doo' ||$key=='dod' )
			//{
			//	$ret[$key]=india_to_mysql_date($value);
			//}
			//else
			//{
				$ret[$key]=$value;
			//}
		}
	}
	return $ret;
}

$link=connect();
menu();
search_patient($link);
$u=get_user_info($link);
if(isset($_POST['action']))
{
	if($_POST['action']=='search')
	{
		$cond=copy_non_empty_element($_POST);
		$wr=prepare_where_like($cond);
		if(strlen($wr)>0)
		{
			if($u['right']<2)
			{
				$wr1=' and department=\''.$u['department'].'\' and unit=\''.$u['unit'].'\' ';
			}
			elseif($u['right']==2)
			{
				$wr1=' and department=\''.$u['department'].'\' ';
			}
			$str='select * from pt '.$wr.$wr1 ;
			//echo $str;
			//export_to_csv($str,$link);
			
			echo '<form method=post><button formtarget=_blank name=str value=\''.base64_encode($str).'\' formaction=export.php>Export</button></form>';

			view_data_sql($link,$str,'ipd','edit_dc.php');
			
		}
	}
}
//echo '<pre>';print_r($_POST);echo '</pre>';

echo '</body></html>';


?>
