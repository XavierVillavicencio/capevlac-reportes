<?php
/* Detalle de la reunión */


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.zoom.us/v2/meetings/'.$_GET['meetingid'].'?show_previous_occurrences=true',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik1uSWVKM1hoUkFPQmdoWE5yRG5WWHciLCJleHAiOjE2NjUyMTkzNjAsImlhdCI6MTYzMzA3ODU5Mn0.7qpm6ZxNZMpVR5o6HZUpUjspkCVtuKinElkiTQsWcBs',
        'Cookie: _zm_ssid=us02_c_YkyAk18xSa-7smnNQ3k21Q; cred=0F5F0A00DAC4A06AC4974EF4344B63C5'
    ),
));

$detalle = json_decode(curl_exec($curl));

curl_close($curl);


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.zoom.us/v2/past_meetings/'.$_GET['meetingid'].'',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik1uSWVKM1hoUkFPQmdoWE5yRG5WWHciLCJleHAiOjE2NjUyMTkzNjAsImlhdCI6MTYzMzA3ODU5Mn0.7qpm6ZxNZMpVR5o6HZUpUjspkCVtuKinElkiTQsWcBs',
        'Cookie: _zm_ssid=us02_c_YkyAk18xSa-7smnNQ3k21Q; cred=F93F0DAEFDFA51251DB0DD9213F708A1'
    ),
));

$response_pasado = json_decode(curl_exec($curl));

curl_close($curl);


$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.zoom.us/v2/meetings/'.$_GET['meetingid'].'/recordings',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik1uSWVKM1hoUkFPQmdoWE5yRG5WWHciLCJleHAiOjE2NjUyMTkzNjAsImlhdCI6MTYzMzA3ODU5Mn0.7qpm6ZxNZMpVR5o6HZUpUjspkCVtuKinElkiTQsWcBs',
        'Cookie: _zm_ssid=us02_c_YkyAk18xSa-7smnNQ3k21Q; cred=209445CC42FE4BEE7786D20EDB7AA35E'
    ),
));

$grabaciones = json_decode(curl_exec($curl));

curl_close($curl);


?>
<h3>Detalle de la reunión <?php echo $detalle->topic ?></h3>
<p><b>Descripción</b> <?php echo $detalle->agenda ?></p>
<p><b>Fecha de creación</b> <?php echo $detalle->created_at ?></p>
<p><b>Minutos totales</b> <?php echo $response_pasado->total_minutes ?></p>
<p><b>Participantes</b> <?php echo $response_pasado->participants_count ?></p>
<p><b>Departamento</b> <?php echo $response_pasado->dept ?></p>
<p><b>Url</b> <?php echo $detalle->start_url ?></p>
<p><b>Estado</b> <?php echo $detalle->status ?></p>
<p><b>Contraseña</b> <?php echo $detalle->password ?></p>
<p><b>Zona horaria</b> <?php echo $detalle->timezone ?></p>
<?php if (!empty($detalle->occurrences)): ?>
<h4>Ocurrencia de las reuniones</h4>
<table class="table table-striped">
    <thead>
    <tr>
        <th>Fecha</th>
        <th>Duración</th>
        <th>Estado</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($detalle->occurrences as $occurrencia): ?>
    <tr>
        <td><?php echo $occurrencia->start_time?></td>
        <td><?php echo $occurrencia->duration?></td>
        <td><?php echo $occurrencia->status?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php if(!empty($grabaciones->recording_files)): ?>
    <h4>Grabaciones</h4>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Enlace</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($grabaciones->recording_files as $grabacion): ?>
            <tr>
                <td><?php echo $grabacion->recording_start?></td>
                <td><a class="btn btn-success btn-sm" target="_blank" href="<?php echo $grabacion->download_url?>">Descargar</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif;?>