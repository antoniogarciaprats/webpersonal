<?php
/**
 * Funciones de la cabecera profesional.
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/cabecera.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. Soportes del tema: menús, logo e imagen de cabecera.
 */
function ag_cabecera_setup() {

	// Dos menús: a la izquierda y a la derecha del logo.
	register_nav_menus(
		array(
			'menu-izquierda' => esc_html__( 'Menú principal (izquierda del logo)', 'antoniogarciaprats' ),
			'menu-derecha'   => esc_html__( 'Menú principal (derecha del logo)', 'antoniogarciaprats' ),
		)
	);

	// Logo personalizado (Apariencia > Personalizar > Identidad del sitio).
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 192,
			'width'       => 192,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	// Imagen de cabecera (Apariencia > Personalizar > Imagen de cabecera).
	add_theme_support(
		'custom-header',
		array(
			'default-image' => get_template_directory_uri() . '/images/cabecera-hero.jpg',
			'width'         => 1920,
			'height'        => 900,
			'flex-width'    => true,
			'flex-height'   => true,
			'header-text'   => false,
		)
	);
}
add_action( 'after_setup_theme', 'ag_cabecera_setup', 20 );

/**
 * Las páginas admiten "Extracto": se usa como subtítulo de su cabecera.
 */
function ag_extracto_paginas() {
	add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'ag_extracto_paginas' );

/**
 * 2. Estilos, fuentes y script.
 */
function ag_cabecera_assets() {
	// La versión es la fecha de modificación del archivo: cada vez que lo cambies,
	// el navegador descargará la versión nueva en lugar de usar la caché.
	$css_ver = filemtime( get_template_directory() . '/css/cabecera.css' );
	$js_ver  = filemtime( get_template_directory() . '/js/cabecera.js' );

	// Google Fonts. Para cumplir el RGPD es preferible alojarlas en local (ver notas).
	wp_enqueue_style(
		'ag-fuentes',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Open+Sans:wght@400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'ag-cabecera',
		get_template_directory_uri() . '/css/cabecera.css',
		array( 'ag-fuentes' ),
		$css_ver
	);

	wp_enqueue_script(
		'ag-cabecera',
		get_template_directory_uri() . '/js/cabecera.js',
		array(),
		$js_ver,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);

	// El navigation.js de Underscores ya no se usa con esta cabecera.
	wp_dequeue_script( 'antoniogarciaprats-navigation' );
}
add_action( 'wp_enqueue_scripts', 'ag_cabecera_assets', 20 );

/**
 * 3. Opciones en el Personalizador: contacto, redes y textos del rótulo.
 *
 * @param WP_Customize_Manager $wp_customize Gestor del Personalizador.
 */
function ag_cabecera_customizer( $wp_customize ) {

	$wp_customize->add_section(
		'ag_cabecera',
		array(
			'title'    => esc_html__( 'Cabecera profesional', 'antoniogarciaprats' ),
			'priority' => 30,
		)
	);

	$campos = array(
		'ag_email'      => array( 'Correo electrónico', 'info@antoniogarciaprats.es', 'email', 'sanitize_email' ),
		'ag_telefono'   => array( 'Teléfono', '+34 600 000 000', 'text', 'sanitize_text_field' ),
		'ag_linkedin'   => array( 'URL de LinkedIn', '', 'url', 'esc_url_raw' ),
		'ag_github'     => array( 'URL de GitHub', '', 'url', 'esc_url_raw' ),
		'ag_facebook'   => array( 'URL de Facebook', '', 'url', 'esc_url_raw' ),
		'ag_etiqueta'   => array( 'Etiqueta sobre el eslogan', 'Desarrollador · Formador · Creador digital', 'text', 'sanitize_text_field' ),
		'ag_eslogan'    => array( 'Eslogan (admite <strong>)', 'Transformamos tu visión en <strong>innovación digital</strong>', 'text', 'ag_sanitizar_eslogan' ),
		'ag_subtitulo'  => array( 'Subtítulo', 'Desarrollo web a medida, programación de aplicaciones y formación tecnológica para profesionales y empresas.', 'textarea', 'sanitize_textarea_field' ),
		'ag_btn1_texto' => array( 'Botón 1: texto', 'Ver servicios', 'text', 'sanitize_text_field' ),
		'ag_btn1_url'   => array( 'Botón 1: enlace', '#servicios', 'text', 'esc_url_raw' ),
		'ag_btn2_texto' => array( 'Botón 2: texto', 'Contactar', 'text', 'sanitize_text_field' ),
		'ag_btn2_url'   => array( 'Botón 2: enlace', '#contacto', 'text', 'esc_url_raw' ),
	);

	// Imagen por defecto de las cabeceras de sección.
	$wp_customize->add_setting(
		'ag_imagen_secciones',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ag_imagen_secciones',
			array(
				'label'       => esc_html__( 'Imagen por defecto de las páginas interiores', 'antoniogarciaprats' ),
				'description' => esc_html__( 'Se usa cuando la página no tiene imagen destacada. Recomendado: 1920 × 700 px.', 'antoniogarciaprats' ),
				'section'     => 'ag_cabecera',
				'priority'    => 5,
			)
		)
	);

	foreach ( $campos as $id => $c ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $c[1],
				'sanitize_callback' => $c[3],
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $c[0],
				'section' => 'ag_cabecera',
				'type'    => $c[2],
			)
		);
	}
}
add_action( 'customize_register', 'ag_cabecera_customizer' );

/**
 * Permite solo <strong>, <em> y <br> en el eslogan.
 *
 * @param string $valor Texto introducido.
 * @return string
 */
function ag_sanitizar_eslogan( $valor ) {
	return wp_kses(
		$valor,
		array(
			'strong' => array(),
			'em'     => array(),
			'br'     => array(),
		)
	);
}

/**
 * 3b. CABECERA DE SECCIÓN (páginas interiores)
 * ------------------------------------------------------------------------
 */

/**
 * ID de la página que "representa" la vista actual (la propia página o
 * entrada, o la página de entradas del blog). 0 si no hay ninguna.
 *
 * @return int
 */
function ag_id_seccion() {
	if ( is_home() && ! is_front_page() ) {
		return (int) get_option( 'page_for_posts' );
	}
	if ( is_singular() ) {
		return (int) get_queried_object_id();
	}
	return 0;
}

/**
 * Imagen de fondo de la cabecera de sección:
 * imagen destacada → imagen del Personalizador → imagen por defecto del tema.
 *
 * @return string URL.
 */
function ag_imagen_seccion() {
	$id = ag_id_seccion();
	if ( $id && has_post_thumbnail( $id ) ) {
		return get_the_post_thumbnail_url( $id, 'full' );
	}

	$personalizada = get_theme_mod( 'ag_imagen_secciones', '' );
	if ( $personalizada ) {
		return $personalizada;
	}

	return get_template_directory_uri() . '/images/seccion-defecto.jpg';
}

/**
 * Título (rótulo) de la cabecera de sección.
 *
 * @return string Texto plano.
 */
function ag_titulo_seccion() {
	if ( is_home() && ! is_front_page() ) {
		$titulo = get_the_title( get_option( 'page_for_posts' ) );
	} elseif ( is_singular() ) {
		$titulo = single_post_title( '', false );
	} elseif ( is_archive() ) {
		$titulo = get_the_archive_title();
	} elseif ( is_search() ) {
		/* translators: %s: término buscado */
		$titulo = sprintf( __( 'Resultados para: %s', 'antoniogarciaprats' ), get_search_query() );
	} elseif ( is_404() ) {
		$titulo = __( 'Página no encontrada', 'antoniogarciaprats' );
	} else {
		$titulo = get_bloginfo( 'name' );
	}

	return wp_strip_all_tags( $titulo );
}

/**
 * Subtítulo de la cabecera de sección:
 * extracto de la página, fecha de la entrada o descripción del archivo.
 *
 * @return string Texto plano (puede estar vacío).
 */
function ag_subtitulo_seccion() {
	$id = ag_id_seccion();

	if ( $id && has_excerpt( $id ) ) {
		return wp_strip_all_tags( get_the_excerpt( $id ) );
	}
	if ( is_single() ) {
		/* translators: %s: fecha de publicación */
		return sprintf( __( 'Publicado el %s', 'antoniogarciaprats' ), get_the_date() );
	}
	if ( is_archive() ) {
		return wp_strip_all_tags( get_the_archive_description() );
	}
	if ( is_404() ) {
		return __( 'La página que buscas no existe o se ha movido.', 'antoniogarciaprats' );
	}

	return '';
}

/**
 * Migas de pan: Inicio › (páginas superiores / Blog) › Página actual.
 */
function ag_migas_de_pan() {
	$migas = array(
		array( __( 'Inicio', 'antoniogarciaprats' ), home_url( '/' ) ),
	);

	if ( is_page() ) {
		foreach ( array_reverse( get_post_ancestors( get_queried_object_id() ) ) as $padre ) {
			$migas[] = array( get_the_title( $padre ), get_permalink( $padre ) );
		}
	} elseif ( is_single() || is_archive() ) {
		$blog = (int) get_option( 'page_for_posts' );
		if ( $blog ) {
			$migas[] = array( get_the_title( $blog ), get_permalink( $blog ) );
		}
	}

	$migas[] = array( ag_titulo_seccion(), '' );

	echo '<nav class="ag-migas" aria-label="' . esc_attr__( 'Migas de pan', 'antoniogarciaprats' ) . '"><ol>';
	foreach ( $migas as $miga ) {
		if ( $miga[1] ) {
			echo '<li><a href="' . esc_url( $miga[1] ) . '">' . esc_html( $miga[0] ) . '</a></li>';
		} else {
			echo '<li aria-current="page">' . esc_html( $miga[0] ) . '</li>';
		}
	}
	echo '</ol></nav>';
}

/**
 * 4. Iconos SVG en línea (sin dependencias externas).
 *
 * @param string $nombre Nombre del icono.
 * @return string Marcado SVG.
 */
function ag_icono( $nombre ) {
	$iconos = array(
		'logo'     => '<svg class="ag-logo" viewBox="31 56 138 88" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg"><defs><mask id="ag-logo-hueco"><rect x="0" y="0" width="200" height="200" fill="#fff"/><rect x="84" y="92.6" width="14" height="14" fill="#000"/></mask></defs><g fill="none" stroke="currentColor" stroke-width="9.5" stroke-linecap="round" stroke-linejoin="round"><path d="M40 135 62.5 64.75 85 135"/><path d="M151.16 77.19A34 34 0 1 0 159.5 99.5" mask="url(#ag-logo-hueco)"/><path d="M51 99.5H159.5"/></g></svg>',
		'email'    => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4.24-8 5-8-5V6l8 5 8-5v2.24z"/></svg>',
		'telefono' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z"/></svg>',
		'linkedin' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.85 0-2.14 1.45-2.14 2.94v5.67H9.35V9h3.41v1.56h.05c.48-.9 1.64-1.85 3.37-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28zM5.34 7.43a2.06 2.06 0 1 1 0-4.13 2.06 2.06 0 0 1 0 4.13zM7.12 20.45H3.56V9h3.56v11.45zM22.22 0H1.77C.79 0 0 .77 0 1.73v20.54C0 23.23.79 24 1.77 24h20.45c.98 0 1.78-.77 1.78-1.73V1.73C24 .77 23.2 0 22.22 0z"/></svg>',
		'github'   => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 .3a12 12 0 0 0-3.8 23.38c.6.12.83-.26.83-.57v-2.23c-3.34.72-4.04-1.42-4.04-1.42-.55-1.39-1.33-1.76-1.33-1.76-1.09-.74.08-.73.08-.73 1.2.09 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.5 1 .1-.78.42-1.31.76-1.61-2.67-.3-5.47-1.33-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.14-.3-.54-1.52.1-3.18 0 0 1-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.28-1.55 3.29-1.23 3.29-1.23.64 1.66.24 2.88.12 3.18a4.65 4.65 0 0 1 1.23 3.22c0 4.61-2.8 5.63-5.48 5.92.42.36.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .3"/></svg>',
		'facebook' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M24 12.07C24 5.41 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.5 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.5h-2.8V24C19.62 23.1 24 18.1 24 12.07"/></svg>',
	);

	return isset( $iconos[ $nombre ] ) ? $iconos[ $nombre ] : '';
}
