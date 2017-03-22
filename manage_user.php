<?php
session_start();
require_once '/var/gmcs_config/staff.conf';
require_once 'common.php';
require_once 'common_js.php';

echo '<pre>';print_r($_POST);echo '</pre>';


function adduser($link)
{
	$sql='select `'.$field.'` from '.$field;
	echo $sql;
	if(!$result=mysqli_query($link,$sql)){return FALSE;}
	while($result_array=mysqli_fetch_assoc($result));	
}

function deluser($link)
{
	
	
}

function viewuser($link)
{
	
	
}

$link=connect();
$ui=get_user_info($link);

echo '<table class="border lightblue"><tr><th>'.$ui['id'].'</th><th>'.$ui['name'].'</th><th>'.$ui['department'].'</th><th>Unit:'.$ui['unit'].'</th>';

echo '<tr><th colspan=4>You can create new users for your unit</th></tr>';
echo '<tr><th colspan=4>You can create users with less previlage than yourself</th></tr>';
echo '<tr><th colspan=4>e.g HOD can create unit head, unit head can create AP/resident</th></tr>';


echo '</tr></table>';



?>
