<?php
session_start();
include("connection.php");
class SmartMeterApi extends connection
{
    function __construct()
    {
        $this->connectionDB();

    }
    public function loadData()
    {

        $status=$_REQUEST['status'];
        $old_meter=$_REQUEST['old_meter_no'];
        $new_meter=$_REQUEST['new_meter_no'];
        $phase=$_REQUEST['phase'];
        $remarks=$_REQUEST['remarks'];
        $lon=floatval($_REQUEST['lon']);
        $lat=floatval($_REQUEST['lat']);
        $created_by=$_REQUEST['created_by'];
        $service_order=$_REQUEST['service_order'];
        $installation_id=$_REQUEST['installation_id'];
        $before_pic = $_FILES["before_pic"]["name"];
        $before_tempname = $_FILES["before_pic"]["tmp_name"];
        $folder1 = "./image/" . $before_pic;
        $after_pic = $_FILES["after_pic"]["name"];
        $after_tempname = $_FILES["after_pic"]["tmp_name"];
        $folder2 = "./image/" . $after_pic;
        $pic1='http://121.121.232.54:88/smart_meter/services/image/'.$before_pic;
        $pic2= 'http://121.121.232.54:88/smart_meter/services/image/'.$after_pic;
            $sql = "INSERT INTO public.tbl_meter(
                status, old_meter_no, new_meter_no, phase, remarks, pic_before, pic_after, 
                created_by,installation_id,latitude,longitude,geom,service_order )
                VALUES ('$status','$old_meter','$new_meter', '$phase', '$remarks', '$pic1','$pic2'
                ,'$created_by','$installation_id',$lat,$lon,st_geomfromtext('POINT('||$lon||' '||$lat||')',4326),$service_order);";

          $sql1="update tbl_survey_details set installed_status='$status' where installation='$installation_id'";
        $output = array();

        pg_query($sql);
        pg_query($sql1);
        if (move_uploaded_file($before_tempname, $folder1)) {
            if (move_uploaded_file($after_tempname, $folder2)) {
                  return 'success';
            } else {
                return "failed";
            }

        } else {
            return "failed";
        }
//        if($result_query)
//        {
//           // $output = pg_fetch_assoc($result_query);
//            $output = pg_fetch_all($result_query);
//        }

        $this->closeConnection();
       // return json_encode($output);
    }

}

$json = new SmartMeterApi();
echo $json->loadData();
?>