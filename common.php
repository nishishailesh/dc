<?php

require_once '/var/gmcs_config/staff.conf';


function login_varify()
{
	return mysqli_connect('127.0.0.1',$GLOBALS['main_user'],$GLOBALS['main_pass']);
}



/////////////////////////////////
function select_database($link)
{
	return mysqli_select_db($link,'dc');
}


function check_user($link,$u,$p)
{
	$sql='select * from user where id=\''.$u.'\'';
	if(!$result=mysqli_query($link,$sql)){return FALSE;}
	$result_array=mysqli_fetch_assoc($result);
	if(md5($p)==$result_array['password'])
	{
		return true;
	}
	else
	{
		return false;
	}
}



function logout()
{
	session_start(); //Start the current session
	session_destroy(); //Destroy it! So we are logged out now
	header("location:".$GLOBALS['rootpath']."/common/index.php"); //configure absolute path of this file for access from anywhere
}
///////////////////////////////////
function connect()
{
	if(!$link=login_varify())
	{
		echo 'database login could not be verified<br>';
	
		exit();
	}


	if(!select_database($link))
	{
		echo 'database could not be selected<br>';
	
		exit();
	}
	
	if(!check_user($link,$_SESSION['login'],$_SESSION['password']))
	{
		echo 'application user could not be varified<br>';
		
		exit();
	}
	
return $link;
}

function mk_select_from_table($link,$field,$disabled,$default)
{
	$sql='select `'.$field.'` from '.$field;
	if(!$result=mysqli_query($link,$sql)){return FALSE;}
	
		echo '<select  '.$disabled.' name='.$field.'>';
		while($result_array=mysqli_fetch_assoc($result))
		{
		if($result_array[$field]==$default)
		{
			echo '<option selected  > '.$result_array[$field].' </option>';
		}
		else
			{
				echo '<option  > '.$result_array[$field].' </option>';
			}
		}
		echo '</select>';	
		return TRUE;
}

function mk_select_from_table_ajax($id,$link,$field,$disabled,$default,$size='')
{
	$sql='select `'.$field.'` from '.$field;
	//echo $sql;
	if(!$result=mysqli_query($link,$sql)){return FALSE;}
	
		echo '<select style="width:'.$size.'px;" '.$disabled.' name=\''.$field.'\'  id=\''.$field.'\' onchange="do_work(\''.$id.'\',this)"  >';
		while($result_array=mysqli_fetch_assoc($result))
		{
		if($result_array[$field]==$default)
		{
			echo '<option selected  value=\''.htmlspecialchars($result_array[$field]).'\'> '.$result_array[$field].' </option>';
		}
		else
			{
			echo '<option value=\''.htmlspecialchars($result_array[$field]).'\'> '.$result_array[$field].' </option>';
			}
		}
		echo '</select>';	
		return TRUE;
}

function mk_select_from_sql($link,$sql,$field_name,$form_name,$disabled,$default)
{

	if(!$result=mysqli_query($link,$sql)){return FALSE;}
	
		echo '<select  '.$disabled.' name='.$form_name.' id='.$form_name.'>';
		while($result_array=mysqli_fetch_assoc($result))
		{
		if($result_array[$field_name]==$default)
		{
			echo '<option selected  > '.$result_array[$field_name].' </option>';
		}
		else
			{
				echo '<option  > '.$result_array[$field_name].' </option>';
			}
		}
		echo '</select>';	
		return TRUE;
}

function mk_select_from_array($ar,$form_name,$disabled,$default)
{

		echo '<select  '.$disabled.' name='.$form_name.' id='.$form_name.'>';
		foreach($ar as $value)
		{
			if($value==$default)
		{
			echo '<option selected  > '.$value.' </option>';
		}
		else
			{
				echo '<option  > '.$value.' </option>';
			}
		}
		echo '</select>';	
		return TRUE;
}

function mk_select_from_array_ajax($id,$ar,$form_name,$disabled,$default)
{

		echo '<select  onchange="do_work(\''.$id.'\',this)" '.$disabled.' name='.$form_name.' id='.$form_name.'>';
		foreach($ar as $value)
		{
			if($value==$default)
		{
			echo '<option selected  > '.$value.' </option>';
		}
		else
			{
				echo '<option  > '.$value.' </option>';
			}
		}
		echo '</select>';	
		return TRUE;
}

function mk_select_from_sql_with_separate_id($link,$sql,$field_name,$form_name,$id_name,$disabled,$default)
{

	if(!$result=mysqli_query($link,$sql)){return FALSE;}
	
		echo '<select  '.$disabled.' name='.$form_name.' id='.$id_name.'>';
		while($result_array=mysqli_fetch_assoc($result))
		{
		if($result_array[$field_name]==$default)
		{
			echo '<option selected  > '.$result_array[$field_name].' </option>';
		}
		else
			{
				echo '<option  > '.$result_array[$field_name].' </option>';
			}
		}
		echo '</select>';	
		return TRUE;
}


function combo_entry($link,$sql,$name,$disabled,$default)
{
	echo '<table><tr><td>';
	mk_select_from_sql($link,$sql,$name,$disabled,$default);
	echo '</td><td>';
	echo '<input type=text name=\'i_'.$name.'\'>';
	echo '<input type=checkbox name=\'ck_'.$name.'\'>';
	echo '</td></tr></table>';
	
}


function get_raw($link,$sql)
{
	//echo $sql;
	if(!$result=mysqli_query($link,$sql)){echo mysqli_error($link);return FALSE;}
	if(mysqli_num_rows($result)!=1){echo mysqli_error($link);return false;}
	else
	{
		return mysqli_fetch_assoc($result);
	}
}


function update_field_by_id($link,$table,$id_field,$id_value,$field,$value)
{
	$sql='update `'.$table.'` set `'.$field.'`=\''.$value.'\' where `'.$id_field.'`=\''.$id_value.'\'';
	//echo $sql;
	
	
	if(!$result=mysqli_query($link,$sql)){mysql_error();return FALSE;}
	else
	{
		return mysqli_affected_rows($link);
	}
}

function delete_raw_by_id($link,$table,$id_field,$id_value)
{
	$sql='delete from `'.$table.'` where `'.$id_field.'`=\''.$id_value.'\'';
	//echo $sql;
	
	
	if(!$result=mysqli_query($link,$sql)){mysql_error();return FALSE;}
	else
	{
		return mysqli_affected_rows($link);
	}
}

function update_or_insert_field_by_id($link,$table,$id_field,$id_value,$field,$value)
{
	if(get_raw($link,'select `'.$id_field.'` from `'.$table.'` where `'.$id_field.'`=\''.$id_value.'\'')===FALSE)
	{
		//Try to insert
		$sqli='insert into `'.$table.'` (`'.$id_field.'`,`'.$field.'`) values (\''.$id_value.'\', \''.$value.'\')';
		//echo $sqli;
		if(!$resulti=mysqli_query($link,$sqli)){echo mysqli_error($link);return FALSE;}
		else
		{
			return mysqli_affected_rows($link);
		}
	}
	else
	{
		//Else update
		$sql='update `'.$table.'` set `'.$field.'`=\''.$value.'\' where `'.$id_field.'`=\''.$id_value.'\'';
		//echo $sql;
		if(!$result=mysqli_query($link,$sql))
		{
			echo mysqli_error($link);
			return FALSE;
		}
	}
}

function insert_field_by_id($link,$table,$id_field,$id_value,$field,$value)
{
		//Try to insert
		$sqli='insert into `'.$table.'` (`'.$id_field.'`,`'.$field.'`) values (\''.$id_value.'\', \''.$value.'\')';
		//echo $sqli;
		if(!$resulti=mysqli_query($link,$sqli)){echo mysqli_error($link);return FALSE;}
		else
		{
			return mysqli_insert_id($link);
		}
}


function insert_id($link,$table,$id_field,$id_value)
{
	$sqli='insert into `'.$table.'` (`'.$id_field.'`) values (\''.$id_value.'\')';
	//echo $sqli;
	if(!$resulti=mysqli_query($link,$sqli))
	{
		echo mysqli_error($link);return FALSE;
	}
	else
	{
		return mysqli_insert_id($link);
	}
}


function update_or_insert_filename_field_by_id($link,$table,$id_field,$id_value,$field,$value)
{
	if(strlen($value)>0)
	{
		if(get_raw($link,'select `'.$id_field.'` from `'.$table.'` where `'.$id_field.'`=\''.$id_value.'\'')===FALSE)
		{
			//Try to insert
			$sqli='insert into `'.$table.'` (`'.$id_field.'`,`'.$field.'`) values (\''.$id_value.'\', \''.$value.'\')';
			echo $sqli;
			if(!$resulti=mysqli_query($link,$sqli)){echo mysqli_error($link);return FALSE;}
			else
			{
				return mysqli_affected_rows($link);
			}
		}
		else
		{
			//Else update
			$sql='update `'.$table.'` set `'.$field.'`=\''.$value.'\' where `'.$id_field.'`=\''.$id_value.'\'';
			//echo $sql;
			if(!$result=mysqli_query($link,$sql))
			{
				echo mysqli_error($link);
				return FALSE;
			}
		}
	}
}



function india_to_mysql_date($ddmmyyyy)
{
	$ex=explode('-',$ddmmyyyy);
	if(count($ex)==3)
	{
		return $ex[2].'-'.$ex[1].'-'.$ex[0];
	}
	else
	{
		return false;
	}
}

function mysql_to_india_date($yyyymmdd)
{
	$ex=explode('-',$yyyymmdd);
	if(count($ex)==3)
	{
		return $ex[2].'-'.$ex[1].'-'.$ex[0];
	}
	else
	{
		return false;
	}
}

function date_diff_to_year_month_days($from,$to)
{
	//dates as yyyy-mm-dd format only
	//To    2016-03-04
	//From  2015-05-20
	//      0000-09-(N) 
	
	$exf=explode('-',$from);
	$ext=explode('-',$to);
	if(count($exf)!=3||count($ext)!=3)
	{
		return false;
	}
	
	if(in_array('00',$exf)===TRUE || in_array('0000',$exf)===TRUE)
	{
		//print_r($exf);
		return false;
	}
	
	$days_of_from_month=cal_days_in_month(CAL_GREGORIAN,$exf[1],$exf[0]);
	if($days_of_from_month===FALSE)
	{
		return FALSE;
	}
	$days=$ext[2]+($days_of_from_month-$exf[2]);
	
	
	$months=$ext[1]+12-$exf[1]-1;
	
	$years=$ext[0]-$exf[0]-1;
	
	if($days>cal_days_in_month(CAL_GREGORIAN,$exf[1],$exf[0])){$days=abs($ext[2]-$exf[2]);$months=$months+1;}
	if($months>11){$years=$years+1;$months=$months-12;}
	
	//echo "<h1>".$to." and ".$from."</h1>";
	//echo "<h1>".$years.",".$months.",".$days."</h1>";
	
	return $years." yr, ".$months." mo, ".$days." d";
/*
	$y=$ext[0]-$exf[0];

	$m=$ext[1]-$exf[1];
	if($m<0){$y=$y-1;$m=12+$m;}
	
	$d=$ext[1]-$exf[1];
	if($d<0){$m=$m-1;$d=cal_days_in_month(CAL_GREGORIAN,$exf[1],$exf[0])-$d;}
	
	if($m<0){$y=$y-1;$m=12+$m;}
	
	echo "<h1>".$to." and ".$from."</h1>";
	echo "<h1>".$y.",".$m.",".$d."</h1>";
*/
}

//functions for file upload management//////////////

function file_to_str($link,$file)
{
	$fd=fopen($file['tmp_name'],'r');
	$size=$file['size'];
	$str=fread($fd,$size);
	return mysqli_real_escape_string($link,$str);
}

function insert_attachment($link,$table,$id_field,$id_value,$files_field,$files_value)
{
	$str=file_to_str($link,$files_value);

	$sql='insert into `'.$table.'` 
			(`'.$id_field.'`,`'.$files_field.'`) values(\''.$id_value.'\',"'.$str.'")';

		
	if(!$result=mysqli_query($link,$sql))
	{		
		//echo 'Error()';
		echo mysqli_error($link);
	}
	else
	{
		//echo 'insert success';
		return mysqli_insert_id($link);
	}
}	

function read_year($name,$y,$yy)
{
	echo '<select name=\''.$name.'\'>';
	for($i=$y;$i<$yy;$i++)
	{
			echo '<option>'.$i.'</option>';
	}
	echo '</select>';
	
}

function update_or_insert_attachment($link,$table,$id_field,$id_value,$files_field,$files_value)
{	
	//echo '<pre>'; print_r( $files_value);echo '</pre>';
	if($files_value['size']>0)
	{
		if(get_raw($link,'select `'.$id_field.'` from `'.$table.'` where `'.$id_field.'`=\''.$id_value.'\'')===FALSE)
		{
		//insert

			$str=file_to_str($link,$files_value);

			$sql='insert into `'.$table.'` 
					(`'.$id_field.'`,`'.$files_field.'`) values(\''.$id_value.'\',"'.$str.'")';

				
			if(!$result=mysqli_query($link,$sql))
			{		
				//echo 'Error()';
				echo mysqli_error($link);
			}
			else
			{
				//echo 'insert success';
				return mysqli_insert_id($link);
			}
		}
		//update
		else
		{
			$str=file_to_str($link,$files_value);
			$sql='update `'.$table.'` set 
					`'.$files_field.'` ="'.$str.'"
					where
					`'.$id_field.'` =\''.$id_value.'\'';
			//echo $sql;
			if(!$result=mysqli_query($link,$sql)){echo mysqli_error($link);}
			else
			{
				//echo 'update success';
				return $id_value;
			}			
		}
	}
}



function find_primary_key_array($link,$table)
{
	//This function is useful when primary key is madeup of multiple fields
	$sql_p='SHOW KEYS FROM  `'.$table.'` WHERE Key_name = \'PRIMARY\'';
	if(!$result_p=mysqli_query($link,$sql_p)){echo mysqli_error($link);return FALSE;}
	$pk=array();
	while($array_p=mysqli_fetch_assoc($result_p))
	{
		$pk[]=$array_p['Column_name'];
	}
	return $pk;
}

function read_primary_key($parray,$array)
{
	$ret_array=array();
	foreach($parray as $key=>$value)
	{
		$ret_array[$value]=$array[$value];
	}
	return $ret_array;
}

function prepare_where($ar)
{		
		if(count($ar)>0)
		{
			$where=' where ';
			foreach($ar as $k=>$v)
			{
				$where=$where.'`'.$k.'`='.'\''.$v.'\' and ';
			}
			$where=substr($where,0,-4);
		}
		else
		{
			$where='';
		}
		//echo '<h3>'.$where.'</h3>';
		return $where;
}

function prepare_where_like($ar)
{		
		if(count($ar)>0)
		{
			$where=' where ';
			foreach($ar as $k=>$v)
			{
				$where=$where.'`'.$k.'` like '.'\'%'.$v.'%\' and ';
			}
			$where=substr($where,0,-4);
		}
		else
		{
			$where='';
		}
		//echo '<h3>'.$where.'</h3>';
		return $where;
}


function display_photo($link,$photo)
{
		//if($ar['lng']>0)
		//{
			echo '<img style="width:3cm;height:4cm;" src="data:image/jpeg;base64,'.base64_encode($photo).'"/>';
		//}
		//else
		//{
		//	echo 'RECENT PHOTOGRAPH TO BE COUNTER SIGNED BY  THE DEAN/ PRINCIPAL';
		//}
}


function if_in_interval($dt,$from_dt,$to_dt)
{


	//f d t
	if(strtotime($dt)-strtotime($from_dt)>=0 && strtotime($dt)-strtotime($to_dt)<=0)
	{
		return 0;
	}
	
	//d f t
	elseif(strtotime($dt)-strtotime($from_dt)<0 && strtotime($dt)-strtotime($to_dt)<0)
	{
		return -1;
	}

	//f t d
	elseif(strtotime($dt)-strtotime($from_dt)>0 && strtotime($dt)-strtotime($to_dt)>0)
	{
		return 1;
	}
	
	//t f is illogical
	else
	{
		return FALSE;
	}
		
	/*

	$dtt=date_create($dt);
	$from_dtt=date_create($from_dt);
	$to_dtt=date_create($to_dt);
	
	$diff_from=date_diff($dtt,$from_dtt);
	print_r($diff_from);
	
	$diff_to=date_diff($dtt,$to_dtt);
	print_r($diff_to);	
	*/
	
}

function date_diff_grand($from_dt,$to_dt)
{
	$from_dtt=date_create($from_dt);
	$to_dtt=date_create($to_dt);
	
	return $diff_from=date_diff($from_dtt,$to_dtt);
	
	//echo '<pre>';
	//print_r($diff_from);
	//echo '</pre>';

}

function view_data_sql($link,$sql,$pk,$script)
{
	if(!$result_id=mysqli_query($link,$sql)){echo mysqli_error($link);}
	$array_id=mysqli_fetch_assoc($result_id);
	
	$first_data='yes';
	
	if(!$result=mysqli_query($link,$sql)){echo mysqli_error($link);}
	echo '<table border=1>';
	
	$first_data='yes';
	
	while($array=mysqli_fetch_assoc($result))
	{
		if($first_data=='yes')
		{
			echo '<tr bgcolor=lightgreen>';
			foreach($array as $key=>$value)
			{
				echo '<th>'.$key.'</hd>';
			}
			echo '</tr>';
			$first_data='no';
		}
		foreach($array as $key=>$value)
		{
			if($key==$pk)
			{
				echo '<td><form method=post action=\''.$script.'\'><button type=submit name=id value=\''.$value.'\'>'.$value.'</button></form></td>';			
			}
			else
			{
				echo '<td><pre>'.$value.'</pre></td>';
			}
		}
		echo '</tr>';

	}
	echo '</table>';
}

function get_user_info($link)
{
	$sql='select * from user where id=\''.$_SESSION['login'].'\'';
	if(!$result=mysqli_query($link,$sql)){echo mysqli_error($link);}

	return mysqli_fetch_assoc($result);
}

//0 nothing
//1 read
//2 write  
//3 approve (and lock)
//4 ammend  (and unlock)

//0 nobody
//1 sister
//2 R1
//3 R2
//4 R3
//5 R4
//6 AP
//7 Asso
//8 Unit Head
//9 HOD

//0 other department
//1 same department

function get_user_right($id)
{
	$u=get_user_info($link);
	$pt=get_raw($link,'select * from pt where ipd=\''.$pt['ipd'].'\'');
	if($u['department']==$pt['department'] && $u['unit']==$pt['unit'])
	{
		return $u['right'];
	}
	else
	{
		return $u['right'];
	}
}



function menu()
{	
		
echo '
<form method=post>
<table class=\"menu\">
<tr><td>
		<button type=button onclick="showhidemenu(\'button1\')">Discarge Card</button>
		<table  id="button1" class="menu" style="position:absolute; display:none;">
			<tr><td>
				<button formaction=new_dc.php type=submit onclick="hidemenu()" name=new>New</button>
			</td></tr>			
			<tr><td>
				<button formaction=search_dc.php type=submit onclick="hidemenu()" name=new>Search</button>
			</td></tr>
		</table>
			
</td><td>
		<button  type=button onclick="showhidemenu(\'button2\')">Manage My Account('.$_SESSION['login'].')</button>
		<table  id="button2" class="menu" style="position: absolute;display:none;">
		<tr><td>
			<button formaction=logout.php type=submit onclick="hidemenu()" name=new>Logout</button>
		</td></tr>
		<tr><td>
			<button formaction=change_pass.php type=submit onclick="hidemenu()" name=new>Change Password</button>
		</td></tr>
		</table>	
</td></tr>
</table>
</form>
';

}



?>
