<?php
session_start();
include 'connection.php';
$output = array();

Class Dropdowns
{

public function fillDropdown(){
    $lyr = $_REQUEST['lyr'];
    $did = $_REQUEST['did'];


        if ($lyr == 'so') {
            $sql = "select st_x((st_dump(geom)).geom) as x,st_y((st_dump(geom)).geom) as y from public.tbl_survey_details where service_order='$did';";
        } else if ($lyr == 'meter_no') {
            $sql = "select st_x((st_dump(geom)).geom) as x,st_y((st_dump(geom)).geom) as y from public.tbl_survey_details where device_no='$did';";

        }else{
            'not found';
        }

// echo $sql;
// exit();


    $query1 = pg_query($sql);
        $output = pg_fetch_all($query1);
        return $output;
}
}
$rs=new Dropdowns();
echo  json_encode($rs->fillDropdown());

?>