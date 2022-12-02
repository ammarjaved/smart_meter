<?php

	
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


	$after_pic = $_FILES["excel3"]["name"];
    $after_tempname = $_FILES["excel3"]["tmp_name"];
    $folder2 = "./files/" . $after_pic;
	    // echo $folder2;

   if (move_uploaded_file($after_tempname, $folder2)) {
    // exit(); 	
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$spreadsheet = $reader->load($folder2);
		$total_sheets = $spreadsheet->getSheetCount();

       $cn = pg_connect("host=localhost port=5433 user=postgres dbname=smart_meter password=Admin123");
	if (!$cn) { echo "DB not connected " ; exit();}
// $sheet = $spreadsheet->getSheet('0');
	// if( $sheet->getCell('A1')->getValue() == 'Installation' && $sheet->getCell('B1')->getValue() == 'Trim SO' && 
	// $sheet->getCell('E1')->getValue() == 'Latitude' && $sheet->getCell('F1')->getValue() == 'Longitude' && strtolower($sheet->getCell('P1')->getValue()) == 'week'){
	
       

        $sheet = $spreadsheet->getSheet(0);
        for ($i=0; $i < $total_sheets ; $i++) { 
			
			$t_col = $sheet->getHighestColumn();
			$r_row = $sheet->getHighestRow();
	
				for ($j=2; $j < $r_row +1; $j++) { 
                    if($sheet->getCell('A'. $j)->getValue() != ""){

                        $status= "";
                        $so = $sheet->getCell('A'. $j)->getValue();
                        if($sheet->getCell('F'. $j)->getValue() == "TRAS"){
                            $status = "TRAS";
                        }else if($sheet->getCell('F'. $j)->getValue() == ""){
                            $status = "Unsurveyed";
                        }

                        
                        $query = "UPDATE tbl_survey_details SET installed_status='$status' WHERE service_order = '$so'";
                        $query1= "SELECT * FROM tbl_survey_details WHERE service_order='$so'";

                        $pg = pg_query($cn,$query);

                        $pg1 = pg_query($cn,$query1);
                        $fq1 = pg_fetch_all($pg1);


                        $query2 = "INSERT INTO tbl_survey_details (status, old_meter_no, new_meter_no, pic_before, pic_after, pic_3, pic_4, installation_id, latitude, longitude, geom, service_order )
                        VALUES('$so',
                        '".$sheet->getCell('N'. $j)->getValue()."',
                        '".$sheet->getCell('P'. $j)->getValue()."',
                        '".$sheet->getCell('U'. $j)->getValue()."',
                        '".$sheet->getCell('U'. $j+1)->getValue()."',
                        '".$sheet->getCell('U'. $j+2)->getValue()."',
                        '".$sheet->getCell('U'. $j+3)->getValue()."',
                        '".$fq1[0]['installation']."',
                        '".$fq1[0]['latitude']."',
                        ".$fq1[0]['longitude']."',
                        st_geomfromtext('POINT('||".$fq1[0]['latitude']."||' '||".$fq1[0]['longitude']."||')',4326),
                        '$so')";
                        $pg2=pg_query($query2);
                    }
                    
                    

               
        }
    }
  
    
    
   		echo "Upload Successfully";
		

        

pg_close($cn);
// exit();
        
	}



?>