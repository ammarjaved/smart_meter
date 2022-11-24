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

       $cn = pg_connect("host=localhost port=5432 user=postgres dbname=smart3 password=123");
	if (!$cn) { echo "DB not connected " ; exit();}

	for ($i=0; $i < $total_sheets ; $i++) { 

			$sheet = $spreadsheet->getSheet($i);
			$t_col = $sheet->getHighestColumn();
			echo $r_row = $sheet->getHighestRow();
			// exit();
			echo "<br><br><br>";
	
				for ($j=2; $j < $r_row +1; $j++) { 
					echo $coca= "=".$sheet->getCell('A'. $j)->getValue();

					
					$query = "INSERT INTO tbl_survey_details( service_order, address, latitude, longitude, voltage_level, device_no, meter_type, premise_type, station, area)
						VALUES ( 
							'".$sheet->getCell('A'. $j)->getValue()."',
							'".$sheet->getCell('C'. $j)->getValue()."',
							'".$sheet->getCell('D'. $j)->getValue()."',
							'".$sheet->getCell('E'. $j)->getValue()."',
							'".$sheet->getCell('F'. $j)->getValue()."',
							'".$sheet->getCell('G'. $j)->getValue()."',
							'".$sheet->getCell('H'. $j)->getValue()."',
						    '".$sheet->getCell('I'. $j)->getValue()."',
							'".$sheet->getCell('J'. $j)->getValue()."',
							'".$sheet->getCell('K'. $j)->getValue()."')";
							 //echo $query;
		                    //exit(); 
							pg_query($cn , $query);
		// exit();
				}
				// exit();
			
		}
		



pg_close($cn);
exit();
}


?>