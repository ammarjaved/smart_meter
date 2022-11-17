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

// echo $_POST['name'];
// exit();


$cn = pg_connect("host=121.121.232.54 port=5433 user=postgres dbname=smart_meter password=Admin123");
if ($cn) {
	# code...
	// echo "Conected";
	
	// echo $tet->station;
}

$sheet = $spreadsheet->getActiveSheet();
$t_col = $sheet->getHighestColumn();

$r_row = $sheet->getHighestRow();

for ($j=2; $j < $r_row + 1; $j++) { 
	// echo $j."<br>";
		$START_MONTH =(int) $sheet->getCell('BQ'. $j)->getValue();
		 $st_date = ($START_MONTH - 25569) * 86400;

	 $finalise_date = $sheet->getCell('BR'. $j)->getValue();
	// exit();
	echo $f_date = ($finalise_date - 25569) * 86400;
// echo ;
// exit();
	// echo $sheet->getCell('B'. $j)->getValue();
	// exit();
		$query = "INSERT INTO tbl_survey_details(
	state, station, station_description, installation, contract_acc, telephone_no, b_partner, customer_name, address, latitude, longitude, voltage_level, rate_category, installation_type, logical_device_no, device_no, device_cat, register_group, meter_installation_date, dat, controlling_device, portion, mr_unit, mru_description, ip_no, ams, amcg, landlord_tenant, installation_no_landlord_tenant, edited_subcluster, edited_tp_cluster, vlookup, ori_sub_cluster, ori_tp_cluster, duplicate_installation, duplicate_contract_acc, gps_changed, premise_type, meter_type, sequence, so_batch, batch, service_order, comm_type, version_zdm, premise_status, status, area, sub_cluster, status_so, bcrm_business_status, pic, tier, sub_cluster_description, progress, unique_id, date_of_so_creation, date_of_letter_sent_to_bilik_gerakan, scattered_cleansing, expiry_date, batch_remark, mru_sequence, premise_type_cleansing_description, installation_sequence, change_of_tenant_status, subcluster_readiness, adjusted_final_week, kkb_team, start_month, finalise_date)
	VALUES ( '".$sheet->getCell('A'. $j)->getValue()."',
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
    '".gmdate("Y-m-d" ,$st_date)."',
	'".gmdate("Y-m-d" ,$f_date)."')";
	// echo $query;

	$tet = pg_query($cn, $query);
		// exit();
	
}
pg_close($cn);
// exit();
}

		// echo $state = $sheet->getCell('A'. $j)->getValue();
		// echo $station = $sheet->getCell('B'. $j)->getValue();
		// echo $Station_Description = $sheet->getCell('C'. $j)->getValue();
		// echo $Installation = $sheet->getCell('D'. $j)->getValue();
		// echo $Contract_Acc = $sheet->getCell('E'. $j)->getValue();
		// echo $Telephone_No = $sheet->getCell('F'. $j)->getValue();
		// echo $Partner = $sheet->getCell('G'. $j)->getValue();
		// echo $Customer_Name = $sheet->getCell('H'. $j)->getValue();
		// echo $Address = $sheet->getCell('I'. $j)->getValue();
		// echo $Latitude = $sheet->getCell('J'. $j)->getValue()."  ";
		// echo $Longitude = $sheet->getCell('K'. $j)->getValue()."  ";
		// echo $Voltage_Level = $sheet->getCell('L'. $j)->getValue()."  ";

		// echo $Rate_Category = $sheet->getCell('M'. $j)->getValue()."  ";
		// echo $Installation_Type = $sheet->getCell('N'. $j)->getValue()."  ";
		// echo $Logical_device_no = $sheet->getCell('O'. $j)->getValue()."  ";
		// echo $Device_No = $sheet->getCell('P'. $j)->getValue()."  ";
		// echo $Device_Cat = $sheet->getCell('Q'. $j)->getValue()."  ";

		// echo $Register_Group = $sheet->getCell('R'. $j)->getValue()."  ";
		// echo $Meter_Installation_Date = $sheet->getCell('S'. $j)->getValue()."  ";
		
		// echo $DAT = $sheet->getCell('T'. $j)->getValue()."  ";

		// echo $Controlling_Device = $sheet->getCell('U'. $j)->getValue()."  ";
		// echo $Portion = $sheet->getCell('V'. $j)->getValue()."  ";
		// echo $MR_Unit = $sheet->getCell('W'. $j)->getValue()."  ";
		// echo $MRU_Description = $sheet->getCell('X'. $j)->getValue()."  ";
		// echo $IP_No = $sheet->getCell('Y'. $j)->getValue()."  ";
		// echo $AMS = $sheet->getCell('Z'. $j)->getValue()."  ";

		// echo $AMCG = $sheet->getCell('AA'. $j)->getValue()."  ";
		// echo $Landlord_Tenant = $sheet->getCell('AB'. $j)->getValue()."  ";

		// echo $Installation_No_Landlord_Tenant = $sheet->getCell('AC'. $j)->getValue()."  ";
		// echo $EDITED_SUBCLUSTER = $sheet->getCell('AD'. $j)->getValue()."  ";
		// echo $PREMISE_TYPEEDITED_TP_CLUSTER = $sheet->getCell('AE'. $j)->getValue()."  ";

		// echo $VLOOKUP = $sheet->getCell('AF'. $j)->getValue()."  ";
		// echo $Ori_SUB_CLUSTER = $sheet->getCell('AG'. $j)->getValue()."  ";
		// echo $Ori_TP_CLUSTER = $sheet->getCell('AH'. $j)->getValue()."  ";
		// echo $Duplicate_Installation = $sheet->getCell('AI'. $j)->getValue()."  ";
		// echo $Duplicate_Contract_Acc = $sheet->getCell('AJ'. $j)->getValue()."  ";
		// echo $GPS_CHANGED = $sheet->getCell('AK'. $j)->getValue()."  ";
		// echo $PREMISE_TYPE = $sheet->getCell('AL'. $j)->getValue()."  ";
		// echo $Meter_type = $sheet->getCell('AM'. $j)->getValue()."  ";
		// echo $Sequence = $sheet->getCell('AN'. $j)->getValue()."  ";
		// echo $SO_Batch = $sheet->getCell('AO'. $j)->getValue()."  ";
		// echo $Batch = $sheet->getCell('AP'. $j)->getValue()."  ";
		// echo $Service_Order = $sheet->getCell('AQ'. $j)->getValue()."  ";
		// echo $Comm_Type = $sheet->getCell('AR'. $j)->getValue()."  ";
		// echo $Version_ZDM = $sheet->getCell('AS'. $j)->getValue()."  ";
		// echo $Premise_Status = $sheet->getCell('AT'. $j)->getValue()."  ";
		// echo $Status = $sheet->getCell('AU'. $j)->getValue()."  ";
		// echo $Area = $sheet->getCell('AV'. $j)->getValue()."  ";
		// echo $Sub_Cluster = $sheet->getCell('AW'. $j)->getValue()."  ";
		// echo $Status_SO = $sheet->getCell('AX'. $j)->getValue()."  ";
		// echo $BCRM_Business_Status = $sheet->getCell('AY'. $j)->getValue()."  ";
		// echo $PIC = $sheet->getCell('AZ'. $j)->getValue()."  ";
		// echo $TIER = $sheet->getCell('BA'. $j)->getValue() ."  ";
		// echo $Sub_Cluster_Description = $sheet->getCell('BB'. $j)->getValue()."  ";
		// echo $Progress = $sheet->getCell('BC'. $j)->getValue()."  ";
		// echo $Unique_ID = $sheet->getCell('BD'. $j)->getValue()."  ";

		// echo $Date_of_SO_Creation = $sheet->getCell('BE'. $j)->getValue()."  ";
		// echo $Date_of_Letter_Sent_to_Bilik_Gerakan = $sheet->getCell('BF'. $j)->getValue()."  ";
		// echo $Scattered_Cleansing = $sheet->getCell('BG'. $j)->getValue()."  ";
		// echo $Expiry_Date = $sheet->getCell('BH'. $j)->getValue()."  ";
		// echo $Batch_Remark = $sheet->getCell('BI'. $j)->getValue()."  ";
		// echo $MRU_Sequence = $sheet->getCell('BJ'. $j)->getValue()."  ";
		// echo $Premise_Type_Cleansing_Description = $sheet->getCell('BK'. $j)->getValue()."  ";
		// echo $Installation_Sequence = $sheet->getCell('BL'. $j)->getValue()."  ";

		// echo $Change_of_Tenant_Status = $sheet->getCell('BM'. $j)->getValue()."  ";
		// echo $Subcluster_Readiness = $sheet->getCell('BN'. $j)->getValue()."  ";
		// echo $adjusted_final_week = $sheet->getCell('BO'. $j)->getValue()."  ";
		// echo $KKB_TEAM = $sheet->getCell('BP'. $j)->getValue()."  ";
?>