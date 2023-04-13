<?php
global $wpdb;
$courses = $wpdb->get_results( "SELECT ID,post_title FROM $wpdb->posts WHERE `post_type`='lp_course' and post_status = 'publish'" );
echo "<pre>"; //
//print_r($courses);
echo "</pre>";

$stu = $wpdb->get_results( "SELECT distinct user_id,wp_users.* FROM ".$wpdb->prefix."learnpress_user_items,wp_users where 
	wp_users.ID = ".$wpdb->prefix."learnpress_user_items.user_id" );
echo "<pre>"; //
//print_r($wpdb);
echo "</pre>";
?>
<h3>Ajustes</h3>
<p class="search-box">
<div class="tablenav top">
    <div class="alignleft actions bulkactions">
    <h2 >Formula encuesta</h2>
        <p><b>ACAP</b>
        
            <br />
            <label><textarea cols='70' rows='5'>{SumaCalificaciones}/{CantidadCursos}</textarea></label>
            <label><textarea cols='70' rows='5'>0.25*{CalificacionContenidos}+0.25*{Instructor}+0.30*{CoordinacionGeneral}+0.10*{AsistenciaTecnica}+0.10*{PlataformaCalificacion}</textarea></label>
        </p>
        <p>
            <label>Oportunidade de los Cursos</label>
            <br />
            <textarea cols='70' rows='5'>{DivulgacionOportunaCurso}+{AccesoOportunoMateriales}+{AdecuacionTiempoDesarrollo}/{CantidadItems}</textarea>
        </p>
    <h2 >Países miembros</h2>
<p><label><input type="checkbox" > Estados Unidos </label></p>
<p><label><input type="checkbox" > Canada </label></p>
<p><label><input type="checkbox" > Bermudas </label></p>
<p><label><input type="checkbox" > Groenlandia </label></p>
<p><label><input type="checkbox" > San Pedro y Miquelón </label></p>
<p><label><input type="checkbox" checked> Argelia </label></p>
<p><label><input type="checkbox"> Antigua y Barbuda </label></p>
<p><label><input type="checkbox"> Aruba </label></p>
<p><label><input type="checkbox"> Bahamas </label></p>
<p><label><input type="checkbox" checked> Barbados </label></p>
<p><label><input type="checkbox"> Cuba </label></p>
<p><label><input type="checkbox"> Dominica </label></p>
<p><label><input type="checkbox" checked> Grenada </label></p>
<p><label><input type="checkbox"> Guadalupe </label></p>
<p><label><input type="checkbox" checked> Haití </label></p>
<p><label><input type="checkbox"> Islas Caimán </label></p>
<p><label><input type="checkbox"> Islas Turcas y Caicos </label></p>
<p><label><input type="checkbox"> Islas Vírgenes </label></p>
<p><label><input type="checkbox" checked> Jamaica </label></p>
<p><label><input type="checkbox"> Martinica </label></p>
<p><label><input type="checkbox"> Puerto Rico </label></p>
<p><label><input type="checkbox"> República Dominicana </label></p>
<p><label><input type="checkbox"> San Bartolomé </label></p>
<p><label><input type="checkbox"> San Cristóbal y Nieves </label></p>
<p><label><input type="checkbox"> San Vicente y las Granadinas </label></p>
<p><label><input type="checkbox"> Santa Lucía </label></p>
<p><label><input type="checkbox" checked> Trinidad y Tobago </label></p>
<p><label><input type="checkbox" checked> Belice </label></p>
<p><label><input type="checkbox" checked> Costa Rica </label></p>
<p><label><input type="checkbox" checked> El Salvador </label></p>
<p><label><input type="checkbox" checked> Guatemala </label></p>
<p><label><input type="checkbox" checked> Honduras </label></p>
<p><label><input type="checkbox" checked> Nicaragua </label></p>
<p><label><input type="checkbox" checked> Panamá </label></p>
<p><label><input type="checkbox" checked> Argentina </label></p>
<p><label><input type="checkbox" checked> Bolivia </label></p>
<p><label><input type="checkbox" checked> Brasil </label></p>
<p><label><input type="checkbox" checked> Chile </label></p>
<p><label><input type="checkbox" checked> Colombia </label></p>
<p><label><input type="checkbox" checked> Ecuador </label></p>
<p><label><input type="checkbox" checked> Guyana </label></p>
<p><label><input type="checkbox"> Guyana Francesa </label></p>
<p><label><input type="checkbox"> Paraguay </label></p>
<p><label><input type="checkbox"> Perú </label></p>
<p><label><input type="checkbox"> Suriname </label></p>
<p><label><input type="checkbox" checked> Uruguay </label></p>
<p><label><input type="checkbox" checked> Venezuela </label></p>
<p><label><input type="checkbox" checked> México </label></p>
        <!--
        <input type="submit" id="doaction" class="button action" value="Aplicar">-->
        <input type="submit" id="post-query-submit" class="button" value="Almacenar">
    </div>
<br class="clear">
</div>