<?php
session_start();
include 'connection.php';
$output = array();



$sql1="select count(*) from tbl_survey_details";
$sql2="select count(*) from tbl_survey_details where installed_status='Unsurveyed'";
$sql3="select count(*) from tbl_survey_details where installed_status='Installed'";
$sql4="select count(*) from tbl_survey_details where installed_status='TRAS'";
$sql5="select count(*) from tbl_survey_details where installed_status ='0'";
$sql6="select count(*) from tbl_survey_details where week_no =(select  max(week_no) from tbl_survey_details) and installed_status<>''";

//echo $sql1."<br/>";
$query1=pg_query($sql1);
$query2=pg_query($sql2);
$query3=pg_query($sql3);
$query4=pg_query($sql4);
$query5=pg_query($sql5);
$query6=pg_query($sql6);


if($query1)
{
    $output['total'] = pg_fetch_all($query1);
}
if($query2)
{
    $output['not_surveyed'] = pg_fetch_all($query2);
}
if($query3)
{
    $output['sodium'] = pg_fetch_all($query3);
}
if($query4)
{
    $output['watt'] = pg_fetch_all($query4);
}
if($query5)
{
    $output['today'] = pg_fetch_all($query5);
}
if($query6)
{
    $output['week'] = pg_fetch_all($query6);
}
echo  json_encode($output);

?>