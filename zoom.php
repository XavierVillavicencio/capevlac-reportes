<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<?php
/*
    wp_9_
    wp_11_
    wp_12_
    wp_2_
    wp_3_
    wp_4_
    wp_5_
    wp_6_
    wp_7_
    wp_8_
    wp_
*/

if(!empty($_REQUEST['start_date'])){
    $datestart = new DateTime($_REQUEST['start_date']);
}else{
    $datestart = new DateTime('now');
}
if(!empty($_REQUEST['end_date'])){
    $dateend = new DateTime($_REQUEST['end_date']);
}else{
    $dateend = new DateTime('now');    
}
$datestart->modify('first day of this month');
$startdate = $datestart->format('Y-n-j');
$dateend->modify('last day of this month');
$enddate =  $dateend->format('Y-n-j');

include ('zoom_calls/diario.php');
include ('zoom_calls/reportenube.php');
include ('zoom_calls/operaciones.php');
include ('zoom_calls/reuniones.php');
?>

<div class="container container-fluid">
    <?php
        if(!empty($_GET['meetingid'])):
    ?>
            <div class="row">
                <div class="col-12">
                    <div class="cardx" style="width: 100%;">
                        <div class="card-body">
                            <?php include ('zoom_calls/detalle.php'); ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-12 mt-5 pt-2">
        <form action="admin.php?page=capevlac-reportes-plugin&tab=zoom">
            <input type="hidden" name="page" value="capevlac-reportes-plugin"/>
            <input type="hidden" name="tab" value="zoom"/>
        <label for="bulk-action-selector-top">Selecciona fecha de inicio:
            <input
                     name="start_date" id="start_date" type="date" placeholder="Fecha de Inicio" />
        </label>
        <label for="end_date">Selecciona fecha de finalización
        <input
                     name="end_date" id="end_date" type="date" placeholder="Fecha de Finalización" />
        </label>
        <button type="submit" class="btn btn-primary">
            Enviar Consulta
        </button>
        </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3 py-3">
            <p><b>Fecha de consulta:</b> <?php print_r($startdate); echo " - "; print_r($enddate); ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="cardx" style="width: 100%;">

                <div class="card-body">
                    <h5 class="card-title">Reuniones</h5>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Título</th>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th>Acción</th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php 


                    $reunion = null;
                        //  or ($reunion->host_id == 'pT051_l1QmOE5oaCFgCMsA')
                        foreach($reuniones->meetings as $reunion){

                            if(($reunion->host_id == 'q_N_gQG9RhquUoO40Zl-tA')){
                                echo "<tr>";
                                echo "<td> ".$reunion->topic."</td>";
                                echo "<td> ".$reunion->start_time."</td>";
                                echo "<td> ".$reunion->agenda."</td>";
                                echo "<td><a href='https://capevlac.olade.org/wp-admin/admin.php?page=capevlac-reportes-plugin&tab=zoom&meetingid=".$reunion->id."' type='button' class='btn btn-info open-my-dialog-x2'>Leer Más</a></td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card">    
                <div class="card-body">
                <h5 class="card-title">Resumen diario de reuniones</h5>
                <!-- {"year":2021,"month":10,"dates":[{"date":"2021-10-01","new_users":0,"meetings":0,"participants":0,"meeting_minutes":0}]} -->
                <p class="card-text">
                    <b>Fecha:</b>
                    <?php echo $dailyDate->date; ?>
                </p>
                <p class="card-text">
                    <b>Nuevos Usuarios:</b>
                    <?php echo $dailyDate->new_users; ?>
                </p>
                    <p class="card-text">
                        <b>Reuniones:</b>
                        <?php echo $dailyDate->meetings; ?>
                    </p>
                <p class="card-text">
                    <b>Participantes:</b>
                    <?php echo $dailyDate->participants; ?>
                </p>
                <p class="card-text">
                    <b>Tiempo de Reuniones:</b>
                    <?php echo $dailyDate->meeting_minutes; ?>
                </p>
                <p class="card-text">
                    <b>Uso espacio contratado:</b>
                    <?php
                    $item = null;
                    
                    foreach($reportCloud->cloud_recording_storage as $item){
                       $date = $item->date;
                       $usage = $item->usage;
                       $plan_usage = $item->plan_usage;
                       $freespace = $item->free_usage;
                    }

                    echo "<div class='row'>";
                    echo "<div class='col-6'><p class='card-text'><b>Fecha:</b> ".$date."</p></div>";
                    echo "<div class='col-6'><p class='card-text'><b>Uso:</b> ".$usage."</p></div>";
                    echo "<div class='col-6'><p class='card-text'><b>Uso del plan:</b> ".$plan_usage."</p></div>";
                    echo "<div class='col-6'><p class='card-text'><b>Espacio Libre:</b> ".$freespace."</p></div>";
                    echo "</div><hr />";
                    ?>
                </p>
            </div>
        </div>
            <div class="cardx">
                <div class="card-body">
                <h5 class="card-title">Resumen de operaciones</h5>
                <!-- {"year":2021,"month":10,"dates":[{"date":"2021-10-01","new_users":0,"meetings":0,"participants":0,"meeting_minutes":0}]} -->
                <p class="card-text">
                    <b>Desde:</b><?php echo $operaciones->from; ?>
                    <b>Hasta:</b><?php echo $operaciones->to; ?>
                </p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Operador</th>
                            <th>Categoría</th>
                            <th>Acción</th>
                            <th>Detalle</th>
                        </tr>
                        </thead>
                        <tbody>
                <?php 
                    $item = null;
                    foreach($operaciones->operation_logs as $item){
                        echo "<tr>";
                        echo "<td> ".$item->time."</td>";
                        echo "<td> ".$item->operator."</td>";
                        echo "<td> ".$item->category_type."</td>";
                        echo "<td> ".$item->action."</td>";
                        echo "<td> ".$item->operation_detail."</td>";
                        echo "</tr>";
                    }
                ?>
                        </tbody>
                    </table>
            </div></div>
        </div>
    </div>
</div>

<style>
    *, ::after, ::before {
        box-sizing: unset !important;
    }
</style>