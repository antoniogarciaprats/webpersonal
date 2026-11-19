<?php
/**
 * Funciones del pie de página profesional.
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/pie.php';
 * Necesita inc/cabecera.php (usa ag_icono() y las variables CSS de la cabecera).
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Ubicación de menú para los enlaces legales.
 */
function ag_pie_setup() {
	register_nav_menus(
		array(
			'menu-legal' => esc_html__( 'Menú legal (pie de página)', 'antoniogarciaprats' ),
		)
	);
}
add_action( 'after_setup_theme', 'ag_pie_setup', 20 );

/**
 * 2. Estilos y script del pie.
 */
function ag_pie_assets() {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'ag-pie',
		$uri . '/css/pie.css',
		array( 'ag-cabecera' ),
		filemtime( $dir . '/css/pie.css' )
	);

	wp_enqueue_script(
		'ag-pie',
		$uri . '/js/pie.js',
		array(),
		filemtime( $dir . '/js/pie.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ag_pie_assets', 20 );

/**
 * 3. Opciones en el Personalizador.
 *
 * @param WP_Customize_Manager $wp_customize Gestor del Personalizador.
 */
function ag_pie_customizer( $wp_customize ) {

	$wp_customize->add_section(
		'ag_pie',
		array(
			'title'       => esc_html__( 'Pie de página', 'antoniogarciaprats' ),
			'description' => esc_html__( 'LinkedIn, GitHub y Facebook se configuran en la sección "Cabecera profesional". Las redes que dejes vacías no se muestran.', 'antoniogarciaprats' ),
			'priority'    => 31,
		)
	);

	$campos = array(
		'ag_pie_titulo'    => array( 'Título', 'Conecta conmigo', 'text', 'sanitize_text_field' ),
		'ag_pie_texto'     => array( 'Texto', 'Comparto recursos de programación, desarrollo web y formación tecnológica. ¡Sígueme en redes!', 'textarea', 'sanitize_textarea_field' ),
		'ag_instagram'     => array( 'URL de Instagram', '', 'url', 'esc_url_raw' ),
		'ag_youtube'       => array( 'URL de YouTube', '', 'url', 'esc_url_raw' ),
		'ag_x'             => array( 'URL de X (Twitter)', '', 'url', 'esc_url_raw' ),
		'ag_pie_copyright' => array( 'Texto del copyright', 'Todos los derechos reservados', 'text', 'sanitize_text_field' ),
	);

	foreach ( $campos as $id => $c ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $c[1],
				'sanitize_callback' => $c[3],
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $c[0],
				'section' => 'ag_pie',
				'type'    => $c[2],
			)
		);
	}
}
add_action( 'customize_register', 'ag_pie_customizer' );

/**
 * 4. Redes sociales configuradas, en orden y sin las vacías.
 *
 * @return array clave => array( nombre visible, url )
 */
function ag_redes_sociales() {
	$redes = array(
		'linkedin'  => array( 'LinkedIn', get_theme_mod( 'ag_linkedin', '' ) ),
		'github'    => array( 'GitHub', get_theme_mod( 'ag_github', '' ) ),
		'facebook'  => array( 'Facebook', get_theme_mod( 'ag_facebook', '' ) ),
		'instagram' => array( 'Instagram', get_theme_mod( 'ag_instagram', '' ) ),
		'youtube'   => array( 'YouTube', get_theme_mod( 'ag_youtube', '' ) ),
		'x'         => array( 'X', get_theme_mod( 'ag_x', '' ) ),
	);

	return array_filter(
		$redes,
		function ( $red ) {
			return ! empty( $red[1] );
		}
	);
}

/**
 * 5. Iconos de redes. Añade Instagram, YouTube y X a los de la cabecera.
 *
 * @param string $red Clave de la red social.
 * @return string Marcado SVG.
 */
function ag_icono_red( $red ) {
	$iconos = array(
		'instagram' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="3" width="18" height="18" rx="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="4.2" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="17.4" cy="6.6" r="1.3"/></svg>',
		'youtube'   => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.6 12 3.6 12 3.6s-7.5 0-9.4.5A3 3 0 0 0 .5 6.2 31.4 31.4 0 0 0 0 12a31.4 31.4 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.5 9.4.5 9.4.5s7.5 0 9.4-.5a3 3 0 0 0 2.1-2.1A31.4 31.4 0 0 0 24 12a31.4 31.4 0 0 0-.5-5.8zM9.6 15.6V8.4l6.3 3.6-6.3 3.6z"/></svg>',
		'x'         => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M18.9 1.2h3.7l-8 9.2L24 22.8h-7.4l-5.8-7.6-6.6 7.6H.5l8.6-9.8L0 1.2h7.6l5.2 6.9 6.1-6.9zm-1.3 19.4h2L6.5 3.2H4.3l13.3 17.4z"/></svg>',
	);

	return isset( $iconos[ $red ] ) ? $iconos[ $red ] : ag_icono( $red );
}
