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

$cn = pg_connect("host=121.121.232.54 port=5433 user=postgres dbname=smart_meter password=Admin123");
	if (!$cn) { echo "DB not connected " ; exit();}


	for ($i=0; $i < $total_sheets; $i++) { 

		$sheet = $spreadsheet->getSheet($i);
		$t_col = $sheet->getHighestColumn();
		$r_row = $sheet->getHighestRow();
		echo "<br><br><br>";
	// exit();
		if( $sheet->getCell('A1')->getValue() == "State" &&  $sheet->getCell('BR1')->getValue() == "finalise date " ){
			for ($j=2; $j < $r_row +1; $j++) { 
				// echo $sheet->getCell('G'. $j)->getValue();
				// exit();
				$br = '';
				$bq = '';
				if ($sheet->getCell('BQ'. $j)->getValue() != '') {
					# code...
					// echo "asd";
					// exit();
				
					$START_MONTH =(int) $sheet->getCell('BQ'. $j)->getValue();
			 		$st_date = ($START_MONTH - 25569) * 86400;
			 		$bq = gmdate("Y-m-d" ,$st_date);
					$finalise_date = $sheet->getCell('BR'. $j)->getValue();
					echo $f_date = ($finalise_date - 25569) * 86400;
					$br = gmdate("Y-m-d" ,$f_date);

				}

				$query = "INSERT INTO tbl_survey_details( state, station, station_description,installation, contract_acc, 
				telephone_no, b_partner, customer_name, address, latitude, longitude, voltage_level, rate_category, 
				installation_type, logical_device_no, device_no, device_cat, register_group, meter_installation_date, 
				dat,controlling_device, portion, mr_unit, mru_description, ip_no, ams, amcg, landlord_tenant, 
				installation_no_landlord_tenant, edited_subcluster, edited_tp_cluster, vlookup, ori_sub_cluster,
				 ori_tp_cluster, duplicate_installation, duplicate_contract_acc, gps_changed, premise_type, meter_type, 
				 sequence, so_batch, batch, service_order, comm_type, version_zdm, premise_status, status, area, sub_cluster, 
				 status_so, bcrm_business_status, pic, tier, sub_cluster_description, progress, unique_id, date_of_so_creation,
				  date_of_letter_sent_to_bilik_gerakan, scattered_cleansing, expiry_date, batch_remark, mru_sequence, 
				  premise_type_cleansing_description, installation_sequence, change_of_tenant_status, subcluster_readiness,
				   adjusted_final_week, kkb_team, start_month, finalise_date,geom)
					VALUES ( 
						'".$sheet->getCell('A'. $j)->getValue()."',
						'".$sheet->getCell('B'. $j)->getValue()."',
						'".$sheet->getCell('C'. $j)->getValue()."',
						'".$sheet->getCell('D'. $j)->getValue()."',
						'".$sheet->getCell('E'. $j)->getValue()."',
						'".$sheet->getCell('F'. $j)->getValue()."',
						'".$sheet->getCell('G'. $j)->getValue()."',
						'".$sheet->getCell('H'. $j)->getValue()."',
					    '".$sheet->getCell('I'. $j)->getValue()."',
						'".$sheet->getCell('J'. $j)->getValue()."',
						'".$sheet->getCell('K'. $j)->getValue()."',
						'".$sheet->getCell('L'. $j)->getValue()."',
						'".$sheet->getCell('M'. $j)->getValue()."',
						'".$sheet->getCell('N'. $j)->getValue()."',
						'".$sheet->getCell('O'. $j)->getValue()."',
					    '".$sheet->getCell('P'. $j)->getValue()."',
					    '".$sheet->getCell('Q'. $j)->getValue()."',
					    '".$sheet->getCell('R'. $j)->getValue()."',
						'".$sheet->getCell('S'. $j)->getValue()."',
						'".$sheet->getCell('T'. $j)->getValue()."',
						'".$sheet->getCell('U'. $j)->getValue()."',
						'".$sheet->getCell('V'. $j)->getValue()."',
					    '".$sheet->getCell('W'. $j)->getValue()."',
					    '".$sheet->getCell('X'. $j)->getValue()."',
					    '".$sheet->getCell('Y'. $j)->getValue()."',
						'".$sheet->getCell('Z'. $j)->getValue()."',
					    '".$sheet->getCell('AA'. $j)->getValue()."',
						'".$sheet->getCell('AB'. $j)->getValue()."',
					    '".$sheet->getCell('AC'. $j)->getValue()."',
					    '".$sheet->getCell('AD'. $j)->getValue()."',
					    '".$sheet->getCell('AE'. $j)->getValue()."',
					    '".$sheet->getCell('AF'. $j)->getValue()."', 
					   	'".$sheet->getCell('AG'. $j)->getValue()."', 
					   	'".$sheet->getCell('AH'. $j)->getValue()."', 
					   	'".$sheet->getCell('AI'. $j)->getValue()."', 
					   	'".$sheet->getCell('AJ'. $j)->getValue()."', 
					   	'".$sheet->getCell('AK'. $j)->getValue()."', 
					   	'".$sheet->getCell('AL'. $j)->getValue()."', 
					   	'".$sheet->getCell('AM'. $j)->getValue()."', 
					   	'".$sheet->getCell('AN'. $j)->getValue()."', 
					   	'".$sheet->getCell('AO'. $j)->getValue()."', 
					   	'".$sheet->getCell('AP'. $j)->getValue()."', 
					   	'".$sheet->getCell('AQ'. $j)->getValue()."', 
					   	'".$sheet->getCell('AR'. $j)->getValue()."', 
					   	'".$sheet->getCell('AS'. $j)->getValue()."', 
					   	'".$sheet->getCell('AT'. $j)->getValue()."', 
					   	'".$sheet->getCell('AU'. $j)->getValue()."', 
					   	'".$sheet->getCell('AV'. $j)->getValue()."', 
					   	'".$sheet->getCell('AW'. $j)->getValue()."', 
					   	'".$sheet->getCell('AX'. $j)->getValue()."', 
					   	'".$sheet->getCell('AY'. $j)->getValue()."', 
					   	'".$sheet->getCell('AZ'. $j)->getValue()."', 
					    '".$sheet->getCell('BA'. $j)->getValue()."',
					    '".$sheet->getCell('BB'. $j)->getValue()."', 
					    '".$sheet->getCell('BC'. $j)->getValue()."', 
					    '".$sheet->getCell('BD'. $j)->getValue()."', 
					    '".$sheet->getCell('BE'. $j)->getValue()."', 
					    '".$sheet->getCell('BF'. $j)->getValue()."', 
					    '".$sheet->getCell('BG'. $j)->getValue()."', 
					    '".$sheet->getCell('BH'. $j)->getValue()."', 
					    '".$sheet->getCell('BI'. $j)->getValue()."', 
					    '".$sheet->getCell('BJ'. $j)->getValue()."', 
					    '".$sheet->getCell('BK'. $j)->getValue()."', 
					    '".$sheet->getCell('BL'. $j)->getValue()."', 
					    '".$sheet->getCell('BM'. $j)->getValue()."', 
					    '".$sheet->getCell('BN'. $j)->getValue()."', 
					    '".$sheet->getCell('BO'. $j)->getValue()."', 
					    '".$sheet->getCell('BP'. $j)->getValue()."', 
					    '".$bq."',
						'".$br."',
						st_geomfromtext('POINT('||".$sheet->getCell('k'. $j)->getValue()."||' '||".$sheet->getCell('j'. $j)->getValue()."||')',4326))";
						 //echo $query;
                        //exit(); 
						pg_query($cn , $query);
	// exit();
			}
			// exit();
		}
	}
pg_close($cn);
// exit();
}


?>