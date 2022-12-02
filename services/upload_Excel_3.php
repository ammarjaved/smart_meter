<?php

	
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



	$after_pic = $_FILES["excel3"]["name"];
    $after_tempname = $_FILES["excel3"]["tmp_name"];
    $folder2 = "./files/" . $after_pic;
	   

   if (move_uploaded_file($after_tempname, $folder2)) {
    	
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($folder2);
         $total_sheets = $spreadsheet->getSheetCount();

        $cn = pg_connect("host=121.121.232.54 port=5433 user=postgres dbname=smart_meter password=Admin123");
	    if (!$cn) { echo "DB not connected " ; exit();}

       

        $sheet = $spreadsheet->getSheet(0);
        for ($i=0; $i < $total_sheets ; $i++) { 
			
            
			$t_col = $sheet->getHighestColumn();
			 $r_row = $sheet->getHighestRow();
	
				for ($j=2; $j < $r_row +1; $j++) { 
                    if($sheet->getCell('A'. $j)->getValue() != ""){

                        $status= "";
                         $so = $sheet->getCell('A'. $j)->getValue();
                        // $so= '8500400';

                        if($sheet->getCell('F'. $j)->getValue() == "TRAS"){
                            $status = "TRAS";
                        }else if($sheet->getCell('F'. $j)->getValue() == ""){
                            $status = "Unsurveyed";
                        }

                        
                        
                        $query3= "SELECT count(*) FROM tbl_survey_details WHERE service_order='$so'";
                        $pg3=pg_query($cn, $query3);
                         $fq3 = pg_fetch_all($pg3);
                        echo $fq3[0]['count'];
                        
                        if( $fq3[0]['count'] > 0){
                            echo '<br>';
                            echo $j;
                            echo '<br>';
                            echo $so;
                            echo '<br>';

                            $query = "UPDATE tbl_survey_details SET installed_status='$status' WHERE service_order = '$so'";

                            $pg = pg_query($cn,$query);

                            $query1= "SELECT * FROM tbl_survey_details WHERE service_order='$so'";
                            $pg1 = pg_query($cn,$query1);
                            $fq1 = pg_fetch_all($pg1);

                            // print_r("<pre>");
                            // print_r($fq1);print_r("</pre>");
                            echo $fq1[0]['latitude'];
                            echo $fq1[0]['longitude'];
                            exit();

                            

                        $query2 = "INSERT INTO tbl_meter(status, old_meter_no, new_meter_no, pic_before, pic_after,  installation_id, latitude, longitude, geom, service_order )
                        VALUES('$so',
                        '".$sheet->getCell('N'. $j)->getValue()."',
                        '".$sheet->getCell('P'. $j)->getValue()."',
                        '".$sheet->getCell('S'. $j)->getValue()."',
                        '".$sheet->getCell('S'. $j+1)->getValue()."',
                        '".$fq1[0]['installation']."',
                        '".$fq1[0]['latitude']."',
                        '".$fq1[0]['longitude']."',
                        st_geomfromtext('POINT('||".$fq1[0]['latitude']."||' '||".$fq1[0]['longitude']."||')',4326),
                        '$so')";
                        $pg2=pg_query($query2);
                        }
                      exit();
                       
                    }
                    
                    

               
        }
    }
  
    
    
   		echo "Upload Successfully";
		

        

pg_close($cn);
// exit();
        
	}



?>