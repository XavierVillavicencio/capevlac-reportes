<?php

/* Reporte consumo nube */
$curl = curl_init();
$initDayMonth = $startdate;
$lastDayMonth = $enddate;

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.zoom.us/v2/report/cloud_recording?from='.$initDayMonth.'&to='.$lastDayMonth,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik1uSWVKM1hoUkFPQmdoWE5yRG5WWHciLCJleHAiOjE2NjUyMTkzNjAsImlhdCI6MTYzMzA3ODU5Mn0.7qpm6ZxNZMpVR5o6HZUpUjspkCVtuKinElkiTQsWcBs',
        'Cookie: cred=1F12C4E418C83DDE8FD73758742FAD6F'
    ),
));

$reportCloud = curl_exec($curl);

curl_close($curl);
$reportCloud =  json_decode($reportCloud);
