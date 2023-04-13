<?php
/* Reporte de operaciones */
$initDayMonthprevious = $startdate;
$lastDayMonthprevious = $enddate;
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.zoom.us/v2/report/operationlogs?from='.$initDayMonthprevious.'&to='.$lastDayMonthprevious.'&page_size=10',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik1uSWVKM1hoUkFPQmdoWE5yRG5WWHciLCJleHAiOjE2NjUyMTkzNjAsImlhdCI6MTYzMzA3ODU5Mn0.7qpm6ZxNZMpVR5o6HZUpUjspkCVtuKinElkiTQsWcBs',
        'Cookie: cred=429E729D3F5BCEE53EB760E8EF15FD6F'
    ),
));

$operaciones = curl_exec($curl);

curl_close($curl);
$operaciones  = json_decode($operaciones);