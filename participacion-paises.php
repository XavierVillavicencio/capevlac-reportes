<?php
global $wpdb;
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$post = $_POST;
$anos = array(
        '---',
        2020,
        2021,
        2022
);
$ejes= array(
        'x'=>'---',
        1=>'Capevlac',
        2=>'Innovación',
        3=>'Integración y Planificación Energética',
        4=>'Eficiencia energética',
        5=>'Género y Energía',
        7=>'Energía Renovable',
       8=>'Cambio climático',
       11=>'Energía y acceso'
    );
$wpPreffix = array(
    1=>'wp_',
    2=>'wp_2_',
    3=>'wp_3_',
    4=>'wp_4_',
    5=>'wp_5_',
    7=>'wp_7_',
    8=>'wp_8_',
    11=>'wp_11_'
);
$prefix = $wpPreffix[$post['blog_id']];
$where = null;
if($post['ano'] != '---'):
    $where = " and `post_modified` like '".$post['ano']."%';";
endif;
$sql = "SELECT ID,post_title,'".$prefix."' as prefix FROM ".$prefix."posts WHERE `post_type`='lp_course' and post_status = 'publish' ".$where;
$courses = $wpdb->get_results($sql, ARRAY_A);
$output = null;
if(!empty($courses)):
    $i = 0;
foreach ($courses as $course):
    $listTmp[$i]['ejetematico'] = $ejes[$post['blog_id']];
    $listTmp[$i]['capacitacion'] = ucfirst(strtolower($course['post_title']));


    $output .=  "<tr>";
    $output .=  "<td>".$ejes[$post['blog_id']]."</td>";
    $output .=  "<td>".ucfirst(strtolower($course['post_title']))."</td>";
    $sql = "SELECT distinct user_id,wp_users.* FROM " . $prefix . "learnpress_user_items,
                wp_users where wp_users.ID = " . $prefix . "learnpress_user_items.user_id and " . $prefix . "learnpress_user_items.`item_id` = " . $course['ID'];

    $stu = $wpdb->get_results($sql);
    $participantes = $wpdb->last_result;
    /* Recopilamos datos */
    $female = 0;
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
                case "republica rominicana":
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
                    $tmpPaisNoMiembro[$values['pais']] = 1;
            endswitch;
        }
    endforeach;

    $paisConteoMiembro = count($tmpPaisMiembro)-count($tmpPaisNoMiembro);
    $paisNoConteoMiembro = count($tmpPaisNoMiembro);

    $listTmp[$i]['paisConteoMiembro'] = $paisConteoMiembro;
    $listTmp[$i]['paisMiembro'] = $paisMiembro;
    $listTmp[$i]['paisNoConteoMiembro'] = $paisNoConteoMiembro;
    $listTmp[$i]['paisesNoMiembro'] = $paisesNoMiembro;

    $output .=  "<td>".$paisConteoMiembro."</td>";
    $output .=  "<td>".$paisMiembro."</td>";
    $output .=  "<td>".$paisNoConteoMiembro."</td>";
    $output .=  "<td>".$paisesNoMiembro."</td>";
    $output .=  "</tr>";
    $i++;
endforeach;
else:
    $output = "<td colspan='6'>No existen resultados</td>";
endif;
$timer = strtotime("now");
if (!empty($_REQUEST['exportpdf'])) {
    $html = '<table border="1"  style="width: 100%; table-layout: fixed"><thead><tr>
             <th style="width:10%;">Eje temático</th>
             <th style="width:10%;">Capacitacion</th>
             <th style="width:10%;">País miembro</th>
             <th style="width:10%;"># Participantes</th>
             <th style="width:10%;">País no miembro</th>
             <th style="width:10%;"># Participantes</th>
</tr></thead>';
    $html .="<tbody>";
    $html .= $output;
    $html .= "</tbody></table>";
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('/var/www/html/wp-content/plugins/capevlac-reportes/participacion-paises-' . $timer . '.pdf', $output);

    $pdfname = "reporte" . $timer . ".pdf";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/participacion-paises-" . $timer . ".pdf";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a target='_blank' href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);
}

if (!empty($_REQUEST['exportxls'])) {
    $i = 0;
    $list[] = array(
        'Eje temático',
        'Capacitación',
        'País Miembro',
        '# Participantes',
        'País no miembro',
        '# Participantes'
    );

    foreach ($listTmp as $item):
        $list[] = array(
            $item['ejetematico'],
            $item['capacitacion'],
            $item['paisConteoMiembro'],
            $item['paisMiembro'],
            $item['paisNoConteoMiembro'],
            $item['paisesNoMiembro']
        );
    endforeach;
    $fp = fopen('/var/www/html/wp-content/plugins/capevlac-reportes/participacion-paises-' . $timer . '.csv', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    $pdfname = "reporte" . $timer . ".csv";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/participacion-paises-" . $timer . ".csv";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a target='_blank' href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);

    fclose($fp);
    die("Report has to be downloaded");
}
?>
<h3>Participación por país</h3>
<form action="https://capevlac.olade.org/wp-admin/admin.php?page=capevlac-reportes-plugin&tab=paises" method="post" id="filterForm">
<div class="tablenav top">
    <div class="alignleft actions bulkactions">
        <label for="bulk-action-selector-top" class="screen-reader-text">Año</label>
        <select name="ano">
            <?php
                foreach($anos as $ano):
                    if((int) $ano ==  (int) $post['ano']):
                        $selected = 'selected';
                    else:
                        $selected = null;
                    endif;
                    echo "<option ".$selected." value=".$ano.">".$ano."</option>";
                endforeach;
                $selected = null;
            ?>
        </select>
        <label for="bulk-action-selector-top" class="screen-reader-text">Eje temático</label>
        <select name="blog_id">
            <?php
                foreach($ejes as $id => $eje):
                    if((int) $id ==  (int) $post['blog_id']):
                        $selected = 'selected';
                    else:
                        $selected = null;
                    endif;
                    echo "<option ".$selected." value=".$id.">".$eje."</option>";
                endforeach;
            ?>
        </select>
        <input type="hidden" id="exportpdf" name="exportpdf" value="0">
        <input type="hidden" id="exportxls" name="exportxls" value="0">
        <input type="submit" id="post-query-submit" class="button" value="Filtrar">
    </div>
    <div class="alignleft actions">
        <input type="submit" name="export"  id="export_xls" class="button" value="Exportar a Excel"/>
        <input type="submit" name="export"  id="export_pdf" class="button" value="Exportar a PDF" />
    </div>

<br class="clear">
</div>
</form>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th scope="col" >
                Eje temático
        </th>
        <th scope="col" >
                Capacitación
        </th>
        <th scope="col" >
                País miembro
        </th>
        <th scope="col" >
                # Participantes
        </th>
        <th scope="col" >
                País no miembro
        </th>
        <th scope="col" >
                # Participantes
        </th>
    </tr>
    </thead>
    <tbody id="the-list" data-wp-lists="list:post">
        <?php echo $output; ?>
    </tbody>
    <tfoot>
    <tr>
        <th scope="col">
                Eje temático
        </th>
        <th scope="col">
                Capacitación
        </th>
        <th scope="col">
                País miembro
        </th>
        <th scope="col">
                # Participantes
        </th>
        <th scope="col">
                País no miembro
        </th>
        <th scope="col">
                # Participantes
        </th>
    </tr>
    </tfoot>
</table>
<div class="tablenav bottom">
    <div class="alignleft actions">
    </div>
</div>

<script>
    jQuery(function () {
        jQuery('#export_xls').click(function () {
            jQuery('#exportxls').val(1)
            jQuery('#filterForm').submit()
        })
        jQuery('#export_pdf').click(function () {
            jQuery('#exportpdf').val(1)
            jQuery('#filterForm').submit()

        })
    })
</script>