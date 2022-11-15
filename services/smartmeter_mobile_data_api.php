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
        $created_by=$_REQUEST['created_by'];
        $before_pic = $_FILES["before_pic"]["name"];
        $before_tempname = $_FILES["before_pic"]["tmp_name"];
        $folder1 = "./image/" . $before_pic;
        $after_pic = $_FILES["after_pic"]["name"];
        $after_tempname = $_FILES["after_pic"]["tmp_name"];
        $folder2 = "./image/" . $after_pic;

            $sql = "INSERT INTO public.tbl_meter(
                status, old_meter_no, new_meter_no, phase, remarks, pic_before, pic_after, 
                created_by)
                VALUES ('$status','$old_meter','$new_meter', '$phase', '$remarks', '$before_pic',
                 '$after_pic','$created_by');";


        $output = array();

        $result_query = pg_query($sql);
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