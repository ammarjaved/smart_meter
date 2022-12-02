<?php

	
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



	$after_pic = $_FILES["excel3"]["name"];
    $after_tempname = $_FILES["excel3"]["tmp_name"];
    $folder2 = "./files/" . $after_pic;
    $arr_file = explode('.', $_FILES['excel3']['name']);
    $extension = end($arr_file);
    if('xlsx' != $extension) {
       echo "File must be .Xlsx";
       exit();
    }

   

   if (move_uploaded_file($after_tempname, $folder2)) {
    	
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($folder2);
         $total_sheets = $spreadsheet->getSheetCount();

        $cn = pg_connect("host=121.121.232.54 port=5433 user=postgres dbname=smart_meter password=Admin123");
	    if (!$cn) { echo "DB not connected " ; exit();}

       

        $sheet = $spreadsheet->getSheet(0);
        $status= "";
        for ($i=0; $i < $total_sheets ; $i++) { 
			
            
			$t_col = $sheet->getHighestColumn();
			 $r_row = $sheet->getHighestRow();
	
				for ($j=2; $j < $r_row +1; $j++) { 
                    
                    if($sheet->getCell('A'. $j)->getValue() != ""){

                        
                         $so = $sheet->getCell('A'. $j)->getValue();
                        // $so= '8500400';

                        if($sheet->getCell('F'. $j)->getValue() == "TRAS"){
                            $status = "TRAS";
                        }else if($sheet->getCell('F'. $j)->getValue() == ""){
                            $status = "Installed";
                        }

                        
                        
                        $query3= "SELECT count(*) FROM tbl_survey_details WHERE service_order='$so'";
                        $pg3=pg_query($cn, $query3);
                         $fq3 = pg_fetch_all($pg3);

                        
                        if( $fq3[0]['count'] > 0){
                           

                            $query = "UPDATE tbl_survey_details SET installed_status='$status' WHERE service_order = '$so'";
                            $pg = pg_query($cn,$query);

                            $query1= "SELECT * FROM tbl_survey_details WHERE service_order='$so'";
                            $pg1 = pg_query($cn,$query1);
                            $fq1 = pg_fetch_all($pg1);

                            $query4= "SELECT count(*) FROM tbl_meter WHERE service_order='$so'";
                            $pg4=pg_query($cn, $query4);
                             $fq4 = pg_fetch_all($pg4);
                             if( $fq4[0]['count'] > 0){
                                $query5 = "DELETE FROM  tbl_meter WHERE service_order='$so'";
                                $pg5=pg_query($cn, $query5);
                             }
                        $query2 = "INSERT INTO tbl_meter(status, old_meter_no, new_meter_no, pic_before, pic_after,pic_3, pic_4,  installation_id, latitude, longitude, geom, service_order )
                        VALUES('$so',
                        '".$sheet->getCell('N'. $j)->getValue()."',
                        '".$sheet->getCell('P'. $j)->getValue()."',
                        '".$sheet->getCell('S'. $j)->getValue()."',
                        '".$sheet->getCell('S'. $j+1)->getValue()."',
                        '".$sheet->getCell('S'. $j+2)->getValue()."',
                        '".$sheet->getCell('S'. $j+3)->getValue()."',
                        '".$fq1[0]['installation']."',
                        '".$fq1[0]['latitude']."',
                        '".$fq1[0]['longitude']."',
                        st_geomfromtext('POINT('||".$fq1[0]['longitude']."||' '||".$fq1[0]['latitude']."||')',4326),
                        '$so')";
                        $pg2=pg_query($query2);
                        }


                       
                    }
                    
                    

               
        }
    }
  
    
    
   		echo "Upload Successfully";
		

        

pg_close($cn);

        
	}



?>