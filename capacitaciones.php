<?php
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
global $wpdb;
$timer = strtotime("now");
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$wpPreffix = array('wp_','wp_11_','wp_2_','wp_3_','wp_4_','wp_5_','wp_7_','wp_8_','wp_9_');
$courses = array();
foreach($wpPreffix as $wppref){
    $sql = "SELECT ID,post_title,'".$wppref."' as prefix FROM ".$wppref."posts WHERE `post_type`='lp_course' and post_status = 'publish';";
    $coursestmp = $wpdb->get_results($sql, ARRAY_A);
    $courses = array_merge($courses,$coursestmp);
}

/* recopilamos los datos */
$output = null;
$a = 0;
foreach ($courses as $course):
// SELECT * FROM `wp_postmeta` where post_id = 5135;
$coursepostmeta = $wpdb->get_results("SELECT meta_value FROM `".$course['prefix']."postmeta` where post_id =".$course['ID']." and meta_key = '_lp_course_status'", ARRAY_A);
$ejecutandose = '-';
$finalizado = '-';
$ejecutandose = 'Ejecutándose';
/*if($coursepostmeta[0]['meta_value'] == 'publish'){
    $ejecutandose = 'X';
}else{
    $finalizado = 'X';
}*/
    $stu = $wpdb->get_results("SELECT distinct user_id,wp_users.* FROM " . $course['prefix'] . "learnpress_user_items,
                wp_users where wp_users.ID = " . $course['prefix'] . "learnpress_user_items.user_id and " . $course['prefix'] . "learnpress_user_items.`item_id` = " . $course['ID']);
    $participantes = $wpdb->last_result;
    /* Recopilamos datos */
    $female = 0;
    $i = 0;
    $male = 0;
    $cpartici = 0;
    $paisMiembro = 0;
    $paisNoMiembro = 0;
    $paises = 0;
    $paisesNoMiembro = 0;
    $paisesNoMiembro = 0;
    $paisesVen = 0;
    $paisesEc = 0;
    $paisesArge = 0;
    $paisesBrasi = 0;
    $paisesElSal = 0;
    $paisesGuate = 0;
    $paisesJamai = 0;
    $paisesTrinid = 0;
    $paisesBarbad = 0;
    $paisesBelice = 0;
    $paisesBolivia = 0;
    $paisesColom = 0;
    $paisesChile = 0;
    $paisesCost = 0;
    $paisesGre = 0;
    $paisesGuy = 0;
    $paisesHai = 0;
    $paisesHon = 0;
    $paisesMex = 0;
    $paisesNica = 0;
    $paisesPana = 0;
    $paisesPara = 0;
    $paisesPeru = 0;
    $paisesRepDom = 0;
    $paisesSur = 0;
    $paisesUru = 0;
    $paisesVen = 0;
    $paisesCuba = 0;

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
    $tmpPaisMiembro = null;
    $tmpNoPaisMiembro = null;

    foreach ($participantes as $participante):
        $participante_json = $wpdb->get_results("SELECT * FROM wp_users_registered where correoinstitucional like '%" . $participante->user_email . "%'");

        if (empty($participante_json)) {
            continue;
        } else {
            $values = (array) $participante_json[0];
            $cpartici++;
            $gen = $values['genero'];
            if($gen == 'femenino'){
                $female++;
            }else{
                $male++;
            }
            $tmpPaisMiembro[$values['pais']] = 1;
            switch($values['pais']):
                case "ecuador":
                    $paisMiembro++;
                    $paisesEc = 1;
                    break;
                case "argentina":
                    $paisMiembro++;
                    $paisesArge = 1;
                    break;
                case "brasil":
                    $paisMiembro++;
                    $paisesBrasi = 1;
                    break;
                case "cuba":
                    $paisMiembro++;
                    $paisesCuba = 1;
                    break;
                case "guatemala":
                    $paisMiembro++;
                    $paisesGuate = 1;
                    break;
                case "jamaica":
                    $paisMiembro++;
                    $paisesJamai = 1;
                    break;
                case "trinidad y tobago":
                    $paisMiembro++;
                    $paisesTrinid = 1;
                    break;
                case "barbados":
                    $paisMiembro++;
                    $paisesBarbad = 1;
                    break;
                case "belice":
                    $paisMiembro++;
                    $paisesBelice = 1;
                    break;
                case "bolivia":
                    $paisMiembro++;
                    $paisesBolivia = 1;
                    break;
                case "colombia":
                    $paisMiembro++;
                    $paisesColom = 1;
                    break;
                case "chile":
                    $paisMiembro++;
                    $paisesChile = 1;
                    break;
                case "costa rica":
                    $paisMiembro++;
                    $paisesCost = 1;
                    break;
                case "el salvador":
                    $paisMiembro++;
                    $paisesElSal = 1;
                    break;
                case "grenada":
                    $paisMiembro++;
                    $paisesGre = 1;
                    break;
                case "guyana":
                    $paisMiembro++;
                    $paisesGuy = 1;
                    break;
                case "haití":
                    $paisMiembro++;
                    $paisesHai = 1;
                    break;
                case "honduras":
                    $paisMiembro++;
                    $paisesHon = 1;
                    break;
                case "mexico":
                    $paisMiembro++;
                    $paisesMex = 1;
                    break;
                case "nicaragua":
                    $paisMiembro++;
                    $paisesNica = 1;
                    break;
                case "panama":
                    $paisMiembro++;
                    $paisesPana = 1;
                    break;
                case "paraguay":
                    $paisMiembro++;
                    $paisesPara = 1;
                    break;
                case "peru":
                    $paisMiembro++;
                    $paisesPeru = 1;
                    break;
                case "republica dominicana":
                    $paisMiembro++;
                    $paisesRepDom = 1;
                    break;
                case "suriname":
                    $paisMiembro++;
                    $paisesSur = 1;
                    break;
                case "uruguay":
                    $paisMiembro++;
                    $paisesUru = 1;
                    break;
                case "venezuela":
                    $paisMiembro++;
                    $paisesVen = 1;
                    break;
                default:
                    $paisesNoMiembro++;
                    $paisNoMiembro++;
                    $tmpNoPaisMiembro[$values['pais']] = 1;
            endswitch;

            $paises = $paisesNoMiembro+
                $paisesVen+
                $paisesEc+
                $paisesArge+
                $paisesBrasi+
                $paisesElSal+
                $paisesGuate+
                $paisesJamai+
                $paisesTrinid+
                $paisesBarbad+
                $paisesBelice+
                $paisesBolivia+
                $paisesColom+
                $paisesChile+
                $paisesCost+
                $paisesGre+
                $paisesGuy+
                $paisesHai+
                $paisesHon+
                $paisesMex+
                $paisesNica+
                $paisesPana+
                $paisesPara+
                $paisesPeru+
                $paisesRepDom+
                $paisesSur+
                $paisesUru+
                $paisesVen+
                $paisesCuba
            ;
            $encuesta_json = $wpdb->get_results("SELECT * FROM wp_users_survey where wp_id = ".$participante->user_id." 
            and course_id = ".$course['ID']);
            if(empty($encuesta_json)){
                continue;
            }else{
                $encuestasinserializar= empty($encuesta_json[0]->id)?null:$encuesta_json[0]->id;
                $encuesta_json[0] = (array) $encuesta_json[0];
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

        }
    endforeach;
    /* Recopilamos datos */

    /* Totales Resumen Divulgacion */
    $divulgacionOportunaDelCurso = empty($totalParticipantes)?0:$DivulgacionOportunaDelCurso / $totalParticipantes;
    $accesoOportunoALosMateriales = empty($totalParticipantes)?0: $AccesoOportunoALosMarteriales / $totalParticipantes;
    $adecuacionDelTiempoDeDesarrolloDelCurso =  empty($totalParticipantes)?0:$AdecuacionDelTiempoDeDesarrolloDelCurso / $totalParticipantes;
    $totalOportunidadDeLaDivulgacion = (($divulgacionOportunaDelCurso + $accesoOportunoALosMateriales + $adecuacionDelTiempoDeDesarrolloDelCurso)*100)/12;
    /* Totales Contenido de las exposiciones */
    $totalConsistenciaEn =  empty($totalParticipantes)?0:$ConsistenciaEnRelacionConLosObjetivos / $totalParticipantes;
    $totalAlcanceYNivelDeLosContenidos =  empty($totalParticipantes)?0:$AlcanceyNivelDeLosContenidos / $totalParticipantes;
    $totalActualidadDeLosContenidos =  empty($totalParticipantes)?0:$ActualidadDeLosContenidos / $totalParticipantes;
    $totalContenidoDivulgacion = (($totalActualidadDeLosContenidos + $totalAlcanceYNivelDeLosContenidos + $totalConsistenciaEn)*100)/12;
    /* Totales Instructor */
    $totalDominioDelTema =  empty($totalParticipantes)?0:$DominioDelTema / $totalParticipantes;
    $totalHabilidadesParaTransmitirElConocimiento =  empty($totalParticipantes)?0:$HabilidadesParaTransmitirElConocimiento / $totalParticipantes;
    $totalCapacidadParaDespertarInteres =  empty($totalParticipantes)?0:$CapacidadParaDespertarInteres / $totalParticipantes;
    $totalEcuanimidadRespetoEnElTrato =  empty($totalParticipantes)?0:$EcuanimidadRespetoEnElTrato / $totalParticipantes;
    $totalInstructor = (($totalDominioDelTema + $totalHabilidadesParaTransmitirElConocimiento + $totalCapacidadParaDespertarInteres+$totalEcuanimidadRespetoEnElTrato)*100)/16;
    /* Totales coordinación */
    $totalCoordinacionGeneralSesiones =  empty($totalParticipantes)?0:$CoordinacionGeneralSesiones / $totalParticipantes;
    $totalComunicacionEficazParticipantes =  empty($totalParticipantes)?0:$ComunicacionEficazParticipantes / $totalParticipantes;
    $totalAtencionTiempoProblemasTecnicos =  empty($totalParticipantes)?0:$AtencionTiempoProblemasTecnicos / $totalParticipantes;
    $totalCoordinacionGeneral = (($totalCoordinacionGeneralSesiones + $totalComunicacionEficazParticipantes + $totalAtencionTiempoProblemasTecnicos)*100)/12;
    /* Totales Material de estudio */
    $totalClaridadEnunciadosYPreguntas =  empty($totalParticipantes)?0:$ClaridadEnunciadosYPreguntas / $totalParticipantes;
    $totalEjerciciosAdecuadosALosObjetivos = empty($totalParticipantes)?0:$EjerciciosAdecuadosALosObjetivos / $totalParticipantes;
    $totalMaterialDeEstudio = (($totalClaridadEnunciadosYPreguntas + $totalEjerciciosAdecuadosALosObjetivos)*100)/8;
    /* Totales coordinación */
    $totalInteraccionConElInstructorParaLaResolucion = empty($totalParticipantes)?0:$InteraccionConElInstructorParaLaResolucion / $totalParticipantes;
    $totalEvaluacionEjercicios = (($totalInteraccionConElInstructorParaLaResolucion + $totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas)*100)/12;
    /* Totales Sistema de Comunicación virtual SICVE */
    $totalEvaluacionDeLaPlataformaTecnologica = empty($totalParticipantes)?0:$EvaluacionDeLaPlataformaTecnologica / $totalParticipantes;
    $totalFacilidadDeManejoDelSistema = empty($totalParticipantes)?0:$FacilidadDeManejoDelSistema / $totalParticipantes;
    $totalRecursosDisponiblesEnElSistema = empty($totalParticipantes)?0:$RecursosDisponiblesEnElSistema / $totalParticipantes;
    $totalSistemaDeComunicacionVirtual = (($totalInteraccionConElInstructorParaLaResolucion + $totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas)*100)/12;
    /* Totales Resultados esperados */
    $totalEvaluacionDeLaPlataformaTecnologica = empty($totalParticipantes)?0:$EvaluacionDeLaPlataformaTecnologica / $totalParticipantes;
    $totalFacilidadDeManejoDelSistema = empty($totalParticipantes)?0:$FacilidadDeManejoDelSistema / $totalParticipantes;
    $totalRecursosDisponiblesEnElSistema = empty($totalParticipantes)?0:$RecursosDisponiblesEnElSistema / $totalParticipantes;
    $totalEvaluacionEjercicios = (($totalInteraccionConElInstructorParaLaResolucion + $totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas)*100)/12;
    /* Totales Resultados esperados */
    $totalNivelAplicabilidad = empty($totalParticipantes)?0:$NivelAplicabilidad / $totalParticipantes;
    $totalNivelImpactoEnOrganizacion = empty($totalParticipantes)?0:$NivelImpactoEnOrganizacion / $totalParticipantes;
    $totalResultadosEsperados = (($totalNivelAplicabilidad + $totalNivelImpactoEnOrganizacion)*100)/8;

    $sumaContenidos = (($totalAlcanceYNivelDeLosContenidos + $totalConsistenciaEn + $totalActualidadDeLosContenidos)/3)* 0.25;

    $sumaInstructor = (($totalDominioDelTema + $totalHabilidadesParaTransmitirElConocimiento + $totalCapacidadParaDespertarInteres + $totalEcuanimidadRespetoEnElTrato)/4)*0.25;

    $sumaCoordinacionGenreal = (($totalCoordinacionGeneralSesiones + $totalComunicacionEficazParticipantes + $totalAtencionTiempoProblemasTecnicos)/3)*0.30;

    $sumaAsistenciaTecnica = (($totalEjerciciosAdecuadosALosObjetivos + $totalClaridadEnunciadosYPreguntas + $totalInteraccionConElInstructorParaLaResolucion)/3)*0.10;

    $sumaPlataforma = (($totalEvaluacionDeLaPlataformaTecnologica + $totalFacilidadDeManejoDelSistema + $totalRecursosDisponiblesEnElSistema)/3)*0.10;

    $calificacionSatisfaccion = number_format((($sumaPlataforma + $sumaAsistenciaTecnica + $sumaCoordinacionGenreal + $sumaInstructor + $sumaContenidos)*100/4),2) ;

    $tmpPaisMienbroc = count($tmpPaisMiembro) - count($tmpNoPaisMiembro);
    $tmpPaisNoMienbroc = count($tmpNoPaisMiembro);
    $tmpPaisMienbrod = count($tmpPaisMiembro);
    $algoCuenta = number_format($totalOportunidadDeLaDivulgacion,2);
    $tmpCalificacion = str_replace('.',',',(string)$calificacionSatisfaccion);
    $algoCuenta = str_replace('.',',',(string)$algoCuenta);
    $listTmp [$a] = array(
            'post_title'=>$course['post_title'],
            'cpartici'=>$cpartici,
            'female'=>$female,
            'male'=>$male,
            'tmpPaisMienbroc'=>$tmpPaisMienbroc,
            'tmpPaisNoMienbroc'=>$tmpPaisNoMienbroc,
            'tmpPaisMienbrod'=>$tmpPaisMienbrod,
            'calificacionSatisfaccion'=>$tmpCalificacion,
            'algoCuenta'=>$algoCuenta,
            'ejecutandose'=>$ejecutandose,
            'finalizado'=>$finalizado
    );

    $output .= "<tr>";
    $output .= "<td>".$course['post_title']."</td>";
    $output .= "<td>".$cpartici."</td>";
    $output .= "<td>".$female."</td>";
    $output .= "<td>".$male."</td>";
    $output .= "<td>".$tmpPaisMienbroc."</td>";
    $output .= "<td>".$tmpPaisNoMienbroc."</td>";
    $output .= "<td>".$tmpPaisMienbrod."</td>";
    $output .= "<td>".$calificacionSatisfaccion."</td>";
    $output .= "<td>".$algoCuenta."</td>";
    $output .= "<td>".$ejecutandose."</td>";
    $output .= "<td>".$finalizado."</td> </tr>";
    $a++;
endforeach;
if (!empty($_REQUEST['exportxls'])) {
    $list[] = array(
        'Nombre de capacitacion',
        'Número de participantes',
        'Femenino',
        'Masculino',
        'País miembro',
        'País no miembro',
        'Número de paises',
        'Satisfaccion de cliente',
        'Oportunidad',
        'Ejecutandose',
        'Finalizado'
    );

    foreach ($listTmp as $item):
        $list[] = array(
            $item['post_title'],
            $item['cpartici'],
            $item['female'],
            $item['male'],
            $item['tmpPaisMienbroc'],
            $item['tmpPaisNoMienbroc'],
            $item['tmpPaisMienbrod'],
            $item['calificacionSatisfaccion'],
            $item['algoCuenta'],
            $item['ejecutandose'],
            $item['finalizado']
        );
    endforeach;
    $fp = fopen('/var/www/html/wp-content/plugins/capevlac-reportes/capacitaciones-' . $timer . '.csv', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    $pdfname = "Capacitaciones" . $timer . ".csv";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/capacitaciones-" . $timer . ".csv";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a target='_blank' href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);

    fclose($fp);
    die("Report has to be downloaded");
}
if (!empty($_REQUEST['exportpdf'])) {
    $html = '<table border="1"  style="width: 100%; table-layout: fixed"><thead>
    <tr>
        <th scope="col" class="manage-column column-email column-primary desc"
            style="text-align:center; font-weight: 900;" align="center" colspan="2">
            &nbsp;
        </th>
        <th scope="col" class="manage-column column-email column-primary desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Género
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="3">
            Paises
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Indicadores
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Estado
        </th>
    </tr>
    <tr>
        <th scope="col" class="" style="text-align:center;">
            Nombre de Capacitacion
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Número de participantes
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Femenino
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Masculino
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                País miembro
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                País no miembro
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Número de paises
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Satisfaccion de cliente

        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Oportunidad
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Ejecutandose
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Finalizado
        </th>
    </tr>
    </thead>';
    $html .="<tbody>";
    $html .= $output;
    $html .= "</tbody></table>";
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('/var/www/html/wp-content/plugins/capevlac-reportes/capacitaciones-' . $timer . '.pdf', $output);

    $pdfname = "reporte" . $timer . ".pdf";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/capacitaciones-" . $timer . ".pdf";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a target='_blank' href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);
}
?>
<h3>Capacitaciones</h3>
<div class="tablenav top">
    <div class="alignleft actions">
        <input type="submit" name="export" id="export_xls" class="button" value="Exportar a Excel"/>
        <input type="submit" name="export" id="export_pdf" class="button" value="Exportar a PDF"/>
    </div>

    <br class="clear">
</div>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th scope="col" class="manage-column column-email column-primary desc"
            style="text-align:center; font-weight: 900;" align="center" colspan="2">
            &nbsp;
        </th>
        <th scope="col" class="manage-column column-email column-primary desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Género
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="3">
            Paises
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Indicadores
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Estado
        </th>
    </tr>
    <tr>
        <th scope="col" class="" style="text-align:center;">
            Nombre de Capacitacion
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Número de participantes
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Femenino
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Masculino
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                País miembro
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                País no miembro
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Número de paises
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Satisfaccion de cliente

        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Oportunidad
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Ejecutandose
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Finalizado
        </th>
    </tr>
    </thead>

    <tbody id="the-list" data-wp-lists="list:post">
    <?php
        echo $output;
    ?>
    </tbody>

    <tfoot>
    <tr>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            Nombre de la Capacitación
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Número de participantes
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Femenino
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Masculino
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                País miembro
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                País no miembro
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Número de paises
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Satisfaccion de cliente

        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Oportunidad
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Ejecutandose
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" style="text-align:center;">
            
                Finalizado
        </th>
    </tr>
    <tr>
        <th scope="col" class="manage-column column-email column-primary desc"
            style="text-align:center; font-weight: 900;" align="center" colspan="2">
            &nbsp;
        </th>
        <th scope="col" class="manage-column column-email column-primary desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Género
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="3">
            Paises
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Indicadores
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc" align="center"
            style="text-align:center; font-weight: 900;" colspan="2">
            Estado
        </th>
    </tr>
    </tfoot>
</table>
<script>
    jQuery(function () {
        jQuery('#export_xls').click(function () {
            let url = window.location.href + '&exportxls=true'
            window.open(url, '_blank').focus()
        })
        jQuery('#export_pdf').click(function () {
            let url = window.location.href + '&exportpdf=true'
            window.open(url, '_blank').focus()
        })
    })
</script>