<?php
/**
 * Página del blog (la elegida en Ajustes › Lectura › Página de entradas).
 * El diseño del listado está en template-parts/blog/listado.php.
 *
 * @package antoniogarciaprats
 */

get_header();
get_template_part( 'template-parts/blog/listado' );
get_footer();
