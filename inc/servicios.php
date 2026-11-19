<?php
/**
 * Página "Servicios".
 *
 * ► Textos: ag_servicios_datos().
 * ► La plantilla (plantillas/servicios.php) se aplica sola a la página con
 *   dirección /servicios/, o eligiéndola en el editor: Plantilla → "Servicios".
 *
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/servicios.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ¿Estamos en la página de servicios?
 *
 * @return bool
 */
function ag_es_servicios() {
	return is_page_template( 'plantillas/servicios.php' ) || is_page( 'servicios' );
}

/**
 * La página /servicios/ usa este diseño automáticamente.
 *
 * @param string $plantilla Plantilla que WordPress iba a usar.
 * @return string
 */
function ag_servicios_plantilla( $plantilla ) {
	if ( is_page( 'servicios' ) && ! is_page_template() ) {
		$propia = locate_template( 'plantillas/servicios.php' );
		if ( $propia ) {
			return $propia;
		}
	}
	return $plantilla;
}
add_filter( 'template_include', 'ag_servicios_plantilla' );

/**
 * CSS y JS (reutiliza componentes y animaciones de la portada).
 */
function ag_servicios_assets() {
	if ( ! ag_es_servicios() ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'ag-inicio', $uri . '/css/inicio.css', array( 'ag-cabecera' ), filemtime( $dir . '/css/inicio.css' ) );
	wp_enqueue_style( 'ag-servicios', $uri . '/css/servicios.css', array( 'ag-inicio' ), filemtime( $dir . '/css/servicios.css' ) );
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
add_action( 'wp_enqueue_scripts', 'ag_servicios_assets', 20 );

/**
 * Botón del portfolio: enlace activo si hay dirección; si no, desactivado
 * con la etiqueta "Próximamente".
 *
 * @param string $clase Clases extra del botón.
 */
function ag_servicios_portfolio( $clase = '' ) {
	$datos = ag_servicios_datos()['portfolio'];
	$icono = '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><rect x="3" y="7" width="18" height="13" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 13h18" fill="none" stroke="currentColor" stroke-width="2"/></svg>';

	if ( ! empty( $datos['url'] ) ) {
		printf(
			'<a class="ag-portfolio %1$s" href="%2$s">%3$s<span>%4$s</span></a>',
			esc_attr( $clase ),
			esc_url( home_url( $datos['url'] ) ),
			$icono, // phpcs:ignore
			esc_html( $datos['texto'] )
		);
		return;
	}

	printf(
		'<span class="ag-portfolio ag-portfolio--inactivo %1$s" role="link" aria-disabled="true" title="%2$s">%3$s<span>%4$s</span><em>%5$s</em></span>',
		esc_attr( $clase ),
		esc_attr__( 'El portfolio estará disponible próximamente', 'antoniogarciaprats' ),
		$icono, // phpcs:ignore
		esc_html( $datos['texto'] ),
		esc_html__( 'Próximamente', 'antoniogarciaprats' )
	);
}

/**
 * CONTENIDOS DE LA PÁGINA DE SERVICIOS — edita aquí tus textos.
 *
 * @return array
 */
function ag_servicios_datos() {
	return array(

		/* ---------- Presentación ---------- */
		'intro'     => array(
			'etiqueta' => 'Servicios',
			'titulo'   => 'Todo lo que necesitas para <strong>crecer en digital</strong>',
			'texto'    => 'Webs, aplicaciones Android, software a medida con Django, Python, Java y C/C++, cursos, contenidos y formación. Un único profesional que entiende tu proyecto de principio a fin y te habla claro en cada paso.',
		),

		/* ---------- Portfolio ----------
		   Mientras 'url' esté vacía, el botón aparece desactivado con la
		   etiqueta "Próximamente". Cuando tengas tu portfolio, pon aquí su
		   dirección (por ejemplo '/portfolio/') y se activará solo. */
		'portfolio' => array(
			'texto' => 'Ver mi portfolio',
			'url'   => '',
		),

		/* ---------- Índice: id de sección, icono, color, nombre ---------- */
		'indice'    => array(
			array( 'diseno-web', 'web', '#437eb6', 'Diseño web' ),
			array( 'apps-android', 'app', '#2bb3a0', 'Apps Android' ),
			array( 'aplicaciones', 'codigo', '#0c7c59', 'Aplicaciones a medida' ),
			array( 'cursos-pdf', 'libro', '#7a5cd6', 'Cursos y material PDF' ),
			array( 'contenidos', 'rrss', '#e8566c', 'Contenidos y blog' ),
			array( 'formacion-empresas', 'formacion', '#f29b38', 'Formación' ),
		),

		/* ---------- 1. Diseño web ---------- */
		'web'       => array(
			'etiqueta' => 'Diseño y desarrollo web',
			'titulo'   => 'Una web para cada <strong>objetivo</strong>',
			'texto'    => 'Desde una página para captar clientes hasta una tienda online o una plataforma de cursos. Elige el tipo de proyecto que mejor encaja contigo.',
			'tipos'    => array(
				array( 'carrito', 'Tienda online con WooCommerce', 'Vende tus productos o servicios en internet con catálogo, carrito, pasarelas de pago y gestión de pedidos.', 'Comercios y marcas' ),
				array( 'formacion', 'Plataforma de cursos con Moodle', 'Tu propia aula virtual con cursos, alumnos, evaluaciones y certificados.', 'Academias y formadores' ),
				array( 'diana', 'Landing pages', 'Páginas de una sola sección pensadas para un objetivo concreto: captar contactos, vender un producto o lanzar una campaña.', 'Campañas y lanzamientos' ),
				array( 'equipo', 'Web corporativa', 'La imagen de tu empresa en internet: quiénes sois, qué ofrecéis y cómo contactaros.', 'Empresas y profesionales' ),
				array( 'codigo', 'Web a medida', 'Funcionalidades específicas que no resuelve una plantilla: áreas privadas, reservas, integraciones…', 'Proyectos especiales' ),
			),
			'incluye'  => array(
				'Diseño adaptado a móvil, tablet y ordenador',
				'Optimización de velocidad y SEO básico',
				'Certificado SSL y buenas prácticas de seguridad',
				'Preparada para tus textos legales y aviso de cookies',
				'Formación para que la gestiones con autonomía',
				'Accesibilidad y diseño acorde a tu marca',
			),
		),

		/* ---------- Guía rápida: ¿qué web necesitas? ---------- */
		'guia'      => array(
			array( 'Quiero vender por internet', 'Tienda online con WooCommerce' ),
			array( 'Quiero impartir cursos online', 'Plataforma con Moodle' ),
			array( 'Quiero promocionar un producto o un evento', 'Landing page' ),
			array( 'Quiero dar a conocer mi empresa', 'Web corporativa' ),
			array( 'Necesito algo que no veo en ninguna plantilla', 'Web a medida' ),
		),

		/* ---------- 2–5. Resto de servicios (bloques en zigzag) ---------- */
		'servicios' => array(
			array(
				'id'      => 'apps-android',
				'icono'   => 'app',
				'color'   => '#2bb3a0',
				'nombre'  => 'Apps Android a medida',
				'titulo'  => 'Tu idea, en el <strong>bolsillo de tus clientes</strong>',
				'texto'   => 'Desarrollo aplicaciones nativas para Android en Java, diseñadas para tu negocio: desde herramientas internas para tu equipo hasta apps para tus clientes.',
				'puntos'  => array( 'Análisis de la idea y prototipo', 'Interfaz clara y fácil de usar', 'Conexión con tu web, base de datos o APIs', 'Publicación en Google Play y mantenimiento' ),
				'chips'   => array( 'Java', 'Android', 'APIs REST' ),
				'enlace'  => array(),
			),
			array(
				'id'      => 'aplicaciones',
				'icono'   => 'codigo',
				'color'   => '#0c7c59',
				'nombre'  => 'Aplicaciones a medida',
				'titulo'  => 'Software que <strong>trabaja para ti</strong>',
				'texto'   => 'Desarrollo aplicaciones web con Django y programas a medida en Python, Java y C/C++: herramientas que automatizan tareas, gestionan tu información y se adaptan exactamente a cómo trabajas.',
				'puntos'  => array( 'Aplicaciones web con Django: paneles de gestión, áreas privadas y APIs', 'Herramientas y aplicaciones de escritorio en Java y Python', 'Programas eficientes y de alto rendimiento en C/C++', 'Automatización de tareas y procesamiento de datos con Python' ),
				'chips'   => array( 'Django', 'Python', 'Java · C/C++' ),
				'enlace'  => array( 'portfolio' ),
			),
			array(
				'id'      => 'cursos-pdf',
				'icono'   => 'libro',
				'color'   => '#7a5cd6',
				'nombre'  => 'Cursos y material en PDF',
				'titulo'  => 'Material didáctico <strong>listo para enseñar</strong>',
				'texto'   => 'Creo cursos completos y su material en formato PDF: manuales maquetados, ejercicios, evaluaciones y presentaciones, con contenido actualizado y adaptado a tu público.',
				'puntos'  => array( 'Manuales PDF con diseño profesional', 'Prácticas y casos reales', 'Evaluaciones y solucionarios', 'Adaptado a certificados de profesionalidad o a tu empresa' ),
				'chips'   => array( 'PDF', 'Manuales', 'Evaluación' ),
				'enlace'  => array( 'Ver cómo creo el material', '/formacion/#material' ),
			),
			array(
				'id'      => 'contenidos',
				'icono'   => 'rrss',
				'color'   => '#e8566c',
				'nombre'  => 'Contenidos para redes y blog',
				'titulo'  => 'Contenido que <strong>conecta y posiciona</strong>',
				'texto'   => 'Creo publicaciones para redes sociales y artículos de blog personalizados con la voz de tu marca, pensados para aportar valor a tu audiencia y mejorar tu presencia en buscadores.',
				'puntos'  => array( 'Publicaciones y vídeos para redes sociales', 'Artículos de blog optimizados para SEO', 'Calendario editorial adaptado a tu negocio', 'Especialidad en tecnología, programación e IA' ),
				'chips'   => array( 'Redes sociales', 'Blog', 'SEO' ),
				'enlace'  => array( 'Ver mi blog', '/blog/' ),
			),
		),

		/* ---------- 6. Formación ---------- */
		'formacion' => array(
			'etiqueta' => 'Formación',
			'titulo'   => 'Formación para empresas, <strong>como mejor te encaje</strong>',
			'texto'    => 'Puedo formar a tu equipo directamente como profesional autónomo o a través de tu centro o empresa de formación.',
			'opciones' => array(
				array( 'cohete', 'Como autónomo', 'Contratas directamente conmigo', 'Diseño un curso a medida para tu empresa, con su material incluido, y lo imparto presencial u online en las fechas que te vengan bien.', array( 'Programa y material a medida', 'Calendario flexible', 'Trato directo, sin intermediarios' ) ),
				array( 'equipo', 'Por cuenta ajena', 'A través de centros y empresas de formación', 'Me incorporo como formador a vuestros cursos y certificados de profesionalidad, con experiencia como formador FPE a tiempo completo.', array( 'Certificados de profesionalidad', 'Cursos para ocupados y desempleados', 'Material didáctico propio' ) ),
			),
			'enlace'   => array( 'Ver toda la información sobre formación', '/formacion/' ),
		),

		/* ---------- 7. Información de valor ---------- */
		'porque'    => array(
			array( 'equipo', 'Un solo interlocutor', 'Hablas siempre conmigo, de principio a fin del proyecto.' ),
			array( 'idea', 'Lenguaje claro', 'Te explico cada decisión sin tecnicismos innecesarios.' ),
			array( 'formacion', 'Te enseño a usarlo', 'Como formador, me aseguro de que puedas gestionar lo que te entrego.' ),
			array( 'escudo', 'Calidad y seguridad', 'Código limpio, buenas prácticas y atención a los detalles.' ),
		),
		'preparar'  => array(
			array( 'Tu objetivo', '¿Qué quieres conseguir? Vender, captar clientes, formar a tu equipo…' ),
			array( 'Tu público', '¿A quién te diriges y qué necesita de ti?' ),
			array( 'Contenidos', 'Textos, fotos, logotipo y colores de marca, si ya los tienes.' ),
			array( 'Referencias', 'Webs, apps o cursos que te gusten y por qué.' ),
			array( 'Plazo y presupuesto', 'Una idea aproximada nos ayuda a proponer la mejor solución.' ),
		),
		'despues'   => array(
			array( 'automatizar', 'Mantenimiento', 'Actualizaciones de WordPress, plugins y apps para que todo siga funcionando.' ),
			array( 'escudo', 'Copias de seguridad', 'Tu información protegida y recuperable ante cualquier imprevisto.' ),
			array( 'datos', 'Mejora continua', 'Nuevas secciones, funciones o contenidos a medida que tu negocio crece.' ),
			array( 'reloj', 'Soporte', 'Resuelvo tus dudas cuando las necesites, con trato cercano.' ),
		),

		/* ---------- Llamada a la acción ---------- */
		'cta'       => array(
			'titulo' => '¿Tienes un proyecto en mente?',
			'texto'  => 'Cuéntamelo sin compromiso y te propondré la solución que mejor encaje con tus objetivos y tu presupuesto.',
		),
	);
}
