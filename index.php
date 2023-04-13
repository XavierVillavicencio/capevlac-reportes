<?php
/*
Plugin Name: Capevlac Reportes
Description: Capevlac Reportes
Author: Xavier Villavicencio B.
Version: 0.1
*/
add_action('admin_menu', 'capevlac_reportes_plugin_setup_menu');
add_action( 'admin_init', 'update_capevlac_reportes_post_info' );
wp_enqueue_script( 'jquery-ui-dialog' ); // jquery and jquery-ui should be dependencies, didn't check though...
wp_enqueue_style( 'wp-jquery-ui-dialog' );

function capevlac_reportes_plugin_setup_menu(){
    add_menu_page( 'Capevlac Reportes', 'Capevlac Reportes', 'administrator', 'capevlac-reportes-plugin', 'admin_page_html' );

    add_submenu_page( 'capevlac-reportes-plugin', 'Participantes / Base de Datos', 'Participantes / Base de Datos', 'administrator', 'capevlac-reportes-plugin');
    add_submenu_page( 'capevlac-reportes-plugin', 'Capacitaciones', 'Capacitaciones', 'administrator', 'capevlac-reportes-plugin&tab=capacitaciones', 'capacitaciones');
    add_submenu_page( 'capevlac-reportes-plugin', 'Calificaciones', 'Calificaciones', 'administrator', 'capevlac-reportes-plugin&tab=calificaciones', 'calificaciones');
    add_submenu_page( 'capevlac-reportes-plugin', 'Participación por Países', 'Participación por Países', 'administrator', 'capevlac-reportes-plugin&tab=paises', 'paises');
    add_submenu_page( 'capevlac-reportes-plugin', 'Instructores', 'Instructores', 'administrator', 'capevlac-reportes-plugin&tab=instructores', 'instructores');
    add_submenu_page( 'capevlac-reportes-plugin', 'Encuesta', 'Encuesta', 'administrator', 'capevlac-reportes-plugin&tab=encuesta', 'encuesta');
	add_submenu_page( 'capevlac-reportes-plugin', 'Zoom - Reuniones', 'Zoom - Reuniones', 'zoom', 'capevlac-reportes-plugin&tab=zoom','zoom');
    add_submenu_page( 'capevlac-reportes-plugin', 'Ajustes', 'Ajustes', 'administrator', 'capevlac-reportes-plugin&tab=ajustes', 'ajustes');
    add_submenu_page( 'capevlac-reportes-plugin', 'Registros', 'Registros', 'administrator', 'capevlac-reportes-plugin&tab=registros', 'registros');
	add_submenu_page( 'capevlac-reportes-plugin', 'Información', 'Información', 'administrator', 'capevlac-reportes-plugin&tab=info', 'info');
}


if( !function_exists("update_capevlac_reportes_post_info") ) {
	function update_capevlac_reportes_post_info() {
	    register_setting('capevlac-reportes-post-settings', 'oauth2_url' );
	    register_setting('capevlac-reportes-post-settings', 'oauth2_user' );
	    register_setting('capevlac-reportes-post-settings', 'oauth2_pass' );
	    register_setting('capevlac-reportes-post-settings', 'front_end_url' );
	}

}


function admin_page_html() {
	// check user capabilities
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}



	//Get the active tab from the $_GET param
	$default_tab = null;
	$tab         = isset( $_GET['tab'] ) ? $_GET['tab'] : $default_tab;

	?>
	<!-- Our admin page content should all be inside .wrap -->
	<div class="wrap">
		<!-- Print the page title -->
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<!-- Here are our tabs -->
		<nav class="nav-tab-wrapper">
			<a href="?page=capevlac-reportes-plugin"
			   class="nav-tab <?php if ( $tab === null ): ?>nav-tab-active<?php endif; ?>">Base de Datos - Participantes</a>
			<a href="?page=capevlac-reportes-plugin&tab=capacitaciones"
			   class="nav-tab <?php if ( $tab === 'capacitaciones' ): ?>nav-tab-active<?php endif; ?>">Capacitaciones</a>
			<a href="?page=capevlac-reportes-plugin&tab=calificaciones"
			   class="nav-tab <?php if ( $tab === 'calificaciones' ): ?>nav-tab-active<?php endif; ?>">Calificaciones</a>
			<a href="?page=capevlac-reportes-plugin&tab=paises"
			   class="nav-tab <?php if ( $tab === 'paises' ): ?>nav-tab-active<?php endif; ?>">Participación por Países</a>
			<a href="?page=capevlac-reportes-plugin&tab=instructores"
			   class="nav-tab <?php if ( $tab === 'instructores' ): ?>nav-tab-active<?php endif; ?>">Instructores</a>
			<a href="?page=capevlac-reportes-plugin&tab=encuesta"
			   class="nav-tab <?php if ( $tab === 'encuesta' ): ?>nav-tab-active<?php endif; ?>">Encuesta de Satisfacción</a>
			<a href="?page=capevlac-reportes-plugin&tab=zoom"
			   class="nav-tab <?php if ( $tab === 'zoom' ): ?>nav-tab-active<?php endif; ?>">Reportes Zoom - Reuniones</a>
			<a href="?page=capevlac-reportes-plugin&tab=ajustes"
			   class="nav-tab <?php if ( $tab === 'ajustes' ): ?>nav-tab-active<?php endif; ?>">Ajustes</a>
		   <a href="?page=capevlac-reportes-plugin&tab=registros"
			   class="nav-tab <?php if ( $tab === 'registros' ): ?>nav-tab-active<?php endif; ?>">Registros</a>
			<a href="?page=capevlac-reportes-plugin&tab=info"
			   class="nav-tab <?php if ( $tab === 'info' ): ?>nav-tab-active<?php endif; ?>">Información</a>
		</nav>

		<div class="tab-content">
			<?php switch ( $tab ) :
				case 'info':
					echo info(); //Put your HTML here
					break;
				case 'capacitaciones':
					echo capacitaciones(); //Put your HTML here
					break;
				case 'calificaciones':
					echo calificaciones(); //Put your HTML here
					break;
				case 'instructores':
					echo instructores();
					break;
				case 'paises':
					echo paises();
					break;
				case 'encuesta':
					echo encuesta();
					break;
				case 'zoom':
					echo zoom();
					break;
                case 'ajustes':
                    echo ajustes();
                    break;
                case 'registros':
                    echo registros();
                    break;
				default:
					echo capevlac_reportes_init();
					break;
			endswitch; ?>
		</div>
	</div>
	<?php
}
function capevlac_reportes_init(){
    include('participantes.php');
}
function capacitaciones(){
    include('capacitaciones.php');
}
function paises(){
    include('participacion-paises.php');
}
function instructores(){
    include('instructores.php');
}
function calificaciones(){
    include('calificaciones.php');
}
function zoom(){
    include('zoom.php');
}

function encuesta(){
    echo "<style>
    .titleResumen{
        color:#fff !important;
        text-shadow: 1px 1px 1px #000 !important;
    }
    .titleBg{
        background:#666 !important;
    }

    .text-center{
        text-align: center;
        margin:0 auto;
    }

    .text-right{
        text-align: right;
    }
</style>
";
    include('encuesta.php');
}

function debug($title,$var){
    $o  = "<pre>";
    $o .= $title."/t/n";
    $o .= print_r($var,true)."/t/n";
    $o .= "</pre>";

    return $o;
}

function info(){
    echo "<h3>Ajustes Encuesta</h3>";
	echo "Información técnica que describe el funcionamiento de los reportes y la forma en que se realizan los ajustes de la encuesta de satisfacción del cliente.";
	}

function ajustes(){
    include('ajustes.php');
	}
	
function wpse27856_set_content_type(){
    return "text/html";
}

function registros(){
	add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );
	global $wpdb;
    $stu = $wpdb->get_results("SELECT * FROM wp_users_registeremails where issend = 0"); //  
	//$participantes = $wpdb->last_result;
	echo "
		<h1>Mensajes pendientes de envío <button onClick='location.reload()'>Enviar Mensajes</button></h1>
		<table class='wp-list-table widefat fixed striped table-view-list posts'>";
	echo "
		<thead><tr>
			<th>Id</th>
			<th>Fecha de Registro</th>
			<th>Fecha de Envío</th>
			<th>Destinatario</th>
			<th>Procedente</th>
			<th>Titulo</th>
		</tr>
		</thead><tbody>
		";
	foreach($stu as $item):
		$to = $item->to_email;
		$subject = $item->subject;
		$body = $item->message;
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Capevlac <'.$item->from_email.'>');
		if(wp_mail( $to, $subject, $body, $headers )){
        	$id = stripslashes_deep($_POST['id']); 
        	$title = stripslashes_deep($_POST['title']);
        	$message = stripslashes_deep($_POST['message']);

        	$wpdb->update('wp_users_registeremails', 
            				array('date_send'=>'NOW()', 'issend'=>1),
                            array('id'=>$item->id)
                         );
        }else{
        	echo "<tr>";
			echo "<td>".$item->id."</td>";
			echo "<td>".$item->date_register."</td>";
			echo "<td>".$item->date_send."</td>";
			echo "<td>".$item->to_email."</td>";
			echo "<td>".$item->from_email."</td>";
			echo "<td>".$item->subject."</td>";
			echo "</tr>";
        }
	endforeach;
	echo "</tbody></table>";
	/// ahora mostramos los enviados
	$stu = $wpdb->get_results("SELECT * FROM wp_users_registeremails where issend = 1"); //  
	//$participantes = $wpdb->last_result;
	echo "
		<h1>Mensajes enviados</h1>
		<table class='wp-list-table widefat fixed striped table-view-list posts'>";
	echo "
		<thead><tr>
			<th>Id</th>
			<th>Fecha de Registro</th>
			<th>Fecha de Envío</th>
			<th>Destinatario</th>
			<th>Procedente</th>
			<th>Titulo</th>
		</tr>
		</thead><tbody>
		";
	foreach($stu as $item):
	
		$to = $item->to_email;
		$subject = $item->subject;
		$body = $item->message;
		$headers = array('Content-Type: text/html; charset=UTF-8','From: Capevlac <'.$item->from_email.'>');
		echo "<tr>";
		echo "<td>".$item->id."</td>";
		echo "<td>".$item->date_register."</td>";
		echo "<td>".$item->date_send."</td>";
		echo "<td>".$item->to_email."</td>";
		echo "<td>".$item->from_email."</td>";
		echo "<td>".$item->subject."</td>";
		echo "</tr>";		
	endforeach;
	echo "</tbody></table>";
		//echo "<pre>";
		//var_dump($stu);
		//echo "</pre>";
	}

?>