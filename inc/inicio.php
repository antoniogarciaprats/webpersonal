<?php
/**
 * Página de inicio: contenidos, recursos y utilidades.
 *
 * ► Todos los textos de la portada se editan en ag_inicio_datos().
 * ► Los logos de empresas se cargan solos desde /images/empresas/.
 * ► Tu foto de presentación: Personalizar › Portada, o /images/sobre-mi.jpg (vertical, 4:5).
 *
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/inicio.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 1. CSS y JS solo en la portada.
 */
function ag_inicio_assets() {
	if ( ! is_front_page() ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'ag-inicio',
		$uri . '/css/inicio.css',
		array( 'ag-cabecera' ),
		filemtime( $dir . '/css/inicio.css' )
	);

	wp_enqueue_script(
		'ag-inicio',
		$uri . '/js/inicio.js',
		array(),
		filemtime( $dir . '/js/inicio.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'ag_inicio_assets', 20 );

/**
 * 2. CONTENIDOS DE LA PORTADA — edita aquí tus textos.
 *
 * @return array
 */
function ag_inicio_datos() {
	return array(

		/* ---------- Sobre mí ---------- */
		'sobre_mi'   => array(
			'etiqueta'   => 'Hola, soy Antonio',
			'titulo'     => 'Tecnología, código y formación con un mismo propósito: <strong>ayudarte a crecer</strong>',
			'parrafos'   => array(
				'Soy un apasionado de la tecnología y la programación. Trabajo como <strong>formador de Formación Profesional para el Empleo (FPE)</strong> a tiempo completo y, en paralelo, desarrollo páginas web y aplicaciones con Java, Python y tecnologías web.',
				'Comparto lo que aprendo creando contenido en redes sociales y ayudo a las empresas a sacar partido a la <strong>inteligencia artificial generativa</strong> en su día a día, de forma práctica y sin tecnicismos.',
			),
			'destacados' => array(
				'Formador FPE a tiempo completo',
				'Desarrollo web y aplicaciones Java y Python',
				'IA generativa aplicada a la empresa',
				'Divulgación tecnológica en redes sociales',
			),
			'boton'      => array( 'Hablemos de tu proyecto', '#contacto' ),
			'chips'      => array( '</> Java · Python', 'IA generativa', 'Formador FPE' ),
		),

		/* ---------- Cifras (EJEMPLO: pon las tuyas) ---------- */
		'cifras'     => array(
			array( 10, '+', 'años de experiencia' ),
			array( 1500, '+', 'alumnos formados' ),
			array( 40, '+', 'proyectos desarrollados' ),
			array( 25, '+', 'cursos impartidos' ),
		),

		/* ---------- Servicios ---------- */
		'servicios'  => array(
			array(
				'icono'     => 'web',
				'color'     => '#437eb6',
				'titulo'    => 'Desarrollo web',
				'texto'     => 'Webs corporativas y aplicaciones web a medida: rápidas, accesibles, adaptadas a móvil y optimizadas para buscadores.',
				'etiquetas' => array( 'WordPress', 'HTML · CSS', 'JavaScript', 'PHP' ),
			),
			array(
				'icono'     => 'app',
				'color'     => '#2bb3a0',
				'titulo'    => 'Apps y software a medida',
				'texto'     => 'Apps Android, aplicaciones web con Django y programas a medida en Python, Java y C/C++, conectados a tus servicios y datos.',
				'etiquetas' => array( 'Android', 'Django', 'Python', 'Java', 'C/C++' ),
			),
			array(
				'icono'     => 'formacion',
				'color'     => '#7a5cd6',
				'titulo'    => 'Formación',
				'texto'     => 'Cursos de programación, desarrollo web e IA generativa para centros de formación y empresas, presenciales u online.',
				'etiquetas' => array( 'FPE', 'Certificados de profesionalidad', 'IA', 'Programación' ),
			),
			array(
				'icono'     => 'rrss',
				'color'     => '#e8566c',
				'titulo'    => 'Contenidos para RRSS',
				'texto'     => 'Contenido divulgativo sobre tecnología, programación e IA: vídeos, tutoriales y publicaciones que conectan con tu audiencia.',
				'etiquetas' => array( 'Vídeo', 'Tutoriales', 'Divulgación', 'Estrategia' ),
			),
		),

		/* ---------- Tecnologías ---------- */
		'stack'      => array(
			'Programación'            => array( 'Java', 'Python', 'JavaScript', 'PHP', 'C', 'C++' ),
			'Desarrollo web'          => array( 'HTML5', 'CSS3', 'WordPress', 'Responsive', 'SEO' ),
			'Móvil'                   => array( 'Android', 'Java', 'APIs REST', 'SQLite' ),
			'Inteligencia artificial' => array( 'IA generativa', 'Prompt engineering', 'Automatización', 'Asistentes virtuales' ),
		),

		/* ---------- Beneficios de la IA (sección parallax) ---------- */
		'ia'         => array(
			'etiqueta' => 'Inteligencia artificial generativa',
			'titulo'   => 'La IA ya está transformando las empresas. <strong>¿Y la tuya?</strong>',
			'texto'    => 'Te ayudo a integrar la IA generativa en tus procesos de forma práctica, segura y adaptada a tu equipo.',
			'frase'    => 'No se trata de sustituir a las personas, sino de <strong>multiplicar su talento</strong>.',
		),
		'beneficios' => array(
			array( 'automatizar', 'Automatiza tareas repetitivas', 'Libera horas en informes, correos y documentación para centrarte en lo que aporta valor.' ),
			array( 'reloj', 'Atención al cliente 24/7', 'Asistentes virtuales que resuelven dudas al instante, cualquier día y a cualquier hora.' ),
			array( 'datos', 'Decisiones basadas en datos', 'Analiza y resume grandes volúmenes de información para decidir con más rapidez y criterio.' ),
			array( 'contenido', 'Contenido en minutos', 'Borradores de textos, imágenes y presentaciones que mantienen la voz de tu marca.' ),
			array( 'equipo', 'Equipos más productivos', 'Forma a tu plantilla para usar la IA como un copiloto en su trabajo diario.' ),
			array( 'idea', 'Innovación y competitividad', 'Detecta nuevas oportunidades de negocio y adelántate a tu competencia.' ),
		),

		/* ---------- Empresas de formación ---------- */
		'empresas'   => array(
			'titulo'    => 'Centros y empresas de formación con los que he trabajado',
			// Solo se muestran si la carpeta /images/empresas/ está vacía.
			'ejemplos'  => array( 'Centro de formación', 'Academia tecnológica', 'Escuela de negocios', 'Formación online', 'Instituto de empleo', 'Centro FPE' ),
		),

		/* ---------- Llamada a la acción ---------- */
		'cta'        => array(
			'titulo' => '¿Tienes un proyecto o necesitas formación para tu equipo?',
			'texto'  => 'Cuéntame tu idea y te responderé lo antes posible con una propuesta a tu medida.',
		),
	);
}

/**
 * 2b. Foto de la sección "Sobre mí".
 *     1) La imagen elegida en Apariencia › Personalizar › Portada.
 *     2) Si no hay, un archivo images/sobre-mi.(jpg|jpeg|png|webp) del tema,
 *        sin importar mayúsculas (Sobre-Mi.JPG también vale).
 *
 * @return string URL de la foto o cadena vacía.
 */
function ag_foto_sobre_mi() {
	$foto = get_theme_mod( 'ag_foto_sobre_mi', '' );
	if ( $foto ) {
		return $foto;
	}

	$archivos = glob( get_template_directory() . '/images/*' );
	foreach ( (array) $archivos as $archivo ) {
		if ( preg_match( '/^sobre-mi\.(jpe?g|png|webp)$/i', basename( $archivo ) ) ) {
			return get_template_directory_uri() . '/images/' . rawurlencode( basename( $archivo ) );
		}
	}

	return '';
}

/**
 * 2c. Sección "Portada" en el Personalizador para elegir la foto.
 *
 * @param WP_Customize_Manager $wp_customize Gestor del Personalizador.
 */
function ag_inicio_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'ag_portada',
		array(
			'title'    => esc_html__( 'Portada', 'antoniogarciaprats' ),
			'priority' => 32,
		)
	);

	$wp_customize->add_setting(
		'ag_foto_sobre_mi',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ag_foto_sobre_mi',
			array(
				'label'       => esc_html__( 'Foto de la sección "Sobre mí"', 'antoniogarciaprats' ),
				'description' => esc_html__( 'Vertical, proporción 4:5. Recomendado: 880 × 1100 px.', 'antoniogarciaprats' ),
				'section'     => 'ag_portada',
			)
		)
	);
}
add_action( 'customize_register', 'ag_inicio_customizer' );

/**
 * 3. Logos de empresas: todas las imágenes de /images/empresas/.
 *    El texto alternativo sale del nombre del archivo
 *    (centro-formacion-sur.png → "Centro formacion sur").
 *
 * @return array Lista de array( 'url' => ..., 'alt' => ... ).
 */
function ag_logos_empresas() {
	$carpeta = get_template_directory() . '/images/empresas';
	$logos   = array();

	if ( ! is_dir( $carpeta ) ) {
		return $logos;
	}

	$archivos = glob( $carpeta . '/*' );
	sort( $archivos );

	foreach ( $archivos as $archivo ) {
		$ext = strtolower( pathinfo( $archivo, PATHINFO_EXTENSION ) );
		if ( ! in_array( $ext, array( 'png', 'jpg', 'jpeg', 'svg', 'webp', 'gif' ), true ) ) {
			continue;
		}
		$nombre  = pathinfo( $archivo, PATHINFO_FILENAME );
		$logos[] = array(
			'url' => get_template_directory_uri() . '/images/empresas/' . rawurlencode( basename( $archivo ) ),
			'alt' => ucfirst( trim( str_replace( array( '-', '_' ), ' ', $nombre ) ) ),
		);
	}

	return $logos;
}

/**
 * 4. Iconos de línea de la portada (se "dibujan" al aparecer).
 *
 * @param string $nombre Nombre del icono.
 * @return string Marcado SVG.
 */
function ag_icono_inicio( $nombre ) {
	$trazos = array(
		'web'         => '<rect x="4" y="7" width="40" height="32" rx="4"/><path d="M4 15h40"/><path d="M10 11h.01M15 11h.01M20 11h.01"/><path d="M19 22l-5 5 5 5"/><path d="M29 22l5 5-5 5"/><path d="M26 20l-4 14"/>',
		'app'         => '<rect x="13" y="4" width="22" height="40" rx="4"/><path d="M21 9h6"/><path d="M22 39h4"/><path d="M20 19l-4 4 4 4"/><path d="M28 19l4 4-4 4"/>',
		'formacion'   => '<path d="M4 18L24 9l20 9-20 9z"/><path d="M12 22v8c0 3 5.4 6 12 6s12-3 12-6v-8"/><path d="M44 18v11"/>',
		'rrss'        => '<path d="M10 9h28a5 5 0 0 1 5 5v16a5 5 0 0 1-5 5H22l-9 7v-7h-3a5 5 0 0 1-5-5V14a5 5 0 0 1 5-5z"/><path d="M21 16l9 6-9 6z"/>',
		'automatizar' => '<circle cx="24" cy="24" r="6"/><path d="M24 5v6M24 37v6M5 24h6M37 24h6M10.6 10.6l4.2 4.2M33.2 33.2l4.2 4.2M10.6 37.4l4.2-4.2M33.2 14.8l4.2-4.2"/>',
		'reloj'       => '<circle cx="24" cy="24" r="18"/><path d="M24 13v11l7 5"/>',
		'datos'       => '<path d="M6 42h36"/><path d="M12 34V24M20 34V15M28 34V20M36 34V9"/>',
		'contenido'   => '<path d="M30 8l10 10-20 20H10V28z"/><path d="M26 12l10 10"/><path d="M39 32v9M34.5 36.5h9"/>',
		'equipo'      => '<circle cx="17" cy="16" r="6"/><circle cx="33" cy="18" r="5"/><path d="M5 40c0-7 5.4-12 12-12s12 5 12 12"/><path d="M29 29c1.2-.6 2.6-1 4-1 5.5 0 10 4.5 10 10"/>',
		'idea'        => '<path d="M18 36h12M20 42h8"/><path d="M24 6a12 12 0 0 0-7 21.7c1.3 1 2 2.4 2 4V36h10v-4.3c0-1.6.7-3 2-4A12 12 0 0 0 24 6z"/>',
		'carrito'     => '<circle cx="18" cy="40" r="3"/><circle cx="36" cy="40" r="3"/><path d="M4 6h6l5 24h24l4-16H13"/>',
		'escudo'      => '<path d="M24 4l16 6v12c0 10-7 18-16 22-9-4-16-12-16-22V10z"/><path d="M17 24l5 5 9-10"/>',
		'diana'       => '<circle cx="24" cy="24" r="18"/><circle cx="24" cy="24" r="10"/><circle cx="24" cy="24" r="3"/>',
		'pincel'      => '<path d="M36 6l6 6-18 18-7 1 1-7z"/><path d="M14 30c-5 0-8 4-8 8v4h4c5 0 8-3 8-8"/>',
		'cohete'      => '<path d="M24 4c7 4 11 11 11 19l-5 7H18l-5-7c0-8 4-15 11-19z"/><circle cx="24" cy="18" r="4"/><path d="M18 30l-6 4 2-9M30 30l6 4-2-9"/><path d="M21 36l3 8 3-8"/>',
		'codigo'      => '<rect x="4" y="8" width="40" height="32" rx="4"/><path d="M12 20l6 5-6 5"/><path d="M22 31h12"/>',
		'libro'       => '<path d="M6 10c6-2 12-2 18 2 6-4 12-4 18-2v28c-6-2-12-2-18 2-6-4-12-4-18-2z"/><path d="M24 12v28"/>',
		'medalla'     => '<circle cx="24" cy="18" r="11"/><path d="M18 27l-4 15 10-5 10 5-4-15"/><path d="M20 18l3 3 6-6"/>',
		'flecha'      => '<path d="M10 24h28M28 14l10 10-10 10"/>',
		'check'       => '<path d="M10 25l9 9 19-19"/>',
	);

	if ( ! isset( $trazos[ $nombre ] ) ) {
		return '';
	}

	// Cada trazo lleva pathLength="1" para animar su dibujo con CSS.
	$svg = preg_replace( '/<(path|rect|circle)\b/', '<$1 pathLength="1"', $trazos[ $nombre ] );

	return '<svg class="ag-icono-linea" viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $svg . '</svg>';
}
