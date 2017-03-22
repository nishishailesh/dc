<?php
session_start();
require_once 'tcpdf/tcpdf.php';
require_once '/var/gmcs_config/staff.conf';
require_once 'common.php';

$link=connect();
$id=$_POST['id'];
//////////////
$pt=get_raw($link,'select * from pt where ipd=\''.$id.'\'');

//////////////

function echo_csv($csv)
{
	$str='';
	$ex=explode(',',$csv);
	foreach ($ex as $v)
	{
		$str=$str.$v.'<br>';
	}	
	return $str;
}

$str='<html><head></head><body>';

$str=$str.	'<table>
		<tr>
			<td width="33%"></td>
			<td width="33%"></td>
			<td width="33%" ></td>
		</tr>';

$str=$str.	'<tr>';
$str=$str.		'<td width="33%" style="border-collapse: collapse;border: 1px solid black;">'.$pt['mrd'].'</td>';
$str=$str.		'<td width="33%" style="border-collapse: collapse;border: 1px solid black;">'.$pt['name'].'</td>';	
$str=$str.		'<td width="33%" style="border-collapse: collapse;border: 1px solid black;">IDP:'.$pt['ipd'].'</td>';
$str=$str.	'</tr>';


$str=$str.	'<tr>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">M:'.$pt['mobile'].'</td>';
$str=$str.		'<td colspan="2" style="border-collapse: collapse;border: 1px solid black;" >Age:'.$pt['age'];
					
$str=$str.		'  Sex:'.$pt['sex'];
$str=$str.		'  Blood Group:'.$pt['bloodgroup'];
$str=$str.		'</td>';
$str=$str.		'</tr><tr>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">Dept:'.$pt['department'].'</td>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">Unit:'.$pt['unit'];
$str=$str.		'</td>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">'.$pt['location'];
$str=$str.		'</td>';
$str=$str.	'</tr>';


$str=$str.		'<tr>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;" colspan="3">Diagnosis:'.htmlspecialchars($pt['diagnosis']).'</td>';
$str=$str.	'</tr>';

$str=$str.	'<tr>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">DOA:'.mysql_to_india_date($pt['doa']).'</td>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">DOO:'.mysql_to_india_date($pt['doo']).'</td>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">DOD:'.mysql_to_india_date($pt['dod']).'</td>';
$str=$str.		'</tr><tr><td colspan="3" style="border-collapse: collapse;border: 1px solid black;">
						Discharge Type:'.$pt['discharge_type'].
				'</td>';
$str=$str.	'</tr><tr><td style="border-collapse: collapse;border: 1px solid black;">';
$str=$str.		'LCDC:'.$pt['LCDC_no'].'</td>';	
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">HPE:'.$pt['HPE_no'].'</td>';	
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;">MLC:'.$pt['MLC_no'].'</td>';	

$str=$str.	'</tr><tr>';
$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;" colspan="3"><b>Complains:</b>';
$str=$str.	htmlspecialchars($pt['complains']).'</td>';	
$str=$str.	'</tr>';


$ar=array('Hb', 'Platelet', 'TC', 'DC', 'Hematocrit', 'Creatinine', 'Sodium', 'Potassium', 'Glucose', );

$counter=0;
foreach ($ar as $value)
{
	if($counter%3==0){$str=$str.'<tr>';}
	$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;"  width="33%"><b>'.$value.'</b>: '.htmlspecialchars($pt[$value]).'</td>';	
	if($counter%3==2){$str=$str.'</tr>';}
	$counter++;	
}


$ar=array('pus_culture', 'urine_culture', 'Urine_microscopy');

$counter=0;
foreach ($ar as $value)
{
	if($counter%3==0){$str=$str.'<tr>';}
	$str=$str.		'<td style="border-collapse: collapse;border: 1px solid black;"   width=33%><b>'.$value.'</b>:'.htmlspecialchars($pt[$value]).'</td>';	
	if($counter%3==2){$str=$str.'</tr>';}
	$counter++;	
}

$ar=array('other_laboratory','x_ray', 'USG', 'ECG', 'reference', 'OT', 'treatment_in_ward', 'condition_on_discharge', 'advise_on_discharge', 'followup');

foreach ($ar as $value)
{
	$n=str_replace('\r','<br>',$pt[$value]);
	$str=$str.'<tr>';
	$str=$str.		'<td colspan="3" style="border-collapse: collapse;border: 1px solid black;"  ><b>'.$value.':</b>'.$n.'</td>';	
	$str=$str.'</tr>';
}




$str=$str.	'</table></body></html>';

	class pp extends TCPDF{
			public $pt;
			public function Header() 
			{
				$this->SetFont('courier', 'B', 15);
				$this->SetXY(20,20);
				
				$this->Cell(180, $h=0, $txt='New Civil Hospital Surat,Discharge Card', $border=0, $ln=0, $align='C', $fill=false, $link='', $stretch=1, $ignore_min_height=false, $calign='T', $valign='M');
				
				$this->SetFont('courier', 'B', 12);
				$this->SetXY(20,25);		
				$this->Cell(180, $h=0, $txt=$this->pt['department'].' Unit:'.$this->pt['unit'].' Location:'.$this->pt['location'], $border=0, $ln=0, $align='C', $fill=false, $link='', $stretch=1, $ignore_min_height=false, $calign='T', $valign='M');

				$this->SetFont('courier', 'B', 12);
				$this->SetXY(20,30);		
				$this->Cell(180, $h=0, $txt=$this->pt['clinician'], $border=0, $ln=0, $align='C', $fill=false, $link='', $stretch=1, $ignore_min_height=false, $calign='T', $valign='M');	

				$this->SetFont('courier', 'B', 12);
				$this->SetXY(20,35);		
				$this->Cell(180, $h=0, $txt="IPD:".$this->pt['ipd'].", Patient:".$this->pt['name'], $border=0, $ln=0, $align='C', $fill=false, $link='', $stretch=1, $ignore_min_height=false, $calign='T', $valign='M');				
	
				$this->SetFont('courier', 'B', 7);
				$this->SetXY(20,40);		
				$this->Cell(180, $h=0, $txt="PDF generated on:".date("r"), $border=0, $ln=0, $align='C', $fill=false, $link='', $stretch=1, $ignore_min_height=false, $calign='T', $valign='M');				
			}
			
			public function Footer() {}
		};
	
	$pdf = new pp('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->pt=$pt;
	$pdf->SetFont('courier', '', 10);
	$pdf->startPageGroup();
	$pdf->SetMargins(20,50);
	$pdf->AddPage();

	$str_br=str_replace("\n",'<br>',$str);
	$pdf->writeHTMLCell(0,0,30,35,$str_br,0,$ln=1, $fill=false, $reseth=true, $align='', $autopadding=true);

	$pdf->Output($pt['ipd'].'.pdf', 'I');



?>
