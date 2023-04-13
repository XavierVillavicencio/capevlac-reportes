<?php


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.zoom.us/v2/users/q_N_gQG9RhquUoO40Zl-tA/meetings',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik1uSWVKM1hoUkFPQmdoWE5yRG5WWHciLCJleHAiOjE2NjUyMTkzNjAsImlhdCI6MTYzMzA3ODU5Mn0.7qpm6ZxNZMpVR5o6HZUpUjspkCVtuKinElkiTQsWcBs',
        'Cookie: _zm_ssid=us02_c_YkyAk18xSa-7smnNQ3k21Q; cred=AACB30A25862632A221709EEF650879E'
    ),
));
$reuniones = json_decode(curl_exec($curl));
curl_close($curl);

