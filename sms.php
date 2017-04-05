<?php
session_start();
require_once 'common.php';


function read_sms()
{
	echo '<form method=post>';
	echo '<table border=1>';
	echo '<tr><th colspan=2>Send SMS</th></tr>'; 
	echo '<tr><td>Mobile</td><td><input type=text name=num></td></tr>';
	echo '<tr><td>SMS</td><td><input type=text name=sms></td></tr>';
	echo '<tr><td colspan=2><input name=submit type=submit value=send></td></tr>';
	echo '</form>';
	echo '</table>';
}

function send_sms_mobi1($sms,$num)
{
	$str='http://mobi1.blogdns.com/httpmsgid/SMSSenders.aspx';
	$getdata = http_build_query
		(
		array(
			'UserID' => 'gmcsrttr',
			'UserPass' => 'gmc123',
			'Message'=>$sms,
			'MobileNo'=>$num,
			'GSMID'=>'GMCSRT'
			)
		);
								
	$hdr = "Content-Type: application/x-www-form-urlencoded";
                    
	$opts = array('http' =>
					array(
						'method'  => 'GET',
						'content' => $getdata,
						'header'  => $hdr
						)
				);

	$context  = stream_context_create($opts);
	//echo $str;
	$ret=file_get_contents($str,false,$context);
	return $ret;
}



        $link=mysqli_connect('127.0.0.1',$GLOBALS['main_user'],$GLOBALS['main_pass']);
        mysqli_select_db($link,'dc');

$sql='select * from user_pass';
$result=mysqli_query($link,$sql);
while($ra=mysqli_fetch_assoc($result))
{
	$sms='For Discharge Card: website: gmcsurat.edu.in/dc , login:'.$ra['id'].' pass::'.$ra['password'].' , change password after first login';
	$num=$ra['id'];
	echo $sms.'<br>';
	$res=send_sms_mobi1($sms,$num);
	echo 'Report:'.$res.'<br>';
}

?>
