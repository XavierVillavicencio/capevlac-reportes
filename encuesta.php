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

function returnValue($val){
    if(empty($val)){
        return 1;
    }
    if($val == 'Excelente'){
        return 4;
    }
    if($val == 'Bueno'){
        return 3;
    }
    if($val == 'Regular'){
        return 2;
    }
    if($val == 'Pobre'){
        return 1;
    }

    return 0;
}
$wpPreffix = array('wp_', 'wp_11_', 'wp_12_', 'wp_2_', 'wp_3_', 'wp_4_', 'wp_5_', 'wp_6_', 'wp_7_', 'wp_8_', 'wp_9_');
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
global $wpdb;
$allParticipants = false;
//if ('wp_' == $wpdb->prefix) {
    $cursosEncuesta_json = $wpdb->get_results("SELECT * FROM wp_users_survey");
    foreach ($cursosEncuesta_json as $cursosItem) {
        $values = (array) $cursosItem;
        $coursesEncuesta[$values['course_id']] = $values['course_id'];
    }

    

    $coursesEncuestaF = implode(',', $coursesEncuesta);
    foreach ($wpPreffix as $wpfreffixitem) {
        $coursesTmp = $wpdb->get_results("SELECT ID,post_title FROM " . $wpfreffixitem . "posts WHERE `post_type`='lp_course' and post_status = 'publish' and ID in (" . $coursesEncuestaF . ")");
        foreach ($coursesTmp as $item) {
            $item->scope = $wpfreffixitem;
            $courses[] = $item;
        }
    }

    $course_id = null;
    if (!empty($_REQUEST['courseId'])) {
        $tmpCourseId = explode('||', $_REQUEST['courseId']);
        $course_id = "and " . $tmpCourseId[0] . "learnpress_user_items.`item_id` = " . $tmpCourseId[1];
        $stu = $wpdb->get_results("SELECT distinct user_id,wp_users.* FROM " . $tmpCourseId[0] . "learnpress_user_items,
    wp_users where wp_users.ID = " . $tmpCourseId[0] . "learnpress_user_items.user_id
    " . $course_id);
        $participantes = $wpdb->last_result;

    } else {
        $participantes = null;
    }

/* else {
    $participantes = null;
}*/


$timer = strtotime("now");
if (!empty($_REQUEST['exportxls'])) {
 
}

if (!empty($_REQUEST['exportpdf'])) {

}

?>
<h3>Resumen de la Encuesta</h3>
<div class="tablenav top">
    <div class="alignleft actions bulkactions">
        <form action="admin.php?page=capevlac-reportes-plugin&tab=encuesta">
            <input type="hidden" name="page" value="capevlac-reportes-plugin"/>
            <input type="hidden" name="tab" value="encuesta"/>
            <label for="bulk-action-selector-top" class="screen-reader-text">Selecciona un curso</label>
            <select
                    name="courseId" id="courseId">
                <option value="0">
                    Seleccionar un curso
                </option>
                <?php
                foreach ($courses as $course) {
                    $courseSelected = null;
                    $tmpCourseId = explode('||', $_REQUEST['courseId']);

                    if (!empty($tmpCourseId[1]) && $course->ID == $tmpCourseId[1]) {
                        $courseSelected = "selected='selected'";
                    }
                    ?>
                    <option value="<?php echo $course->scope ?>||<?php echo $course->ID ?>" <?php echo $courseSelected; ?>>
                        <?php echo $course->post_title ?>
                    </option>
                <?php }
                ?>
            </select>
            <!--
            <input type="submit" id="doaction" class="button action" value="Aplicar">-->
            <input type="submit" id="post-query-submit" class="button" value="Mostrar Resultados">
        </form>
    </div>
    <div class="alignleft actions">
        <script>
            jQuery(function () {
                jQuery('#export_xls').click(function () {
                    let courseId = jQuery('#courseId').val()
                    let url = window.location.href + '&exportxls=true'
                    window.open(url, '_blank').focus()
                })
                jQuery('#export_pdf').click(function () {
                    let courseId = jQuery('#courseId').val()
                    let url = window.location.href + '&exportpdf=true'
                    window.open(url, '_blank').focus()
                })
            })
        </script>
        
        <input type="submit" name="export"  onclick="printDiv('printableArea')" class="button" value="Exportar"/>
    </div>

    <br class="clear">
</div>
<div id="printableArea" class="text-center" style="text-align: center;">
    <table class="wp-list-table widefat fixed striped table-view-list posts" style="width:800px; text-align:center;">
        <tbody id="the-list" data-wp-lists="list:post">
        <?php if (empty($participantes)): ?>
            <tr>
                <th colspan="10">
                    <div class="alert alert-danger">
                        No existen resultados / Debes seleccionar un curso
                    </div>
                </th>
            </tr>
        <?php else:
        $i = 0;
        $totalParticipantes = 0;
        $AccesoOportunoALosMarteriales = 0;
        $ActualidadDeLosContenidos = 0;
        $AdecuacionDelTiempoDeDesarrolloDelCurso = 0;
        $AlcanceyNivelDeLosContenidos = 0;
        $AtencionTiempoProblemasTecnicos = 0;
        $CapacidadParaDespertarInteres = 0;
        $ClaridadDeLosEnunciadosYPreguntas = 0;
        $ClaridadEnunciadosYPreguntas = 0;
        $ComunicacionEficazParticipantes = 0;
        $ConsistenciaEnRelacionConLosObjetivos = 0;
        $CoordinacionGeneralSesiones = 0;
        $DivulgacionOportunaDelCurso = 0;
        $DominioDelTema = 0;
        $EcuanimidadRespetoEnElTrato = 0;
        $EjerciciosAdecuadosALosObjetivos = 0;
        $EjerciciosAdecuadosObjetivos = 0;
        $EvaluacionDeLaPlataformaTecnologica = 0;
        $FacilidadDeManejoDelSistema = 0;
        $HabilidadesParaTransmitirElConocimiento = 0;
        $InteraccionConElInstructorParaLaResolucion = 0;
        $NivelAplicabilidad = 0;
        $NivelImpactoEnOrganizacion = 0;
        $RecursosDisponiblesEnElSistema = 0;
        foreach ($participantes as $participante):
            $i++;
            $tmpCourseId = explode('||', $_REQUEST['courseId']);
            $participante_json = $wpdb->get_results("SELECT * FROM wp_users_registered where wp_id = " . $participante->user_id . "");
            
            if (empty($participante_json)) {
                continue;
            } else {
                $values = (array) $participante_json[0];
                $values['form_id'] = $participante_json[0]->id;
            }
            $encuesta_json = $wpdb->get_results("SELECT * FROM wp_users_survey where wp_id = ".$participante->user_id." 
                    and course_id = ".$tmpCourseId[1]);
            
            if(empty($encuesta_json)){
                continue;
            }else{
                
                $encuestasinserializar= $encuesta_json[0]->id;
                $encuesta_json[0] = (array) $encuesta_json[0];
                             /* DEBUG */
                             /*
                             echo "<code>";
                             echo $AccesoOportunoALosMarteriales;
                             echo "||||";
                             echo "</code><hr />";
                             echo "<pre>";
                             echo print_r($encuesta_json[0],true);
                             echo "</pre><hr />";
                             echo "<code>";
                             echo "||||";
                             echo print_r($encuesta_json[0]['AccesoOportunoALosMarteriales'][0]);
                             echo "</code><hr />";*/

                $AccesoOportunoALosMarteriales = $AccesoOportunoALosMarteriales + returnValue($encuesta_json[0]['AccesoOportunoALosMarteriales']);
                $ActualidadDeLosContenidos = $ActualidadDeLosContenidos + returnValue($encuesta_json[0]['ActualidadDeLosContenidos']);
                $AdecuacionDelTiempoDeDesarrolloDelCurso = $AdecuacionDelTiempoDeDesarrolloDelCurso + returnValue($encuesta_json[0]['AdecuacionDelTiempoDeDesarrolloDelCurso']);
                $AlcanceyNivelDeLosContenidos = $AlcanceyNivelDeLosContenidos + returnValue($encuesta_json[0]['AlcanceyNivelDeLosContenidos']);
                $AtencionTiempoProblemasTecnicos = $AtencionTiempoProblemasTecnicos + returnValue($encuesta_json[0]['AtencionTiempoProblemasTecnicos']);
                $CapacidadParaDespertarInteres = $CapacidadParaDespertarInteres + returnValue($encuesta_json[0]['CapacidadParaDespertarInteres']);
                $ClaridadDeLosEnunciadosYPreguntas = $ClaridadDeLosEnunciadosYPreguntas + returnValue($encuesta_json[0]['ClaridadDeLosEnunciadosYPreguntas']);
                $ClaridadEnunciadosYPreguntas = $ClaridadEnunciadosYPreguntas + returnValue($encuesta_json[0]['ClaridadEnunciadosYPreguntas']);
                $ComunicacionEficazParticipantes = $ComunicacionEficazParticipantes + returnValue($encuesta_json[0]['ComunicacionEficazParticipantes']);
                $ConsistenciaEnRelacionConLosObjetivos = $ConsistenciaEnRelacionConLosObjetivos + returnValue($encuesta_json[0]['ConsistenciaEnRelacionConLosObjetivos']);
                $CoordinacionGeneralSesiones = $CoordinacionGeneralSesiones + returnValue($encuesta_json[0]['CoordinacionGeneralSesiones']);
                $DivulgacionOportunaDelCurso = $DivulgacionOportunaDelCurso + returnValue($encuesta_json[0]['DivulgacionOportunaDelCurso']);
                $DominioDelTema = $DominioDelTema + returnValue($encuesta_json[0]['DominioDelTema']);
                $EcuanimidadRespetoEnElTrato = $EcuanimidadRespetoEnElTrato + returnValue($encuesta_json[0]['EcuanimidadRespetoEnElTrato']);
                $EjerciciosAdecuadosALosObjetivos = $EjerciciosAdecuadosALosObjetivos + returnValue($encuesta_json[0]['EjerciciosAdecuadosALosObjetivos']);
                $EjerciciosAdecuadosObjetivos = $EjerciciosAdecuadosObjetivos + returnValue($encuesta_json[0]['EjerciciosAdecuadosObjetivos']);
                $EvaluacionDeLaPlataformaTecnologica = $EvaluacionDeLaPlataformaTecnologica + returnValue($encuesta_json[0]['EvaluacionDeLaPlataformaTecnologica']);
                $FacilidadDeManejoDelSistema = $FacilidadDeManejoDelSistema + returnValue($encuesta_json[0]['FacilidadDeManejoDelSistema']);
                $HabilidadesParaTransmitirElConocimiento = $HabilidadesParaTransmitirElConocimiento + returnValue($encuesta_json[0]['HabilidadesParaTransmitirElConocimiento']);
                $InteraccionConElInstructorParaLaResolucion = $InteraccionConElInstructorParaLaResolucion + returnValue($encuesta_json[0]['InteraccionConElInstructorParaLaResolucion']);
                $NivelAplicabilidad = $NivelAplicabilidad + returnValue($encuesta_json[0]['NivelAplicabilidad']);
                $NivelImpactoEnOrganizacion = $NivelImpactoEnOrganizacion + returnValue($encuesta_json[0]['NivelImpactoEnOrganizacion']);
                $RecursosDisponiblesEnElSistema = $RecursosDisponiblesEnElSistema + returnValue($encuesta_json[0]['RecursosDisponiblesEnElSistema']);
                $totalParticipantes++;
            }
            
            
            $particpantesHtml .=' <tr id="participanteEncuesta<?php echo $participante_json[0]->form_id ?>">
                <td scope="col" class="manage-column column-email column-primary sortable desc">
                        <span>'.$values['ci'].'</span>
                </td>
                <td scope="col" class="manage-column column-email column-primary sortable desc">
                    <span>'.$values['nombres'] . ' ' . $values['apellidos'].'</span>
                </td>

                <td scope="col" class="manage-column column-email column-primary sortable desc">
                    <span>'.$values["genero"].'</span>
                </td>
                <td scope="col" class="manage-column column-email column-primary sortable desc">
                    '.$values['fechadenacimiento'].'
                </td>
                <td scope="col" class="manage-column column-email column-primary sortable desc">
                    <span>'.$values['correoInstitucional'].'</span>
                </td>
                <td scope="col" class="manage-column column-email column-primary sortable desc">
                    <a class="open-my-dialog" data-date="'.$encuesta_json[0]->form_date.'" data-encuesta="'.base64_encode(json_encode($encuesta_json[0])).'" href="#">
                        <span>Ver Encuesta</span>
                    </a>
                </td>
            </tr>';
            ?>

        <?php endforeach; ?>

        <?php
        /* Totales Resumen Divulgacion */
        $divulgacionOportunaDelCurso = $DivulgacionOportunaDelCurso / $totalParticipantes;
        $accesoOportunoALosMateriales = $AccesoOportunoALosMarteriales / $totalParticipantes;
        $adecuacionDelTiempoDeDesarrolloDelCurso = $AdecuacionDelTiempoDeDesarrolloDelCurso / $totalParticipantes;
        $totalOportunidadDeLaDivulgacion = (($divulgacionOportunaDelCurso + $accesoOportunoALosMateriales + $adecuacionDelTiempoDeDesarrolloDelCurso)*100)/12;
        /* Totales Contenido de las exposiciones */
        $totalConsistenciaEn = $ConsistenciaEnRelacionConLosObjetivos / $totalParticipantes;
        $totalAlcanceYNivelDeLosContenidos = $AlcanceyNivelDeLosContenidos / $totalParticipantes;
        $totalActualidadDeLosContenidos = $ActualidadDeLosContenidos / $totalParticipantes;
        $totalContenidoDivulgacion = (($totalActualidadDeLosContenidos + $totalAlcanceYNivelDeLosContenidos + $totalConsistenciaEn)*100)/12;
        /* Totales Instructor */
        $totalDominioDelTema = $DominioDelTema / $totalParticipantes;
        $totalHabilidadesParaTransmitirElConocimiento = $HabilidadesParaTransmitirElConocimiento / $totalParticipantes;
        $totalCapacidadParaDespertarInteres = $CapacidadParaDespertarInteres / $totalParticipantes;
        $totalEcuanimidadRespetoEnElTrato = $EcuanimidadRespetoEnElTrato / $totalParticipantes;
        $totalInstructor = (($totalDominioDelTema + $totalHabilidadesParaTransmitirElConocimiento + $totalCapacidadParaDespertarInteres+$totalEcuanimidadRespetoEnElTrato)*100)/16;
        /* Totales coordinación */
        $totalCoordinacionGeneralSesiones = $CoordinacionGeneralSesiones / $totalParticipantes;
        $totalComunicacionEficazParticipantes = $ComunicacionEficazParticipantes / $totalParticipantes;
        $totalAtencionTiempoProblemasTecnicos = $AtencionTiempoProblemasTecnicos / $totalParticipantes;
        $totalCoordinacionGeneral = (($totalCoordinacionGeneralSesiones + $totalComunicacionEficazParticipantes + $totalAtencionTiempoProblemasTecnicos)*100)/12;
        /* Totales Material de estudio */
        $totalClaridadEnunciadosYPreguntas = $ClaridadEnunciadosYPreguntas / $totalParticipantes;
        $totalEjerciciosAdecuadosALosObjetivos = $EjerciciosAdecuadosALosObjetivos / $totalParticipantes;
        $totalMaterialDeEstudio = (($totalClaridadEnunciadosYPreguntas + $totalEjerciciosAdecuadosALosObjetivos)*100)/8;
        /* Totales coordinación */
        $totalInteraccionConElInstructorParaLaResolucion = $InteraccionConElInstructorParaLaResolucion / $totalParticipantes;
        $totalEvaluacionEjercicios = (($totalInteraccionConElInstructorParaLaResolucion + $totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas)*100)/12;
        /* Totales Sistema de Comunicación virtual SICVE */
        $totalEvaluacionDeLaPlataformaTecnologica = $EvaluacionDeLaPlataformaTecnologica / $totalParticipantes;
        $totalFacilidadDeManejoDelSistema = $FacilidadDeManejoDelSistema / $totalParticipantes;
        $totalRecursosDisponiblesEnElSistema = $RecursosDisponiblesEnElSistema / $totalParticipantes;
        $totalSistemaDeComunicacionVirtual = (($totalInteraccionConElInstructorParaLaResolucion + $totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas)*100)/12;
        /* Totales Resultados esperados */
        $totalEvaluacionDeLaPlataformaTecnologica = $EvaluacionDeLaPlataformaTecnologica / $totalParticipantes;
        $totalFacilidadDeManejoDelSistema = $FacilidadDeManejoDelSistema / $totalParticipantes;
        $totalRecursosDisponiblesEnElSistema = $RecursosDisponiblesEnElSistema / $totalParticipantes;
        $totalEvaluacionEjercicios = (($totalInteraccionConElInstructorParaLaResolucion + $totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas)*100)/12;
        /* Totales Resultados esperados */
        $totalNivelAplicabilidad = $NivelAplicabilidad / $totalParticipantes;
        $totalNivelImpactoEnOrganizacion = $NivelImpactoEnOrganizacion / $totalParticipantes;
        $totalResultadosEsperados = (($totalNivelAplicabilidad + $totalNivelImpactoEnOrganizacion)*100)/8;
        ?>

        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Oportunidad de la divulgación y del acceso a la información</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalOportunidadDeLaDivulgacion,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Divulgación oportuna del curso</th>
            <th>
                <?php echo number_format($divulgacionOportunaDelCurso,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Acceso oportuno a los materiales</th>
            <th>
                <?php echo number_format($accesoOportunoALosMateriales,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Adecuación del tiempo de desarrollo del curso</th>
            <th>
                <?php echo number_format($adecuacionDelTiempoDeDesarrolloDelCurso,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Contenido de las exposiciones orales</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalContenidoDivulgacion,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Consistencia en relación con los objetivos</th>
            <th>
                <?php echo number_format($totalConsistenciaEn,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Alcance y nivel de los contenidos</th>
            <th>
                <?php echo number_format($totalAlcanceYNivelDeLosContenidos,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Actualidad de los contenidos</th>
            <th>
                <?php echo number_format($totalActualidadDeLosContenidos,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Instructor</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalInstructor,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Dominio del tema</th>
            <th>
                <?php echo number_format($totalDominioDelTema,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Habilidades para transmitir el conocimiento</th>
            <th>
                <?php echo number_format($totalHabilidadesParaTransmitirElConocimiento,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Capacidad para despertar interés</th>
            <th>
                <?php echo number_format($totalCapacidadParaDespertarInteres,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Ecuanimidad y respeto en el trato</th>
            <th>
                <?php echo number_format($totalEcuanimidadRespetoEnElTrato,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Coordinación general y apoyo técnico</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalCoordinacionGeneral,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Coordinación general de las sesiones</th>
            <th>
                <?php echo number_format($totalCoordinacionGeneralSesiones,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Comunicación eficaz con los participantes</th>
            <th>
                <?php echo number_format($totalComunicacionEficazParticipantes,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Atención en tiempo a problemas técnicos</th>
            <th>
                <?php echo number_format($totalAtencionTiempoProblemasTecnicos,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Marterial de estudio</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalMaterialDeEstudio,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Calidad del material utilizado en las sesiones</th>
            <th>
                <?php echo number_format($totalEjerciciosAdecuadosALosObjetivos,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Utilidad profundizar temas</th>
            <th>
                <?php echo number_format($totalClaridadEnunciadosYPreguntas,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Evaluación / Ejercicios</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalEvaluacionEjercicios,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Ejercicios adecuados a los objetivos</th>
            <th>
                <?php echo number_format($totalEjerciciosAdecuadosALosObjetivos,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Claridad de los enunciados y preguntas</th>
            <th>
                <?php echo number_format($totalClaridadEnunciadosYPreguntas,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Interacción con el instructor para la resolución</th>
            <th>
                <?php echo number_format($totalInteraccionConElInstructorParaLaResolucion,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Sistema de Comunicación virtual SICVE</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalSistemaDeComunicacionVirtual,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Evaluación de la plataforma tecnológica</th>
            <th>
                <?php echo number_format($totalEvaluacionDeLaPlataformaTecnologica,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Facilidad de manejo del sistema</th>
            <th>
                <?php echo number_format($totalFacilidadDeManejoDelSistema,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Recursos Disponibles en el sistema</th>
            <th>
                <?php echo number_format($totalRecursosDisponiblesEnElSistema,2); ?>
            </th>
        </tr>
        <tr class="titleBg">
            <th class="titleResumen text-right"><b>Resultados esperados</b></th>
            <th class="titleResumen text-right"><?php echo number_format($totalResultadosEsperados,2); ?> %</th>
        </tr>
        <tr>

            <th class="text-right">Nivel de aplicabilidad en su cargo actual, de esta capacitación recibida</th>
            <th>
                <?php echo number_format($totalNivelAplicabilidad,2); ?>
            </th>
        </tr>
        <tr>
            <th class="text-right">Nivel de impacto de la capacitación OLADE sobre el desempeño de la organización</th>
            <th>
                <?php echo number_format($totalNivelImpactoEnOrganizacion,2); ?>
            </th>
        </tr>
        </tbody>
        <?php
        /* calificacion

         $AccesoOportunoALosMarteriales + $ActualidadDeLosContenidos + $AdecuacionDelTiempoDeDesarrolloDelCurso + $AlcanceyNivelDeLosContenidos + $AtencionTiempoProblemasTecnicos + $CapacidadParaDespertarInteres + $ClaridadDeLosEnunciadosYPreguntas + $ClaridadEnunciadosYPreguntas + $ComunicacionEficazParticipantes + $ConsistenciaEnRelacionConLosObjetivos + $CoordinacionGeneralSesiones + $DivulgacionOportunaDelCurso + $DominioDelTema + $EcuanimidadRespetoEnElTrato + $EjerciciosAdecuadosALosObjetivos + $EjerciciosAdecuadosObjetivos + $EvaluacionDeLaPlataformaTecnologica + $FacilidadDeManejoDelSistema + $HabilidadesParaTransmitirElConocimiento + $InteraccionConElInstructorParaLaResolucion + $NivelAplicabilidad + $NivelImpactoEnOrganizacion + $RecursosDisponiblesEnElSistema
        12 +
        */



        $sumaContenidos = (($totalAlcanceYNivelDeLosContenidos + $totalConsistenciaEn + $totalActualidadDeLosContenidos)/3)* 0.25;

        $sumaInstructor = (($totalDominioDelTema + $totalHabilidadesParaTransmitirElConocimiento + $totalCapacidadParaDespertarInteres + $totalEcuanimidadRespetoEnElTrato)/4)*0.25;

        $sumaCoordinacionGenreal = (($totalCoordinacionGeneralSesiones + $totalComunicacionEficazParticipantes + $totalAtencionTiempoProblemasTecnicos)/3)*0.30;

        $sumaAsistenciaTecnica = (($totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas + $totalInteraccionConElInstructorParaLaResolucion)/3)*0.10;

        $sumaPlataforma = (($totalEvaluacionDeLaPlataformaTecnologica + $totalFacilidadDeManejoDelSistema + $totalRecursosDisponiblesEnElSistema)/3)*0.10;

        $calificacionSatisfaccion = number_format((($sumaPlataforma + $sumaAsistenciaTecnica + $sumaCoordinacionGenreal + $sumaInstructor + $sumaContenidos)*100/4),2) ;
        ?>
        <tfoot>
        <tr>
            <th><b>Participantes encuestados:</b></th>
            <th><?php echo $totalParticipantes ?></th>
        </tr>
        <tr>
            <th><b>Indicador "Oportunidad de Cursos":</b></th>
            <th><?php echo number_format($totalOportunidadDeLaDivulgacion,2); ?> %</th>
        </tr>
        <tr>
            <th><b>Calificación Nivel de Satisfacción:</b></th>
            <th><?php echo $calificacionSatisfaccion ?> %</th>
        </tr>
        </tfoot>
    </table>
    <h3>Participantes de la encuesta</h3>
    <table class="wp-list-table widefat fixed striped table-view-list posts">
        <thead>
        <tr>
            <th scope="col" class="manage-column column-email column-primary sortable desc">
                <span>Cédula o Pasaporte</span>

            </th>
            <th scope="col" class="manage-column column-email column-primary sortable desc">
                <span>Nombres</span>

            </th>
            <th scope="col" class="manage-column column-email column-primary sortable desc">
                <span>Género</span>
            </th>
            <th scope="col" class="manage-column column-email column-primary sortable desc">
                <span>Fecha de Nacimiento</span>
            </th>
            <th scope="col" class="manage-column column-email column-primary sortable desc">
                <span>Correo electrónico institución</span>
            </th>
            <th scope="col" class="manage-column column-email column-primary sortable desc">
                <span>Ver encuesta</span>
            </th>
        </tr>
        </thead>

        <tbody id="the-list" data-wp-lists="list:post">
        <?php echo $particpantesHtml; ?>
        </tbody>
    </table>
</div>


    <?php endif; ?>


<!-- The modal / dialog box, hidden somewhere near the footer -->
<div id="my-dialog" class="hidden" style="max-width:70vw">
    <h3>Resultado Encuesta</h3>
    <p><b>Fecha:</b><span id="FechaEncuesta"></span></p>
    <p><b>Divulgacion oportuna del curso:</b>&nbsp;<span id="DivulgacionOportunaDelCurso"></span></p>
    <p><b>Acceso oportuno a los materiales:</b>&nbsp;<span id="AccesoOportunoALosMarteriales"> </span></p>
    <p><b>Adecuación del tiempo de desarrollo del curso:</b>&nbsp;<span id="AdecuacionDelTiempoDeDesarrolloDelCurso"> </span></p>
    <p><b>Consistencia en relación con los objetivos:</b><span id="ConsistenciaEnRelacionConLosObjetivos"> </span></p>
    <p><b>Alcance y nivel de los contenidos:</b>&nbsp;<span id="AlcanceyNivelDeLosContenidos"> </span></p>
    <p><b>Actualidad de los contenidos:</b>&nbsp;<span id="ActualidadDeLosContenidos"> </span></p>
    <p><b>Dominio del tema:</b><span id="DominioDelTema"> </span></p>
    <p><b>Habilidades para transmitir el conocimiento:</b>&nbsp;<span id="HabilidadesParaTransmitirElConocimiento"> </span></p>
    <p><b>Capacidad para despertar interés:</b>&nbsp;<span id="CapacidadParaDespertarInteres"> </span></p>
    <p><b>Ecuanímidad y respeto en el trato:</b>&nbsp;<span id="EcuanimidadRespetoEnElTrato"> </span></p>
    <p><b>Coordinación general de las sesiones:</b>&nbsp;<span id="CoordinacionGeneralSesiones"> </span></p>
    <p><b>Comunicación eficaz con los participantes:</b>&nbsp;<span id="ComunicacionEficazParticipantes"> </span></p>
    <p><b>Atención en tiempo a problemas técnicos:</b>&nbsp;<span id="AtencionTiempoProblemasTecnicos"> </span></p>
    <p><b>Calidad del manterial utilizado en las sesiones:</b>&nbsp;<span id="EjerciciosAdecuadosObjetivos"> </span></p>
    <p><b>Utilidad para profundizar temas:</b>&nbsp;<span id="ClaridadEnunciadosYPreguntas"> </span></p>
    <p><b>Interacción con el instructor para la resolución:</b><span id="InteraccionConElInstructorParaLaResolucion"> </span></p>
    <p><b>Evaluación de la plataforma tecnológica:</b>&nbsp;<span id="EvaluacionDeLaPlataformaTecnologica"> </span></p>
    <p><b>Facilidad de manejo del sistema:</b><span id="FacilidadDeManejoDelSistema"> </span></p>
    <p><b>Recursos Disponibles en el sistema:</b><span  style="padding-left:5px;" id="RecursosDisponiblesEnElSistema"> </span></p>
    <p><b>Nivel de aplicabilidad en su cargo actual, de esta capacitación recibida:</b><span style="padding-left:5px;" id="NivelAplicabilidad"> </span></p>
    <p><b>Nivel de impacto de la capacitación OLADE sobre el desempeño de la organización:</b><span id="NivelImpactoEnOrganizacion"> </span></p>
    <p><b>¿Cómo se entero usted del curso?:</b><span style="padding-left:5px;" id="enterodelcurso"></span></p>
    <p><b>Sugerencias Comentarios:</b><span style="padding-left:5px;" id="sugerenciascomentarios"></span></p>

</div>
<!-- This script should be enqueued properly in the footer -->
<script>
    window.onload = function() {
        (function ($) {
            // initalise the dialog
            $('#my-dialog').dialog({
                title: 'Resultados Encuesta Satisfacción',
                dialogClass: 'wp-dialog',
                autoOpen: false,
                draggable: false,
                width: 'auto',
                modal: true,
                resizable: false,
                closeOnEscape: true,
                position: {
                    my: "center",
                    at: "center",
                    of: window
                },
                open: function () {
                    // close dialog by clicking the overlay behind it
                    $('.ui-widget-overlay').bind('click', function () {
                        $('#my-dialog').dialog('close');
                    })
                },
                create: function () {
                    // style fix for WordPress admin
                    $('.ui-dialog-titlebar-close').addClass('ui-button');
                },
            });

            // bind a button or a link to open the dialog
            $('a.open-my-dialog').click(function (e) {
                e.preventDefault();
                let data = $(this).data('encuesta')
                let date = $(this).data('date')
                
                let datob = window.atob(data)
                let j = JSON.parse(datob.replace('sugerencias-comentarios','sugerenciascomentarios'))
                console.info(j)
                console.info(datob)
                if(j === null){
                    alert('error')
                }else{
                    $('#FechaEncuesta').html(j.fecha)
                    $('#AccesoOportunoALosMarteriales').html(j.AccesoOportunoALosMarteriales)
                $('#ActualidadDeLosContenidos').html(j.ActualidadDeLosContenidos)
                $('#AdecuacionDelTiempoDeDesarrolloDelCurso').html(j.AdecuacionDelTiempoDeDesarrolloDelCurso)
                $('#AlcanceyNivelDeLosContenidos').html(j.AlcanceyNivelDeLosContenidos)
                $('#AtencionTiempoProblemasTecnicos').html(j.AtencionTiempoProblemasTecnicos)
                $('#CapacidadParaDespertarInteres').html(j.CapacidadParaDespertarInteres)
                $('#ClaridadDeLosEnunciadosYPreguntas').html(j.ClaridadEnunciadosYPreguntas)
                $('#ComunicacionEficazParticipantes').html(j.ComunicacionEficazParticipantes)
                $('#ConsistenciaEnRelacionConLosObjetivos').html(j.ConsistenciaEnRelacionConLosObjetivos)
                $('#CoordinacionGeneralSesiones').html(j.CoordinacionGeneralSesiones)
                $('#DivulgacionOportunaDelCurso').html(j.DivulgacionOportunaDelCurso)
                $('#DominioDelTema').html(j.DominioDelTema)
                $('#EcuanimidadRespetoEnElTrato').html(j.EcuanimidadRespetoEnElTrato)
                $('#EjerciciosAdecuadosALosObjetivos').html(j.EjerciciosAdecuadosALosObjetivos)
                $('#EjerciciosAdecuadosObjetivos').html(j.EjerciciosAdecuadosObjetivos)
                $('#EvaluacionDeLaPlataformaTecnologica').html(j.EvaluacionDeLaPlataformaTecnologica)
                $('#FacilidadDeManejoDelSistema').html(j.FacilidadDeManejoDelSistema)
                $('#HabilidadesParaTransmitirElConocimiento').html(j.HabilidadesParaTransmitirElConocimiento)
                $('#InteraccionConElInstructorParaLaResolucion').html(j.InteraccionConElInstructorParaLaResolucion)
                $('#NivelAplicabilidad').html(j.NivelAplicabilidad)
                $('#NivelImpactoEnOrganizacion').html(j.NivelImpactoEnOrganizacion)
                $('#RecursosDisponiblesEnElSistema').html(j.RecursosDisponiblesEnElSistema)
                $('#enterodelcurso').html(j.Enterodelcurso)
                $('#sugerenciascomentarios').html(j.SugerenciasComentarios)
                $('#my-dialog').dialog('open');
                }
                
            });
        })(jQuery);
    }

    function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    }
</script>