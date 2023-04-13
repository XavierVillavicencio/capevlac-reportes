<?php
global $wpdb;
$post = $_POST;

/**
 * query get all students enroll by course ID
 *
 * @param int $courseID
 * @param int $limit
 * @param int $page
 * @param float $time_ago
 * @param string $graduation
 * @param int $average
 * @param string $username
 */
function get_all_students($course_id, $limit, $page, $graduation = '', $username = '', $calc = false, $preffix = null)
{
    global $wpdb;
    if (empty($preffix)) {
        $preffix = $wpdb->prefix;
    }
    $prefix = $preffix;
    $tbl_table_users = $prefix . 'learnpress_user_items';
    if (!$course_id) {
        return false;
    }

    if ($calc) {
        $select = 'SQL_CALC_FOUND_ROWS ID';
    } else {
        $select = 'u.user_nicename, u.user_email, ui.user_id, ui.start_time, ui.graduation';
    }

    $where = $wpdb->prepare('ui.item_id=%d', absint($course_id));

    if (!empty($graduation)) {
        $where .= $wpdb->prepare(' AND ui.graduation=%s', $graduation);
    }

    if (!empty($username)) {
        $where .= $wpdb->prepare(' AND u.user_nicename LIKE %s', '%' . $wpdb->esc_like($username) . '%');
    }

    if ($calc) {
        $sql_limit = '';
    } else {
        $offset = (absint($page) - 1) * $limit;
        $sql_limit = $wpdb->prepare('LIMIT %d, %d', $offset, $limit);
    }

    $query = "SELECT $select FROM `{$wpdb->users}` as u INNER JOIN `{$tbl_table_users}` as ui ON u.ID = ui.user_id WHERE $where $sql_limit";

    $result = $wpdb->get_results(stripslashes($query), ARRAY_A);

    if ($calc) {
        $result = $wpdb->get_var('SELECT FOUND_ROWS()');
    }

    return $result;
}
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$wpPreffix = array('wp_', 'wp_11_', 'wp_2_', 'wp_3_', 'wp_4_', 'wp_5_', 'wp_7_', 'wp_8_', 'wp_9_');
$courses = array();
foreach ($wpPreffix as $wppref) {
    $sql = "SELECT ID,post_title,'" . $wppref . "' as prefix FROM " . $wppref . "posts WHERE `post_type`='lp_course' and post_status = 'publish';";
    $coursestmp = $wpdb->get_results($sql, ARRAY_A);
    $courses = array_merge($courses, $coursestmp);
}
foreach ($courses as $course):
    $infoCurso = get_all_students($course['ID'], 10000, 1, $graduation = '', $username = '', $calc = false, $course['prefix']);
    $stu = $wpdb->get_results("SELECT distinct user_id,wp_users.* FROM " . $course['prefix'] . "learnpress_user_items,
                wp_users where wp_users.ID = " . $course['prefix'] . "learnpress_user_items.user_id and " . $course['prefix'] . "learnpress_user_items.`item_id` = " . $course['ID']);
    $participantes = $wpdb->last_result;
    /* Recopilamos datos */
    $female = 0;
    $male = 0;
    $cpartici = 0;
    $paisMiembro = 0;
    $paisNoMiembro = 0;
    $paises = 0;
    $terminados = 0;
    $enproceso = 0;
    $fallidos = 0;

    //foreach ($participantes as $participante):
    foreach ($infoCurso as $infoParticipante) {

        $participante_json = $wpdb->get_results("SELECT * FROM wp_users_registered where correoinstitucional like '%" . $infoParticipante['user_email'] . "%'");

        if (empty($participante_json)) {
            continue;
        } else {
            $values = (array)$participante_json[0];

            $cpartici++;
            $gen = $values['genero'];
            if ($gen == 'femenino') {
                $female++;
            } else {
                $male++;
            }
        }
        if ($infoParticipante['graduation'] == 'failed') {
            $fallidos++;
        }
        if ($infoParticipante['graduation'] == 'passed') {
            $terminados++;
        }
        if ($infoParticipante['graduation'] == 'in-progress') {
            $enproceso++;
        }
        $porPais[$values['pais']][$course['ID']]['course'] = $course['post_title'];
        $porPais[$values['pais']][$course['ID']]['male'] = $male;
        $porPais[$values['pais']][$course['ID']]['female'] = $female;
        $porPais[$values['pais']][$course['ID']]['terminados'] = $terminados;
        $porPais[$values['pais']][$course['ID']]['fallidos'] = $fallidos;
        $porPais[$values['pais']][$course['ID']]['enproceso'] = $enproceso;
        $porPais[$values['pais']][$course['ID']]['promedio'] = $terminados * 100 / (($enproceso / 2) + $fallidos + $terminados);
    }
    //endforeach;
    /* Recopilamos datos */

endforeach;

$paisesList = null;
foreach ($porPais as $pais => $itemPais):
    if ($_REQUEST['pais'] == $pais) {
        $selected = "selected='selected'";
    } else {
        $selected = null;
    }
    $paisesList .= "<option $selected value='" . $pais . "'>" . ucwords($pais) . "</option>";
endforeach;


/* Recopilamos los datos */
$a = 0;
foreach ($porPais as $key => $itemPais):
    if (empty($_REQUEST['pais'])) {
        $output = "
                <tr>
                    <td colspan='8'>
                        Debe seleccionar un país.
                    </td>
                </tr>
                ";
        break;
    } else {
        if ($_REQUEST['pais'] != $key) {
            continue;
        }

        foreach ($itemPais as $item) {
        /* las filas para el xls */
        $listTmp[$a]['capacitacion'] = $item['course'];
        $listTmp[$a]['promediogeneral'] = number_format($item['promedio'], 2)." %";
        $listTmp[$a]['aprobado'] = $item['terminados'];
        $listTmp[$a]['enproceso'] = $item['enproceso'];
        $listTmp[$a]['fallidos'] = $item['fallidos'];
        $listTmp[$a]['female'] = $item['female'];
        $listTmp[$a]['male'] = $item['male'];
        $a++;
        $output .= "<tr>
                    <td>
                        ".$item['course']."
                        
                    </td>
                    <td>
                        ".number_format($item['promedio'], 2) ." %
                    </td>
                    <td>
                        ".$item['terminados'] ."
                    </td>
                    <td>
                        ".$item['enproceso'] ."
                    </td>
                    <td>
                        ".$item['fallidos'] ."
                    </td>
                    <td>
                        ".$item['female'] ."
                    </td>
                    <td>
                        ".$item['male'] ."
                    </td>
                </tr>";
        }
    }
endforeach;
/* Recopilamos los datos */

$timer = strtotime("now");
if (!empty($_REQUEST['exportpdf'])) {
    $html = '<table border="1"  style="width: 100%; table-layout: fixed"><thead><tr>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Capacitación</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Promedio General</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Aprobado</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>En proceso</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Reprobado</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Femenino</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Masculino</span>
        </th>
    </tr></thead>';
    $html .="<tbody>";
    $html .= $output;
    $html .= "</tbody></table>";
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('/var/www/html/wp-content/plugins/capevlac-reportes/calificaciones-' . $timer . '.pdf', $output);

    $pdfname = "reporte" . $timer . ".pdf";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/calificaciones-" . $timer . ".pdf";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a target='_blank' href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);
}

if (!empty($_REQUEST['exportxls'])) {
    $i = 0;
    $list[] = array(
        'Capacitación',
        'Promedio general',
        'Aprobado',
        'En proceso',
        'Reprobado',
        'Femenino',
        'Masculino'
    );

    foreach ($listTmp as $item):
        $list[] = array(
            $item['capacitacion'],
            $item['promediogeneral'],
            $item['aprobado'],
            $item['enproceso'],
            $item['fallidos'],
            $item['female'],
            $item['male']
        );
    endforeach;
    $fp = fopen('/var/www/html/wp-content/plugins/capevlac-reportes/calificaciones-' . $timer . '.csv', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    $pdfname = "reporte" . $timer . ".csv";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/calificaciones-" . $timer . ".csv";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a target='_blank' href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);

    fclose($fp);
    die("Report has to be downloaded");
}
?>
<h3>Calificaciones</h3>
<p class="search-box">
<form id="filterForm" method="post" action="admin.php?page=capevlac-reportes-plugin&tab=calificaciones">
<div class="tablenav top">
    <div class="alignleft actions bulkactions">

            <input type="hidden" name="page" value="capevlac-reportes-plugin"/>
            <input type="hidden" name="tab" value="calificaciones"/>
            <label class="manage-column">
                <select name="pais">
                    <option value="0"> Paises</option>
                    <?php echo $paisesList; ?>
                </select>

            </label>


    </div>
    <div class="alignleft actions">
        <input type="hidden" id="exportpdf" name="exportpdf" value="0">
        <input type="hidden" id="exportxls" name="exportxls" value="0">
        <input type="submit" id="post-query-submit" class="button" value="Enviar">
        <input type="button" name="export" id="export_xls" class="button" value="Exportar a Excel"/>
        <input type="button" name="export" id="export_pdf" class="button" value="Exportar a PDF"/>
    </div>

    <br class="clear">
</div>
</form>

<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Capacitación</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Promedio General</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Aprobado</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>En proceso</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Reprobado</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary">
            <span>Femenino</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Masculino</span>
        </th>
    </tr>
    </thead>
    <tbody id="the-list" data-wp-lists="list:post">
    <?php echo $output; ?>
    </tbody>
    <tfoot>
    <th scope="col" class="manage-column column-email column-primary">
        <span>Capacitación</span>
    </th>
    <th scope="col" class="manage-column column-email column-primary">
        <span>Promedio General</span>
    </th>
    <th scope="col" class="manage-column column-email column-primary">
        <span>Aprobado</span>
    </th>
    <th scope="col" class="manage-column column-email column-primary">
        <span>En proceso</span>
    </th>
    <th scope="col" class="manage-column column-email column-primary">
        <span>Reprobado</span>
    </th>
    <th scope="col" class="manage-column column-email column-primary">
        <span>Femenino</span>
    </th>
    <th scope="col" class="manage-column column-email column-primary">
        <span>Masculino</span>
    </th>
    </tfoot>
</table>
<div class="tablenav bottom">
    <br class="clear">
</div>
<style>
    .text-center {
        text-align: center !important;
    }

    .p-4 {
        padding: 1.2em !important;
    }

    th.manage-column {
        padding: 0.8em !important;
        font-weight: bolder !important;
        font-size: 1em !important;
    }
</style>
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
