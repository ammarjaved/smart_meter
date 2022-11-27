<?php
session_start();
include("connection.php");
class Divisions extends connection
{
    function __construct()
    {
        $this->connectionDB();

    }
    public function loadData()
    {

        $key=$_GET['key'];
        $tblname = $_REQUEST['tblname'];

        if ($tblname == 'so') {
            $sql = "select service_order from public.tbl_survey_details where service_order ilike '%{$key}%' limit 10;";
        } else if ($tblname == 'meter_no') {
            $sql = "select device_no from public.tbl_survey_details where device_no ilike '%{$key}%' limit 10;";
        } 

        $output = array();

        $result_query = pg_query($sql);
        if($result_query)
        {
           // $output = pg_fetch_assoc($result_query);
            while($row=pg_fetch_assoc($result_query))
            {
                if ($tblname == 'so') {
                    $output[] = $row['service_order'];
                } else if ($tblname == 'meter_no') {
                    $output[] = $row['device_no'];
                }
            }
        }

        $this->closeConnection();
        return json_encode($output);
    }

}

$json = new Divisions();
echo $json->loadData();
?>