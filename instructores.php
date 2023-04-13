<?php
global $wpdb;
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$args = array(
    'role' => 'lp_teacher',
    'orderby' => 'user_nicename',
    'order' => 'ASC'
);
$users = get_users($args);

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

foreach ($courses0 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_';
        $courses[] = $item;
    }
}


foreach ($courses9 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_9_';
        $courses[] = $item;
    }
}

foreach ($courses11 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_11_';
        $courses[] = $item;
    }
}

foreach ($courses2 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_2_';
        $courses[] = $item;
    }
}

foreach ($courses3 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_3_';
        $courses[] = $item;
    }
}

foreach ($courses4 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_4_';
        $courses[] = $item;
    }
}

foreach ($courses5 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_5_';
        $courses[] = $item;
    }
}

foreach ($courses6 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_6_';
        $courses[] = $item;
    }
}

foreach ($courses7 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_7_';
        $courses[] = $item;
    }
}

foreach ($courses8 as $item) {
    if (!empty($item)) {
        $item->scope = 'wp_8_';
        $courses[] = $item;
    }
}

foreach ($courses as $course) {
    $dataInstructores[] = $wpdb->get_results("SELECT post_id, meta_key, meta_value,post_title FROM " . $course->scope . "postmeta, " . $course->scope . "posts WHERE " . $course->scope . "postmeta.post_id IN (" . $course->ID . ") and meta_key = '_lp_co_teacher' and " . $course->scope . "postmeta.post_id = " . $course->scope . "posts.id ");
}

/* Aqui generamos la mágia en columnas */
    if (empty($users)) {

        $output = "<tr><td colspan=\"10\">No existen resultados</td></tr>";
     } else {
        $output = "";
        foreach ($users as $user):
            $userJson = $wpdb->get_results("SELECT form_value FROM wp_db7_forms where form_value like '%" . $user->data->user_email . "%'");
            if (empty($userJson)) {
                continue;
            }
            $values = unserialize($userJson[0]->form_value);
            $courseHtml = null;
            foreach ($dataInstructores as $courses1) {
                if (!empty($courses1)) {
                    foreach ($courses1 as $coursex) {
                        if ($coursex->meta_value == $user->data->ID) {
                            $courseHtml .= $coursex->post_title ."<br />";
                        }
                    }
                }

            }
            $output .= "<tr>";
            $output .= "<td> ".$values['apellidos']." ". $values['nombres']."</td>";
            $output .= "<td>". $values['CI'] ."</td>";
            $output .= "<td>". $values['movil'] ."</td>";
            $output .= "<td>". $values['cargo'] ."</td>";
            $output .= "<td>". $values['institucion'] ."</td>";
            $output .= "<td>". $courseHtml ."</td>";
            $output .= "</tr>";
        endforeach;
    }


$timer = strtotime("now");
if (!empty($_REQUEST['exportxls'])) {
    $i = 0;
    $list[] = array(
        'Apellidos',
        'Nombres',
        'Cédula o Pasaporte',
        'Movil',
        'Cargo',
        'Institución',
        'Cursos Dictados'
    );
    foreach ($users as $user):
        $userJson = $wpdb->get_results("SELECT form_value FROM wp_db7_forms where form_value like '%" . $user->data->user_email . "%'");
        $courseHtml = null;
        foreach ($dataInstructores as $courses1) {
            if (!empty($courses1)) {
                foreach ($courses1 as $coursex) {
                    if ($coursex->meta_value == $user->data->ID) {
                        $courseHtml .= $coursex->post_title ." -- ";
                    }
                }
            }

        }

        if (empty($userJson)) {
            continue;
        } else {

            $values = unserialize($userJson[0]->form_value);
            $list[] = array(
                $values['apellidos'],
                $values['nombres'],
                $values['CI'],
                $values['movil'],
                $values['cargo'],
                $values['institucion'],
                $courseHtml
            );
        }
    endforeach;
    $fp = fopen('/var/www/html/wp-content/plugins/capevlac-reportes/instructores-' . $timer . '.csv', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    foreach ($list as $fields) {
        fputcsv($fp, $fields);
    }

    $pdfname = "reporte" . $timer . ".csv";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/instructores-" . $timer . ".csv";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);

    fclose($fp);
    die("Report has to be downloaded");
}


if (!empty($_REQUEST['exportpdf'])) {

// instantiate and use the dompdf class
    $html = '<table border="1"  style="width: 100%; table-layout: fixed"><thead><tr>
             <th style="width:10%;">Apellidos</th>
             <th style="width:10%;">Nombres</th>
             <th style="width:10%;">Cédula o Pasaporte</th>
             <th style="width:10%;">Movil</th>
             <th style="width:10%;">Cargo</th>
             <th style="width:10%;">Institución</th>
             <th style="width:10%;">Cursos Dictados</th>
</tr></thead>';
    $html .="<tbody>";
    foreach ($users as $user):
        $userJson = $wpdb->get_results("SELECT form_value FROM wp_db7_forms where form_value like '%" . $user->data->user_email . "%'");
        $courseHtml = null;
        foreach ($dataInstructores as $courses1) {
            if (!empty($courses1)) {
                foreach ($courses1 as $coursex) {
                    if ($coursex->meta_value == $user->data->ID) {
                        $courseHtml .= $coursex->post_title ." -- ";
                    }
                }
            }

        }

        if (empty($userJson)) {
            continue;
        } else {
            $values = unserialize($userJson[0]->form_value);
            $html .= "<tr><td>".$values['apellidos']."</td>";
            $html .= "<td>".$values['nombres']."</td>";
            $html .= "<td>".$values['CI']."</td>";
            $html .= "<td>".$values['movil']."</td>";
            $html .= "<td>".$values['cargo']."</td>";
            $html .= "<td>".$values['institucion']."</td>";
            $html .= "<td>".$courseHtml."</td></tr>";
        }
    endforeach;
                // <td style=\"width:10%; word-wrap: break-word;\">" . $values['usuario'] . "</td>
    $html .= "</tbody></table>";
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('/var/www/html/wp-content/plugins/capevlac-reportes/instructores-' . $timer . '.pdf', $output);

    $pdfname = "reporte" . $timer . ".pdf";
    $file_url = "https://capevlac.olade.org/wp-content/plugins/capevlac-reportes/instructores-" . $timer . ".pdf";
    echo "<h2>Reporte generado correctamente; puede descargarlo en el siguiente: <a href='" . $file_url . "'>Enlace</a></h2>";
    exit(0);
}

?>

<h3>Instructores</h3>
<p class="search-box">
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
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Nombres</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Cédula o Pasaporte</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Teléfono Móvil</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Ocupación</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Institución</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Capacitaciones Dictadas</span>
        </th>
    </tr>
    </thead>
    <tbody id="the-list" data-wp-lists="list:post">
    <?php echo $output; ?>
    </tbody>
    <tfoot>
    <tr>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Nombres</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Cédula o Pasaporte</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Teléfono Móvil</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Ocupación</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Institución</span>
        </th>
        <th scope="col" class="manage-column column-email column-primary sortable desc">
            <span>Capacitaciones Dictadas</span>
        </th>
    </tr>
    </tfoot>
</table>
<div class="tablenav bottom">
    <div class="alignleft actions">
    </div>
    <div class="tablenav-pages">
        <span class="displaying-num"><?php echo count($users); ?> instructores</span>
    </div>
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
    window.onload = function () {
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

                    console.info(jperfil)
                    console.info(jcursos)

                    $('#profileCI').empty().html(jperfil.CI)
                    $('#profileFechadeNacimiento').empty().html(jperfil.FechadeNacimiento)
                    $('#profileareas').empty().html(jperfil.areas[0])
                    $('#profilecargo').empty().html(jperfil.cargo)
                    $('#profileciudad').empty().html(jperfil.ciudad)
                    $('#profilecorreoInstitucional').empty().html(jperfil.correoInstitucional)
                    $('#profilecorreoalternativo').empty().html(jperfil.correoalternativo)
                    $('#profileestudios').empty().html(jperfil.estudios[0])
                    $('#profileinstitucion').empty().html(jperfil.institucion)
                    $('#profileintereses').empty().html(jperfil.intereses[0])
                    $('#profilemovil').empty().html(jperfil.movil)
                    $('#profilenombres').empty().html(jperfil.nombres)
                    $('#profilepais').empty().html(jperfil.pais)
                    $('#profileresumen').empty().html(jperfil.resumen)
                    $('#profileusuario').empty().html(jperfil.usuario)

                    $('#my-dialog').dialog('open');
                }
            );
        })(jQuery);
    }
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