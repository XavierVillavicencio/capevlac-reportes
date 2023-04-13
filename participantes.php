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


$wpPreffix = array('wp_','wp_11_','wp_12_','wp_2_','wp_3_','wp_4_','wp_5_','wp_6_','wp_7_','wp_8_','wp_9_');
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
global $wpdb;

$allParticipants = false;
if('wp_' == $wpdb->prefix){
    $courses0 = $wpdb->get_results("SELECT ID,post_title FROM wp_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses9 = $wpdb->get_results("SELECT ID,post_title FROM wp_9_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses11 = $wpdb->get_results("SELECT ID,post_title FROM wp_11_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses12 = $wpdb->get_results("SELECT ID,post_title FROM wp_12_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses2 = $wpdb->get_results("SELECT ID,post_title FROM wp_2_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses3 = $wpdb->get_results("SELECT ID,post_title FROM wp_3_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses4 = $wpdb->get_results("SELECT ID,post_title FROM wp_4_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses5 = $wpdb->get_results("SELECT ID,post_title FROM wp_5_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses6 = $wpdb->get_results("SELECT ID,post_title FROM wp_6_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses7 = $wpdb->get_results("SELECT ID,post_title FROM wp_7_posts WHERE `post_type`='lp_course' and post_status = 'publish'");
    $courses8 = $wpdb->get_results("SELECT ID,post_title FROM wp_8_posts WHERE `post_type`='lp_course' and post_status = 'publish'");

    foreach($courses0 as $item){
        if(!empty($item)) {
            $item->scope = 'wp_';
            $courses[] = $item;
        }
    }


    foreach($courses9 as $item){
        if(!empty($item)){
               $item->scope = 'wp_9_';
            $courses[] = $item;
        }
    }

    foreach($courses11 as $item){
        if(!empty($item)){
               $item->scope = 'wp_11_';
            $courses[] = $item;
        }
    }

    foreach($courses2 as $item){
        if(!empty($item)){
               $item->scope = 'wp_2_';
            $courses[] = $item;
        }
    }

    foreach($courses3 as $item){
        if(!empty($item)){
               $item->scope = 'wp_3_';
            $courses[] = $item;
        }
    }

    foreach($courses4 as $item){
        if(!empty($item)){
               $item->scope = 'wp_4_';
            $courses[] = $item;
        }
    }

    foreach($courses5 as $item){
        if(!empty($item)){
               $item->scope = 'wp_5_';
            $courses[] = $item;
        }
    }

    foreach($courses6 as $item){
        if(!empty($item)){
               $item->scope = 'wp_6_';
            $courses[] = $item;
        }
    }

    foreach($courses7 as $item){
        if(!empty($item)){
               $item->scope = 'wp_7_';
            $courses[] = $item;
        }
    }

    foreach($courses8 as $item){
        if(!empty($item)){
               $item->scope = 'wp_8_';
            $courses[] = $item;
        }
    }


    $course_id = null;
    if (!empty($_REQUEST['courseId'])) {
        $tmpCourseId = explode('||', $_REQUEST['courseId']);
        $course_id = "and " . $tmpCourseId[0] . "learnpress_user_items.`item_id` = " . $tmpCourseId[1];

        $stu = $wpdb->get_results("SELECT distinct user_id,wp_users.* FROM " . $tmpCourseId[0] . "learnpress_user_items,
    wp_users where wp_users.ID = " . $tmpCourseId[0] . "learnpress_user_items.user_id
    " . $course_id . "");

        $participantes = $wpdb->last_result;
    }else{
        
        if(!empty($_REQUEST['getAll'])){
            $participantes = null;
            foreach($wpPreffix as $wpPreffixItem){
                $stuTmp = $wpdb->get_results("SELECT distinct user_id,wp_users.* FROM " . $wpPreffixItem . "learnpress_user_items,
    wp_users where wp_users.ID = " . $wpPreffixItem . "learnpress_user_items.user_id
    " . $course_id . "");
                $participant = $wpdb->last_result;

                foreach($participant as $item){
                    $participantes[] = $item;
                }

            }
        }else{
            $participantes = null;
        }
    }

}else{
    $courses0 = $wpdb->get_results("SELECT ID,post_title FROM $wpdb->posts WHERE `post_type`='lp_course' and post_status = 'publish'");

    foreach($courses0 as $item){
        if(!empty($item)) {
            $item->scope = $wpdb->prefix;
            $courses[] = $item;
        }
    }

    $course_id = null;
    if (!empty($_REQUEST['courseId'])) {
        $tmpCourseId = explode('||', $_REQUEST['courseId']);
        $course_id = "and " . $tmpCourseId[0] . "learnpress_user_items.`item_id` = " . $tmpCourseId[1];
    }

    $stu = $wpdb->get_results("SELECT distinct user_id,wp_users.* FROM " . $wpdb->prefix . "learnpress_user_items,
    wp_users where wp_users.ID = " . $wpdb->prefix . "learnpress_user_items.user_id
    " . $course_id . "");

    $participantes = $wpdb->last_result;

}


$timer = strtotime("now");
if (!empty($_REQUEST['exportxls'])) {
    $i = 0;
    $list[] = array('País',
        'Cédula o Pasaporte',
        'Nombres',
        'Apellidos',
        'Género',
        'Fecha de Nacimiento',
        'Correo Electrónico Institución',
        'Correo Electrónico Personal',
        'Celular',
        'Institución',
        'Cargo',
        'Título Profesional',
        'Usuario'
    );
    foreach ($participantes as $participante):
        $participante_json = $wpdb->get_results("SELECT * FROM wp_users_registered where correoinstitucional like '%" . $participante->user_email . "%'");
        if (empty($participante_json)) {
            continue;
        } else {

            $values = (array) $participante_json[0];
            $list[] = array(
                $values['pais'],
                $values['ci'],
                $values['nombres'],
                $values['apellidos'],
                $values['genero'],
                $values['fechadenacimiento'],
                $values['correoInstitucional'],
                $values['correoalternativo'],
                $values['movil'],
                $values['institucion'],
                $values['cargo'],
                $values['areas'],
                $values['usuario']
            );
        }
    endforeach;
    $fp = fopen('/var/www/html/wp-content/plugins/capevlac-reportes/participantes' . $timer . '.csv', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    $pdfname = "reporte" . $timer . ".csv";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/participantes" . $timer . ".csv";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);

    fclose($fp);
    die("Report has to be downloaded");
}

if (!empty($_REQUEST['exportpdf'])) {

// instantiate and use the dompdf class
    $html = '<table border="1"  style="width: 100%; table-layout: fixed"><thead><tr>
<th>País</th>
             <th style="width:10%;">Cédula o Pasaporte</th>
             <th style="width:10%;">Nombres</th>
             <th style="width:10%;">Apellidos</th>
             <th style="width:10%;">Género</th>
             <th style="width:10%;">Fecha de Nacimiento</th>
             <th style="width:10%;">Correo Electrónico Institución</th>
             <th style="width:10%;">Correo Electrónico Personal</th>
             <th style="width:10%;">Celular</th>
             <th style="width:10%;">Institución</th>
             <th style="width:10%;">Cargo</th>
             <th style="width:10%;">Usuario</th>
</tr></thead>';
    $html .="<tbody>";
    foreach ($participantes as $participante):
    $participante_json = $wpdb->get_results("SELECT * FROM wp_users_registered where correoinstitucional like '%" . $participante->user_email . "%'");
    if (empty($participante_json)) {
        continue;
    } else {

        $values = (array) $participante_json[0];
        $html .= "<tr>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['pais'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['ci'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['nombres'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['apellidos'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['genero'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['fechadenacimiento'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['correoInstitucional'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['correoalternativo'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['movil'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['institucion'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['cargo'] ." ". $values['areas'] . "</td>
                <td style=\"width:10%; word-wrap: break-word;\">" . $values['usuario'] . "</td>
            </tr>";
    }
    endforeach;
    $html .= "</tbody></table>";
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('/var/www/html/wp-content/plugins/capevlac-reportes/reporte' . $timer . '.pdf', $output);

    $pdfname = "reporte" . $timer . ".pdf";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/reporte" . $timer . ".pdf";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);
}

?>
<h3>Base de Datos - Participantes</h3>
<!--<p class="search-box">
    <label class="screen-reader-text" for="flamingo-contact-search-input">Buscar participantes:</label>
    <input type="search" id="flamingo-contact-search-input" name="s" value="">
    <input type="submit" id="search-submit" class="button" value="Buscar participantes"></p>-->
<div class="tablenav top">
    <div class="alignleft actions bulkactions">
        <form action="admin.php?page=capevlac-reportes-plugin">
            <input type="hidden" name="page" value="capevlac-reportes-plugin"/>
            <label for="bulk-action-selector-top" class="screen-reader-text">Selecciona curso</label>
            <select
                    name="courseId" id="courseId">
                <option value="0">
                    Seleccionar un curso
                </option>
                <?php
                foreach ($courses as $course) {
                    $courseSelected = null;
                    $tmpCourseId = explode('||',$_REQUEST['courseId']);

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
            <!-- <label for="bulk-action-selector-top" class="screen-reader-text">Selecciona fecha de inicio</label>
             <input
                     name="start_date" id="bulk-action-selector-top" type="date" placeholder="Fecha de Inicio" />
             <label for="bulk-action-selector-top" class="screen-reader-text">Selecciona fecha de finalización</label>
             <input
                     name="end_date" id="bulk-action-selector-top" type="date" placeholder="Fecha de Finalización" />-->
            <!--
            <input type="submit" id="doaction" class="button action" value="Aplicar">-->
            <input type="submit" id="post-query-submit" class="button" value="Filtro">
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
        <input type="submit" name="export" id="export_xls" class="button" value="Exportar a Excel"/>
        <input type="submit" name="export" id="export_pdf" class="button" value="Exportar a PDF"/>
        <input type="button" name="getAll" id="getAll" class="button" value="Visualizar todos los participantes" onclick="window.location.replace(window.location.href+'&getAll=true');"/>
    </div>

    <br class="clear">
</div>
<table class="wp-list-table widefat fixed striped table-view-list posts">
    <thead>
    <tr>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center" >
                País
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                Cédula o Pasaporte
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                Nombres
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                Correo electrónico
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                Opciones
        </th>
    </tr>
    </thead>

    <tbody id="the-list" data-wp-lists="list:post">
    <?php if (empty($participantes)): ?>
        <tr>
            <th colspan="10">
                <div class="alert alert-danger">
                    No existen resultados
                </div>
            </th>
        </tr>
    <?php else:
        $i = 0;
        foreach ($participantes as $participante):
            $participante_json = $wpdb->get_results("SELECT * FROM wp_users_registered where correoinstitucional like '%" . $participante->user_email . "%'");
            $i++;
            if (empty($participante_json)) {
                continue;
            } else {
                $values = (array) $participante_json[0];
            }
            $tmpCourse = null;
            foreach(json_decode($values['courses']) as $course){
                $tmpCourse .= $course.' - ';
            }
            $values['courses'] = $tmpCourse;

            ?>
            <tr>
                <th scope="col" class=" p-4">
                        <span><?php echo $values['pais'] ?></span>
                </th>
                <th scope="col" class=" text-center">
                        <span><?php echo $values['ci'] ?></span>
                </th>
                <th scope="col" class="">
                        <span><?php echo $values['nombres'] ?> <?php echo $values['apellidos'] ?></span>
                </th>
                <th scope="col" class="">
                        <?php echo $values['correoinstitucional'] ?>
                        <?php 
                            if(trim($values['correoinstitucional']) != trim($values['correoalternativo'])){
                                ?>
                                <br /> 
                                <?php echo $values['correoalternativo']; ?>
                            <?php }?>
                </th>
                <th scope="col" class=" text-center">
                    <button class="open-my-dialog" type="button" data-perfil="<?php echo base64_encode(json_encode($values)); ?>"
                    data-cursos="<?php echo base64_encode(json_encode(array('cursos'=>'12398'))) ?>"
                    >
                        Ver perfil
                    </button>
                </th>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>

    <tfoot>
    <tr>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                <span>País</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                <span>Cédula o Pasaporte</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                <span>Nombres</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                <span>Correo electrónico</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc text-center">
                Opciones
        </th>
    </tr>
    </tfoot>
</table>
<div class="tablenav bottom">
    <div class="alignleft actions">
    </div>
    <div class="tablenav-pages"><span class="displaying-num"><?php echo $i ?> participantes</span>
       </div>
    <br class="clear">
</div>

<!-- The modal / dialog box, hidden somewhere near the footer -->
<div id="my-dialog" class="hidden" style="max-width:70vw">
    <p><b>Usuario:</b>&nbsp;<span id="profileusuario"></span></p>
    <p><b>CI:</b>&nbsp;<span id="profileCI"></span></p>
    <p><b>Nombres:</b>&nbsp;<span id="profilenombres"></span></p>
    <p><b>Apellidos:</b>&nbsp;<span id="profileapellidos"></span></p>
    <p><b>Género:</b>&nbsp;<span id="profileGenero"></span></p>
    <p><b>Fecha de Nacimiento:</b>&nbsp;<span id="profileFechadeNacimiento"></span></p>
    <p><b>Areas:</b>&nbsp;<span id="profileareas"></span></p>
    <p><b>Cargo:</b>&nbsp;<span id="profilecargo"></span></p>
    <p><b>Ciudad:</b>&nbsp;<span id="profileciudad"></span></p>
    <p><b>Correo Institucional:</b>&nbsp;<span id="profilecorreoInstitucional"></span></p>
    <p><b>Correo Alternativo:</b>&nbsp;<span id="profilecorreoalternativo"></span></p>
    <p><b>Estudios:</b>&nbsp;<span id="profileestudios"></span></p>
    <p><b>Institución:</b>&nbsp;<span id="profileinstitucion"></span></p>
    <p><b>Intereses:</b>&nbsp;<span id="profileintereses"></span></p>
    <p><b>Móvil:</b>&nbsp;<span id="profilemovil"></span></p>
    <p><b>País:</b>&nbsp;<span id="profile​pais"></span></p>
    <p><b>Resumen:</b>&nbsp;<span id="profileresumen"></span></p>
    <hr />
    <p><b>Cursos Enrolados:</b>
        <ul>
            <li><span id="courses"></span></li>
        </ul>
    </p>
    <p><b>Cursos en progreso:</b>&nbsp;<span id="coursesInProgress">0</span></p>
    <p><b>Cursos fallidos:</b>&nbsp;<span id="coursesFailed">0</span></p>
    <p><b>Cursos completados:</b>&nbsp;<span id="coursesCompleted">0</span></p>
</div>

<?php 
function get_info_courses( $course_id, $limit, $page, $graduation = '', $username = '', $calc = false ) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $tbl_table_users = $prefix . 'learnpress_user_items';
    if ( ! $course_id ) {
        return false;
    }

    if ( $calc ) {
        $select = 'SQL_CALC_FOUND_ROWS ID';
    } else {
        $select = 'u.user_nicename, u.user_email, ui.user_id, ui.start_time, ui.graduation';
    }

    $where = $wpdb->prepare( 'ui.item_id=%d', absint( $course_id ) );

    if ( ! empty( $graduation ) ) {
        $where .= $wpdb->prepare( ' AND ui.graduation=%s', $graduation );
    }

    if ( ! empty( $username ) ) {
        $where .= $wpdb->prepare( ' AND u.user_nicename LIKE %s', '%' . $wpdb->esc_like( $username ) . '%' );
    }

    if ( $calc ) {
        $sql_limit = '';
    } else {
        $offset    = ( absint( $page ) - 1 ) * $limit;
        $sql_limit = $wpdb->prepare( 'LIMIT %d, %d', $offset, $limit );
    }

    $query = "SELECT $select FROM `{$wpdb->users}` as u INNER JOIN `{$tbl_table_users}` as ui ON u.ID = ui.user_id WHERE $where $sql_limit";

    $result = $wpdb->get_results( stripslashes( $query ), ARRAY_A );

    if ( $calc ) {
        $result = $wpdb->get_var( 'SELECT FOUND_ROWS()' );
    }

    return $result;
}
?>

<style>
    .text-center{
        text-align: center !important;
    }
    .p-4{
        padding: 1.2em !important;
    }

    th.manage-column{
        padding: 0.8em !important;
        font-weight: bolder !important;
        font-size: 1em !important;
    }
</style>

<script>
    window.onload = function() {
        (function ($) {
            // initalise the dialog
            $('#my-dialog').dialog({
                title: 'Perfil del usuario',
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
            $('button.open-my-dialog').click(function (e) {
                e.preventDefault();
                let perfil = $(this).data('perfil')
                let perfilb = window.atob(perfil)
                let jperfil = JSON.parse(perfilb)
                let cursos = $(this).data('cursos')
                let cursosb = window.atob(cursos)
                let jcursos = JSON.parse(cursosb)
                
                $('#profileCI').empty().html(jperfil.ci)
                $('#profileFechadeNacimiento').empty().html(jperfil.FechadeNacimiento)
                $('#profileareas').empty().html(jperfil.areas)
                $('#profilecargo').empty().html(jperfil.cargo)
                $('#profileciudad').empty().html(jperfil.ciudad)
                $('#profilecorreoInstitucional').empty().html(jperfil.correoInstitucional)
                $('#profilecorreoalternativo').empty().html(jperfil.correoalternativo)
                $('#profileestudios').empty().html(jperfil.estudios)
                $('#profileinstitucion').empty().html(jperfil.institucion)
                $('#profileintereses').empty().html(jperfil.intereses)
                $('#profilemovil').empty().html(jperfil.movil)
                $('#profilenombres').empty().html(jperfil.nombres)
                $('#profileapellidos').empty().html(jperfil.apellidos)
                $('#profilepais').empty().html(jperfil.pais)
                $('#profileresumen').empty().html(jperfil.resumen)
                $('#profileusuario').empty().html(jperfil.usuario)
                $('#coursesInProgress').empty().html(jperfil.inprogress)
                $('#coursesCompleted').empty().html(jperfil.passed)
                $('#coursesFailed').empty().html(jperfil.failed)
                $('#courses').empty().html(jperfil.courses)

                $('#my-dialog').dialog('open');
                }  
            );
        })(jQuery);
    }
</script>