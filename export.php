<?php
session_start();
require_once '/var/gmcs_config/staff.conf';
require_once 'common.php';

//echo '<pre>';print_r($_POST);echo '</pre>';

function export_to_csv($sql,$link)
{
	if(!$result=mysqli_query($link,$sql)){echo mysqli_error($link);}
	$fp = fopen('php://output', 'w');
	if ($fp && $result) 
	{
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="export.csv"');
		
		$first='yes';
		
		while ($row = mysqli_fetch_assoc($result))
		{
			if($first=='yes')
			{
				fputcsv($fp, array_keys($row));
				$first='no';
			}
			
			fputcsv($fp, array_values($row));
		}
	}	
	
}

$link=connect();
export_to_csv(base64_decode($_POST['str']),$link);

?>
