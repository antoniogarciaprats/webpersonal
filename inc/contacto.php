<?php
/**
 * Página de contacto (sin formularios ni mapas).
 *
 * ► Textos, temas y preguntas frecuentes: ag_contacto_datos().
 * ► WhatsApp, horario, tiempo de respuesta y ubicación:
 *   Apariencia › Personalizar › Página "Contacto".
 * ► Correo, teléfono y redes salen de "Cabecera profesional" y "Pie de página".
 * ► La plantilla (plantillas/contacto.php) se aplica sola a la página con
 *   dirección /contacto/, o eligiéndola en el editor: Plantilla → "Contacto".
 *
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/contacto.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ¿Estamos en la página de contacto?
 *
 * @return bool
 */
function ag_es_contacto() {
	return is_page_template( 'plantillas/contacto.php' ) || is_page( 'contacto' );
}

/**
 * La página /contacto/ usa este diseño automáticamente
 * (salvo que se elija otra plantilla en el editor).
 *
 * @param string $plantilla Plantilla que WordPress iba a usar.
 * @return string
 */
function ag_contacto_plantilla( $plantilla ) {
	if ( is_page( 'contacto' ) && ! is_page_template() ) {
		$propia = locate_template( 'plantillas/contacto.php' );
		if ( $propia ) {
			return $propia;
		}
	}
	return $plantilla;
}
add_filter( 'template_include', 'ag_contacto_plantilla' );

/**
 * CSS y JS (reutiliza los componentes y animaciones de la portada).
 */
function ag_contacto_assets() {
	if ( ! ag_es_contacto() ) {
		return;
	}

	$dir      = get_template_directory();
	$uri      = get_template_directory_uri();
	$opciones = array(
		'in_footer' => true,
		'strategy'  => 'defer',
	);

	wp_enqueue_style( 'ag-inicio', $uri . '/css/inicio.css', array( 'ag-cabecera' ), filemtime( $dir . '/css/inicio.css' ) );
	wp_enqueue_style( 'ag-contacto', $uri . '/css/contacto.css', array( 'ag-inicio' ), filemtime( $dir . '/css/contacto.css' ) );
	wp_enqueue_script( 'ag-inicio', $uri . '/js/inicio.js', array(), filemtime( $dir . '/js/inicio.js' ), $opciones );
	wp_enqueue_script( 'ag-contacto', $uri . '/js/contacto.js', array(), filemtime( $dir . '/js/contacto.js' ), $opciones );
}
add_action( 'wp_enqueue_scripts', 'ag_contacto_assets', 20 );

/**
 * Opciones en el Personalizador: Página "Contacto".
 *
 * @param WP_Customize_Manager $wp_customize Gestor del Personalizador.
 */
function ag_contacto_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'ag_contacto',
		array(
			'title'       => esc_html__( 'Página "Contacto"', 'antoniogarciaprats' ),
			'description' => esc_html__( 'El correo, el teléfono y las redes se configuran en "Cabecera profesional" y "Pie de página".', 'antoniogarciaprats' ),
			'priority'    => 34,
		)
	);

	$campos = array(
		'ag_whatsapp'    => array( 'WhatsApp (con prefijo, p. ej. +34 600 000 000). Vacío = usa el teléfono', '', 'text', 'sanitize_text_field' ),
		'ag_disponible'  => array( 'Mostrar "Disponible para nuevos proyectos"', true, 'checkbox', 'wp_validate_boolean' ),
		'ag_horario'     => array( 'Horario de atención', 'Lunes a viernes · 9:00 – 18:00', 'text', 'sanitize_text_field' ),
		'ag_respuesta'   => array( 'Tiempo de respuesta', 'Respondo en menos de 24 h laborables', 'text', 'sanitize_text_field' ),
		'ag_ubicacion'   => array( 'Ubicación / modalidad', 'España · Online y presencial', 'text', 'sanitize_text_field' ),
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
				'section' => 'ag_contacto',
				'type'    => $c[2],
			)
		);
	}
}
add_action( 'customize_register', 'ag_contacto_customizer' );

/**
 * CONTENIDOS DE LA PÁGINA DE CONTACTO — edita aquí tus textos.
 *
 * @return array
 */
function ag_contacto_datos() {
	return array(

		'intro' => array(
			'etiqueta' => 'Contacto',
			'titulo'   => 'Hablemos de tu <strong>proyecto</strong>',
			'texto'    => '¿Necesitas una web, una aplicación, formación para tu equipo o quieres aplicar la inteligencia artificial en tu empresa? Cuéntamelo por el canal que prefieras y te responderé personalmente.',
			'puntos'   => array(
				'Primera consulta sin compromiso',
				'Trato directo conmigo, sin intermediarios',
				'Propuesta clara y adaptada a ti',
			),
		),

		/* Botones de tema: abren el correo con el asunto y una plantilla ya escritos. */
		'temas' => array(
			array( 'web', 'Desarrollo web', 'Quiero una página web' ),
			array( 'app', 'App Android', 'Quiero una aplicación Android' ),
			array( 'formacion', 'Formación', 'Formación para mi equipo o centro' ),
			array( 'idea', 'IA en mi empresa', 'Aplicar la IA generativa en mi empresa' ),
			array( 'rrss', 'Colaboración en RRSS', 'Propuesta de colaboración en redes sociales' ),
			array( 'contenido', 'Otra consulta', 'Consulta general' ),
		),

		/* Cómo trabajamos */
		'pasos' => array(
			array( 'Me escribes', 'Cuéntame tu idea, tu necesidad o tu duda por el canal que prefieras.' ),
			array( 'Hablamos', 'Concertamos una llamada o videollamada para entender bien lo que necesitas.' ),
			array( 'Te propongo', 'Recibes una propuesta clara, con plazos y presupuesto, sin letra pequeña.' ),
		),

		/* Preguntas frecuentes (EJEMPLO: revisa y adapta las respuestas) */
		'faq'   => array(
			array( '¿Cuánto cuesta una página web?', 'Depende de lo que necesites: no es lo mismo una web de presentación que una tienda online o una aplicación a medida. Tras una primera conversación te envío un presupuesto cerrado y sin compromiso.' ),
			array( '¿Cuánto tarda en estar lista?', 'Cada proyecto tiene su ritmo. Desde el principio te daré un calendario con las fases y fechas de entrega para que sepas en todo momento en qué punto estamos.' ),
			array( '¿Impartes formación para empresas?', 'Sí. Además de mi trabajo como formador FPE, preparo formaciones a medida sobre programación, desarrollo web e inteligencia artificial generativa, en modalidad presencial u online.' ),
			array( '¿Me ayudas después de entregar el proyecto?', 'Sí. Puedo encargarme del mantenimiento, las actualizaciones y las mejoras de tu web o aplicación, o enseñarte a gestionarla por tu cuenta.' ),
		),
	);
}

/**
 * Enlace "mailto:" con asunto y una plantilla de mensaje.
 *
 * @param string $email  Correo de destino.
 * @param string $asunto Asunto del correo.
 * @return string
 */
function ag_contacto_mailto( $email, $asunto ) {
	$cuerpo = "Hola Antonio,\n\n" .
		"Te escribo porque: \n\n" .
		"— Nombre:\n" .
		"— Empresa (si aplica):\n" .
		"— Plazo aproximado:\n\n" .
		'Gracias.';

	return 'mailto:' . antispambot( $email ) . '?subject=' . rawurlencode( $asunto ) . '&body=' . rawurlencode( $cuerpo );
}

/**
 * Iconos propios de la página de contacto.
 *
 * @param string $nombre Nombre del icono.
 * @return string
 */
function ag_icono_contacto( $nombre ) {
	$iconos = array(
		'whatsapp' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 2.2a9.8 9.8 0 0 0-8.4 14.9L2.3 21.7l4.7-1.2A9.8 9.8 0 1 0 12 2.2z" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M8.6 7.4c.3-.6.7-.6 1-.6h.6c.2 0 .5 0 .7.5l.8 1.9c.1.2.1.4 0 .6l-.5.7c-.1.2-.2.4 0 .6.5.9 1.4 1.8 2.4 2.3.2.1.4.1.6-.1l.7-.8c.2-.2.4-.2.6-.1l1.8.9c.3.1.4.3.4.5 0 .6-.3 1.4-.9 1.7-.7.4-1.6.5-3.4-.3a10.4 10.4 0 0 1-4.6-4.6c-.8-1.6-.5-2.6-.2-3.2z" fill="currentColor"/></svg>',
		'redes'    => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="18" cy="5" r="3" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="6" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="18" cy="19" r="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8.6 10.5l6.8-4M8.6 13.5l6.8 4" stroke="currentColor" stroke-width="2"/></svg>',
		'copiar'   => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="9" y="9" width="12" height="12" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M5 15V5a2 2 0 0 1 2-2h8" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
		'reloj'    => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>',
		'rayo'     => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M13 2L4 14h7l-1 8 9-12h-7z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>',
		'lugar'    => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 22s7-6.2 7-12a7 7 0 0 0-14 0c0 5.8 7 12 7 12z" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="10" r="2.5" fill="none" stroke="currentColor" stroke-width="2"/></svg>',
	);

	return isset( $iconos[ $nombre ] ) ? $iconos[ $nombre ] : '';
}
