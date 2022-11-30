<?php
session_start();
include 'connection.php';
$output = array();

$sql1 = "select distinct year from tbl_survey_details";
$sql2 = "select distinct month from tbl_survey_details";
$sql3 = "select distinct week_no from tbl_survey_details";



$query1=pg_query($sql1);
$query2=pg_query($sql2);
$query3=pg_query($sql3);



if($query1)
{
    $output['year'] = pg_fetch_all($query1);
}
if($query2)
{
    $output['month'] = pg_fetch_all($query2);
}
if($query3)
{
    $output['week'] = pg_fetch_all($query3);
}

echo  json_encode($output);

?>