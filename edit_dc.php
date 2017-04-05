<?php
session_start();
require_once 'common.php';
require_once 'common_js.php';

//print_r($_POST);
//////////////
// Every body who can login and belong to same department can edit it
//////////////


function echo_csv($csv)
{
	$ex=explode(',',$csv);
	foreach ($ex as $v)
	{
		echo $v.'<br>';
	}	
}

function edit_pt($link,$pt)
{
	$id=$pt['ipd'];
	
	echo '<table><tr><td>';

	echo 	'<div onclick="hide(\'spn\')" id=response></div>';
	echo 	'<table border=1>
			<tr><th colspan=2>New Civil Hospital Majura Gate Surat<br>Discharge Card<br>'.$pt['department'].'</th>
			<th style="width:3cm;height:3cm;">';
	echo_csv($pt['clinician']);

	echo '</th></tr>';
	echo	'<tr>';
	echo 		'<td><input id=mrd	value=\''.$pt['mrd'].'\' 
							onchange="do_work(\''.$id.'\',this)" 
							type=text placeholder=mrd></td>';
	echo 		'<td><input id=name	value=\''.$pt['name'].'\' 
							onchange="do_work(\''.$id.'\',this)" 
							type=text placeholder=name></td>';	
	echo 		'<td>IPD:'.$pt['ipd'].'</td>';
	echo 	'</tr>';
	echo 	'<tr>';
	echo 		'<td>M:<input id=mobile value=\''.$pt['mobile'].'\' 
						onchange="do_work(\''.$id.'\',this)" 
						type=text placeholder="mobile/phone"></td>';
	echo 		'<td>Age:<input id=age size=5 value=\''.$pt['age'].'\' 
						onchange="do_work(\''.$id.'\',this)" 
						type=text placeholder="age"></td>';
						
				$sex=array('','M','F','O');
	echo 		'<td>Sex:';
						mk_select_from_array_ajax($id,$sex,'sex','',$pt['sex']);
	echo 		'BG';
						mk_select_from_table_ajax($id,$link,'bloodgroup','',$pt['bloodgroup']);
	echo 		'</td>';
	echo 		'</tr><tr>';
	
	//removed to use user department and unit
	//echo 		'<td>';
	//					mk_select_from_table_ajax($id,$link,'department','',$pt['department']);
	//echo 		'</td>';
	
	echo 		'<td>Dept:'.$pt['department'].'</td>';
		
	//echo 		'<td>Unit:';
	//					mk_select_from_table_ajax($id,$link,'unit','',$pt['unit']);
	//echo 		'</td>';
	
		echo 		'<td>Unit:'.$pt['unit'].'</td>';

	echo 		'<td>';
						mk_select_from_table_ajax($id,$link,'location','',$pt['location']);
	echo 		'</td>';
	echo 	'</tr>';
	echo 		'</tr><tr>';
	echo 		'<td>';
						mk_select_from_table_ajax($id,$link,'clinician','',$pt['clinician'],200);
	echo 		'</td>';
	echo 		'<td colspan=2>&#916<input style="width:95%;" id=diagnosis value=\''.$pt['diagnosis'].'\' 
						onchange="do_work(\''.$id.'\',this)" 
						type=text placeholder="diagnosis"></td>';
	echo 	'</tr>';

	echo 	'<tr>';
	echo 		'</td>';
	echo 		'<td>DOA:
						<input size=10 type=text readonly
							class=datepicker  
							id=doa
							onchange="do_work(\''.$id.'\',this);"
							value=\''.mysql_to_india_date($pt['doa']).'\' >';
	echo	'</td>';
	echo 		'<td>DOO:
						<input size=10 type=text readonly
							class=datepicker 
							id=doo
							onchange="do_work(\''.$id.'\',this);"
							value=\''.mysql_to_india_date($pt['doo']).'\' >';
	echo	'</td>';
	echo 		'<td>DOD:
						<input size=10 type=text readonly
							class=datepicker 
							id=dod
							onchange="do_work(\''.$id.'\',this);"
							value=\''.mysql_to_india_date($pt['dod']).'\' >';
	//echo	'</td>';
	
	//echo 		'<td>';
	echo 'Type:';
						mk_select_from_table_ajax($id,$link,'discharge_type','',$pt['discharge_type'],140);
	echo 		'</td>';
	
	echo 	'</tr>';
	echo	'<tr><td>';
	echo 		'LCDC:<input size=8  id=LCDC_no	value=\''.$pt['LCDC_no'].'\' 
							onchange="do_work(\''.$id.'\',this)" 
							type=text placeholder=LCDC_no>
				</td>';	
	echo 		'<td>HPE:<input id=HPE_no	size=10 value=\''.$pt['HPE_no'].'\' 
							onchange="do_work(\''.$id.'\',this)" 
							type=text placeholder=HPE_no></td>';
	echo 		'<td>MLC:<input id=MLC_no	value=\''.$pt['MLC_no'].'\' 
							onchange="do_work(\''.$id.'\',this)" 
							type=text placeholder=MLC_no size=10></td>';
	echo 	'</tr>';
	echo	'<tr>';
	echo 		'<td colspan=3>Complains:<br><textarea cols=85 id=complains	
							onchange="do_work(\''.$id.'\',this)" 
							>',$pt['complains'].'</textarea></td>';	
	echo 	'</tr>';


	//$ar=array('Hb', 'Platelet', 'TC', 'DC', 'Hematocrit', 'Creatinine', 'Sodium', 'Potassium', 'Glucose', );

	//$counter=0;
	
	/*
	foreach ($ar as $value)
	{
		if($counter%3==0){echo '<tr>';}
		echo 		'<td><b>'.$value.'</b><input type=text size=10 id=\''.$value.'\'	
							value=\''.$pt[$value].'\' onchange="do_work(\''.$id.'\',this)" ></td>';	
		if($counter%3==2){echo '</tr>';}
		$counter++;	
	}
	*/
	
	$ar=array('pus_culture', 'urine_culture', 'Urine_microscopy','Hb', 'Platelet', 'TC', 'DC', 'Hematocrit', 'Creatinine', 'Sodium', 'Potassium', 'Glucose');

	$counter=0;
	foreach ($ar as $value)
	{
		if($counter%3==0){echo '<tr>';}
		echo 		'<td><b>'.$value.'</b></b><br><textarea style="width:100%;height:100%;" rows=1 id=\''.$value.'\'	
							onchange="do_work(\''.$id.'\',this)" 
							>',$pt[$value].'</textarea></td>';	
		if($counter%3==2){echo '</tr>';}
		$counter++;	
	}

	$ar=array('other_laboratory','x_ray', 'USG', 'ECG', 'reference', 'OT', 'treatment_in_ward', 'condition_on_discharge', 'advise_on_discharge', 'followup');

	foreach ($ar as $value)
	{
		echo '<tr>';
		echo 		'<td colspan=3><b>'.$value.'</b><br><textarea cols=90 id=\''.$value.'\'	
							onchange="do_work(\''.$id.'\',this)" 
							>',$pt[$value].'</textarea></td>';	
		echo '</tr>';
	}
				
	echo 	'</table>';
}


function display_pt($pt)
{
	$id=$pt['ipd'];	
	echo 	'<div onclick="hide(\'spn\')" id=response></div>';
	echo 	'<div style="width:200mm;">';
	echo 	'<table border=1>';

	echo '		<tr><th colspan=2>New Civil Hospital Majura Gate Surat<br>Discharge Card<br>'.$pt['department'].'</th>
			<th style="width:3cm;height:3cm;">';
	echo_csv($pt['clinician']);

	echo '</th></tr>';

	echo	'<tr>';
	echo 		'<td>'.$pt['mrd'].'</td>';
	echo 		'<td>'.$pt['name'].'</td>';	



							
	echo 		'<td>IDP:'.$pt['ipd'].'</td>';
	echo 	'</tr>';


							
	echo 	'<tr>';
	echo 		'<td>M:'.$pt['mobile'].'</td>';
	echo 		'<td colspan=2 >Age:'.$pt['age'];
						
	echo 		'  Sex:'.$pt['sex'];
	echo 		'  Blood Group:'.$pt['bloodgroup'];
	echo 		'</td>';
	echo 		'</tr><tr>';
	echo 		'<td>Dept:'.$pt['department'].'</td>';
	echo 		'<td>Unit:'.$pt['unit'];
	echo 		'</td>';
	echo 		'<td>'.$pt['location'];
	echo 		'</td>';
	echo 	'</tr>';
	echo 		'</tr><tr>';
	echo 		'<td colspan=3>Diagnosis:'.htmlspecialchars($pt['diagnosis']).'</td>';
	echo 	'</tr>';

	echo 	'<tr>';
	echo 		'<td>DOA:'.mysql_to_india_date($pt['doa']).'</td>';
	echo 		'<td>DOO:'.mysql_to_india_date($pt['doo']).'</td>';
	echo 		'<td>DOD:'.mysql_to_india_date($pt['dod']).'';
	echo		'<br>Type:'.$pt['discharge_type'];
	echo 		'</td>';
	echo 	'</tr>';
	echo	'<tr><td>';
	echo 		'LCDC:'.$pt['LCDC_no'].'</td>';	
	echo 		'<td>HPE:'.$pt['HPE_no'].'</td>';	
	echo 		'<td>MLC:'.$pt['MLC_no'].'</td>';	

	echo 	'</tr>';
	echo	'<tr>';
	echo 		'<td colspan=3><b>Complains:</b>';
	echo 	htmlspecialchars($pt['complains']).'</td>';	
	echo 	'</tr>';


	$ar=array('Hb', 'Platelet', 'TC', 'DC', 'Hematocrit', 'Creatinine', 'Sodium', 'Potassium', 'Glucose', );

	$counter=0;
	foreach ($ar as $value)
	{
		if($counter%3==0){echo '<tr>';}
		echo 		'<td width=33%><b>'.$value.'</b>: '.htmlspecialchars($pt[$value]).'</td>';	
		if($counter%3==2){echo '</tr>';}
		$counter++;	
	}

	$ar=array('pus_culture', 'urine_culture', 'Urine_microscopy');

	$counter=0;
	foreach ($ar as $value)
	{
		if($counter%3==0){echo '<tr>';}
		echo 		'<td width=33%><b>'.$value.'</b>:<pre>'.htmlspecialchars($pt[$value]).'</pre></td>';	
		if($counter%3==2){echo '</tr>';}
		$counter++;	
	}

	$ar=array('other_laboratory','x_ray', 'USG', 'ECG', 'reference', 'OT', 'treatment_in_ward', 'condition_on_discharge', 'advise_on_discharge', 'followup');

	foreach ($ar as $value)
	{
		echo '<tr>';
		echo 		'<td colspan=3><b>'.$value.':</b><pre>'.htmlspecialchars($pt[$value]).'</pre></td>';	
		echo '</tr>';
	}


	echo 	'</table></div>';
	
	
}

function copy_prototype($pr,$ipd)
{

	
}
/////////////Main script start from here//////////////

$link=connect();
$u=get_user_info($link);

if(isset($_POST['id']))
{
	//for lock unlock, which need to change display in toto, so no ajax used. activated with button
	if(isset($_POST['field']) && isset($_POST['value']))
	{
		update_or_insert_field_by_id($link,'pt','ipd',$_POST['id'],$_POST['field'],
								mysqli_real_escape_string($link,$_POST['value']));
	}
	
	//try to find a patient							
	$pt=get_raw($link,'select * from pt where ipd=\''.$_POST['id'].'\'');

	if(isset($_POST['prototype']))
	{
		$pr=get_raw($link,'select * from pt where ipd=\''.$_POST['prototype'].'\'');
	}
	
	//if no such patient exist, insert new. called when id returned by new_dc.php
	if($pt===FALSE)
	{
		if(strlen($_POST['id'])>0)
		{
			//insert ID 
			$id=insert_id($link,'pt','ipd',$_POST['id']);
			//update department and unit to enable edit of only-own-department-own-unit
			update_field_by_id($link,'pt','ipd',$_POST['id'],'department',$u['department']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'unit',$u['unit']);
			//set lock to 0 for initial insertion
			update_field_by_id($link,'pt','ipd',$_POST['id'],'lock','0');
			////////////Copy from prototype
			update_field_by_id($link,'pt','ipd',$_POST['id'],'diagnosis',$pr['diagnosis']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'complains',$pr['complains']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'pus_culture',$pr['pus_culture']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'urine_culture',$pr['urine_culture']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'Urine_microscopy',$pr['Urine_microscopy']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'x_ray',$pr['x_ray']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'USG',$pr['USG']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'ECG',$pr['ECG']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'OT',$pr['OT']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'treatment_in_ward',$pr['treatment_in_ward']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'condition_on_discharge',$pr['condition_on_discharge']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'advise_on_discharge',$pr['advise_on_discharge']);
			update_field_by_id($link,'pt','ipd',$_POST['id'],'followup',$pr['followup']);
			////////////end of copy from prototype
				/*

 `diagnosis` varchar(100) NOT NULL,
 `complains` varchar(500) NOT NULL,
 `pus_culture` varchar(100) NOT NULL,
 `urine_culture` varchar(100) NOT NULL,
 `Urine_microscopy` varchar(100) NOT NULL,
 `x_ray` varchar(300) NOT NULL,
 `USG` varchar(300) NOT NULL,
 `ECG` varchar(300) NOT NULL,
 `OT` varchar(2000) NOT NULL,
 `treatment_in_ward` varchar(1000) NOT NULL,
 `condition_on_discharge` varchar(1000) NOT NULL,
 `advise_on_discharge` varchar(500) NOT NULL,
 `followup` varchar(500) NOT NULL,
  
	 */
			
			
			//reread again
			$pt=get_raw($link,'select * from pt where ipd=\''.$_POST['id'].'\'');
		}
		else
		{
			menu();
			echo '<h3>No IPD number given</h3>';
			exit(0);
		}
	}
	else
	{

	}
}
else  //cannot edit if no id provided
{
	echo '<h3>No IPD number given</h3>';
}
//////////////

menu();

//PART-1 button management
//if locked show print button
//if locked and right=1 and same-dept-unit show unlock button
echo '<form method=post>';
echo '<input type=hidden readonly name=id value=\''.$pt['ipd'].'\'>';
if($pt['lock']==1)
{
	//echo '<h3 style="color:red;">Locked, Approved, Can be printed</h3>';
	echo '<input type=submit  formtarget=_blank formaction=print_dc.php name=action value=print>';
	if($u['right']==1 && $pt['department']==$u['department']  && $pt['unit']==$u['unit'])
	{
		echo '<button type=submit name=value value=0>Unlock</button>';
		echo '<input type=hidden readonly name=field value=lock>';
	}
	if($u['right']==2 && $pt['department']==$u['department'] )
	{
		echo '<button type=submit name=value value=0>Unlock</button>';
		echo '<input type=hidden readonly name=field value=lock>';
	}
}
//if not locked, show save button, lock button with field=>value pair
//but, only if dept and unit match. in which case save have no effect and Lock is not allowed
else
{
	if($pt['department']==$u['department']  && $pt['unit']==$u['unit'])
	{
		echo '<input type=submit  formaction=edit_dc.php name=action value=save>';	//fake button to to issue save
		echo '<button type=submit name=value value=1>Lock</button>';
		echo '<input type=hidden readonly name=field value=lock>';
	}
}

echo '</form>';

//PART-2 discharge form management		
if($pt['lock']==1)
{
	display_pt($pt);
}
else
{
	if($pt['department']==$u['department']  && $pt['unit']==$u['unit'])
	{
		edit_pt($link,$pt);
	}
	else
	{
		display_pt($pt);
	}
}

?>
