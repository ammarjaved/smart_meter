<?php
session_start();
include 'connection.php';
$output = array();





    $year_sql = "select MAX(year) from tbl_survey_details";
    $year_q= pg_query($year_sql);
    $year_f =pg_fetch_all($year_q);
    $year = $year_f[0]['max'];
     
    $month_sql = "select MAX(month) from tbl_survey_details where year = '$year'";
    $month_q= pg_query($month_sql);
    $month_f = pg_fetch_all($month_q);
    $month = $month_f[0]['max'];

    $week_sql= "select MAX(week_no) from tbl_survey_details where month = '$month'";
    $week_q = pg_query($week_sql);
    $week_f = pg_fetch_all($week_q);
    $week = $week_f[0]['max'];
    $output['year'] = $year;
    $output['month'] = $month;
    $output['week'] = $week;


echo  json_encode($output);

?>