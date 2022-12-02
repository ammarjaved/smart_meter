<?php

	
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



	$after_pic = $_FILES["excel"]["name"];
    $after_tempname = $_FILES["excel"]["tmp_name"];
    $folder2 = "./files/" . $after_pic;
	    // echo $folder2;

   if (move_uploaded_file($after_tempname, $folder2)) {
        	
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($folder2);
		$total_sheets = $spreadsheet->getSheetCount();

       $cn = pg_connect("host=localhost port=5433 user=postgres dbname=smart_meter password=Admin123");
	if (!$cn) { echo "DB not connected " ; exit();}
$sheet = $spreadsheet->getSheet('0');
	if( $sheet->getCell('A1')->getValue() == 'Installation' && $sheet->getCell('B1')->getValue() == 'Trim SO' && 
	$sheet->getCell('E1')->getValue() == 'Latitude' && $sheet->getCell('F1')->getValue() == 'Longitude' && strtolower($sheet->getCell('P1')->getValue()) == 'week'){
	for ($i=0; $i < $total_sheets ; $i++) { 

			$sheet = $spreadsheet->getSheet($i);
			$t_col = $sheet->getHighestColumn();
			$r_row = $sheet->getHighestRow();
			
			
	
				for ($j=2; $j < $r_row +1; $j++) { 
					
					if($sheet->getCell('A'. $j)->getValue() != ''){
						// $Service_check = "SELECT count(*) FROM tbl_survey_details WHERE service_order='".$sheet->getCell('B'. $j)->getValue()."'";

					
						$result_query = pg_query($cn , "SELECT count(*) FROM tbl_survey_details WHERE service_order='".$sheet->getCell('B'. $j)->getValue()."'");
                         $arrq = pg_fetch_all($result_query);
						// echo $arrq[0]['count'];
						// exit();
						
						
						if( $arrq[0]['count'] == 0){
							
					
					$query = "INSERT INTO tbl_survey_details(installation, service_order, address, latitude, longitude, voltage_level, device_no, meter_type, premise_type, station, area,geom,week_no,month,year,installed_status)

						VALUES ( 
							'".$sheet->getCell('A'. $j)->getValue()."',
							'".$sheet->getCell('B'. $j)->getValue()."',
							'".$sheet->getCell('D'. $j)->getValue()."',
							'".$sheet->getCell('E'. $j)->getValue()."',
							'".$sheet->getCell('F'. $j)->getValue()."',
							'".$sheet->getCell('G'. $j)->getValue()."',
							'".$sheet->getCell('H'. $j)->getValue()."',
						    '".$sheet->getCell('I'. $j)->getValue()."',
							'".$sheet->getCell('J'. $j)->getValue()."',
							'".$sheet->getCell('K'. $j)->getValue()."',
							'".$sheet->getCell('L'. $j)->getValue()."',

							st_geomfromtext('POINT('||".$sheet->getCell('f'. $j)->getValue()."||' '||".$sheet->getCell('e'. $j)->getValue()."||')',4326),
							". (int) $sheet->getCell('P'. $j)->getValue().",
							".$sheet->getCell('Q'. $j)->getValue().",
							".$sheet->getCell('R'. $j)->getValue().",
							'Unsurveyed')";
							 //echo $query;
		                    //exit(); 
							try{
							pg_query($cn , $query);
							}catch(Exception $e){

							}
						}else{
							echo "This data is already exist in Database";
							exit();
						}
					}
		// exit();
				}
				// exit();
			
		}
		echo "Upload Successfully";
		



pg_close($cn);
// exit();
	}else{
		echo "uploaded worng file !!!";
	}
}


?>