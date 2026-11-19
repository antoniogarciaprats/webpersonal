<?php
/**
 * Página "Formación".
 *
 * ► Textos: ag_formacion_datos().
 * ► Logos de empresas: los mismos de la portada (carpeta /images/empresas/).
 * ► La plantilla (plantillas/formacion.php) se aplica sola a la página con
 *   dirección /formacion/, o eligiéndola en el editor: Plantilla → "Formación".
 *
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/formacion.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ¿Estamos en la página de formación?
 *
 * @return bool
 */
function ag_es_formacion() {
	return is_page_template( 'plantillas/formacion.php' ) || is_page( 'formacion' );
}

/**
 * La página /formacion/ usa este diseño automáticamente.
 *
 * @param string $plantilla Plantilla que WordPress iba a usar.
 * @return string
 */
function ag_formacion_plantilla( $plantilla ) {
	if ( is_page( 'formacion' ) && ! is_page_template() ) {
		$propia = locate_template( 'plantillas/formacion.php' );
		if ( $propia ) {
			return $propia;
		}
	}
	return $plantilla;
}
add_filter( 'template_include', 'ag_formacion_plantilla' );

/**
 * CSS y JS (reutiliza componentes, animaciones y la cinta de logos de la portada).
 */
function ag_formacion_assets() {
	if ( ! ag_es_formacion() ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'ag-inicio', $uri . '/css/inicio.css', array( 'ag-cabecera' ), filemtime( $dir . '/css/inicio.css' ) );
	wp_enqueue_style( 'ag-formacion', $uri . '/css/formacion.css', array( 'ag-inicio' ), filemtime( $dir . '/css/formacion.css' ) );
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
add_action( 'wp_enqueue_scripts', 'ag_formacion_assets', 20 );

/**
 * CONTENIDOS DE LA PÁGINA DE FORMACIÓN — edita aquí tus textos.
 *
 * @return array
 */
function ag_formacion_datos() {
	return array(

		/* ---------- 1. Presentación ---------- */
		'intro'      => array(
			'etiqueta' => 'Formación',
			'titulo'   => 'Formación tecnológica <strong>práctica, actual y a tu medida</strong>',
			'texto'    => 'Soy formador de Formación Profesional para el Empleo a tiempo completo. Imparto cursos para centros y empresas de formación y diseño programas a medida para empresas que quieren que su equipo domine la tecnología que usa cada día.',
			'destacados' => array(
				array( 'formacion', 'Formador FPE', 'a tiempo completo' ),
				array( 'libro', 'Material propio', 'creado y actualizado por mí' ),
				array( 'equipo', 'Presencial y online', 'adaptado a tu equipo' ),
			),
		),

		/* ---------- 2. Formación por cuenta ajena ---------- */
		'cuenta_ajena' => array(
			'etiqueta' => 'Para centros y empresas de formación',
			'titulo'   => 'Imparto formación <strong>donde se necesita</strong>',
			'texto'    => 'Colaboro con centros y empresas de formación impartiendo certificados de profesionalidad y cursos para personas en búsqueda de empleo y trabajadores en activo. Mi objetivo en cada aula es el mismo: que el alumnado salga con competencias reales y aplicables desde el primer día.',
		),
		'areas'      => array(
			array( 'codigo', '#2bb3a0', 'Programación', 'Fundamentos y programación orientada a objetos con Java, Python, C y C++.', array( 'Java', 'Python', 'C / C++', 'POO' ) ),
			array( 'web', '#437eb6', 'Desarrollo web', 'Maquetación, programación web y gestores de contenido para crear sitios profesionales.', array( 'HTML · CSS', 'JavaScript', 'PHP', 'WordPress' ) ),
			array( 'automatizar', '#7a5cd6', 'Sistemas informáticos', 'Certificados de profesionalidad de la familia de Informática y Comunicaciones, como IFCT0510 · Gestión de Sistemas Informáticos.', array( 'Certificados', 'Software', 'Copias y auditoría' ) ),
			array( 'idea', '#f29b38', 'IA generativa', 'Uso práctico y responsable de la inteligencia artificial generativa en el trabajo diario de la empresa.', array( 'Prompts', 'Productividad', 'Automatización' ) ),
		),

		/* ---------- 3. Material didáctico a medida ---------- */
		'material'   => array(
			'etiqueta' => 'Mi sello diferencial',
			'titulo'   => 'Creo el material de <strong>cada curso</strong>',
			'texto'    => 'No me limito a impartir: diseño y escribo el material didáctico completo de mis cursos. Para tu empresa preparo un programa a medida, con contenidos modernos, actualizados y adaptados a vuestras herramientas, vuestro sector y vuestro nivel de partida.',
			'portada'  => array( 'Curso a medida', 'IA generativa aplicada a tu empresa', array( 'Introducción y conceptos clave', 'Herramientas y casos de uso', 'Prácticas con tus propios datos', 'Buenas prácticas y seguridad' ) ),
		),
		'entregables' => array(
			array( 'libro', 'Manuales maquetados', 'Documentación completa en PDF, clara, visual y lista para imprimir o consultar en pantalla.' ),
			array( 'contenido', 'Presentaciones', 'Diapositivas modernas para guiar cada sesión y reforzar las ideas clave.' ),
			array( 'codigo', 'Prácticas y casos reales', 'Ejercicios basados en situaciones de vuestro día a día, no en ejemplos genéricos.' ),
			array( 'medalla', 'Evaluación', 'Cuestionarios y pruebas prácticas para medir el aprendizaje de forma objetiva.' ),
			array( 'datos', 'Programación didáctica', 'Objetivos, contenidos, temporización y criterios de evaluación bien definidos.' ),
			array( 'reloj', 'Siempre actualizado', 'Reviso y actualizo los contenidos para que reflejen la tecnología de hoy.' ),
		),
		'proceso'    => array(
			array( 'Análisis', 'Detectamos las necesidades y el nivel de partida de tu equipo.' ),
			array( 'Diseño', 'Defino objetivos, contenidos y calendario del curso a medida.' ),
			array( 'Creación', 'Elaboro manuales, presentaciones, prácticas y evaluaciones.' ),
			array( 'Impartición', 'Presencial u online, con un enfoque práctico y cercano.' ),
			array( 'Seguimiento', 'Evaluación, resultados y material disponible para consultar después.' ),
		),

		/* ---------- 4. Modalidades ---------- */
		'modalidades' => array(
			array( 'equipo', 'Presencial', 'En tus instalaciones o en el centro de formación, con trato directo y práctica guiada.' ),
			array( 'web', 'Online en directo', 'Clases por videoconferencia con la misma interacción que en el aula.' ),
			array( 'idea', 'Mixta', 'Combinamos sesiones presenciales y online según la disponibilidad de tu equipo.' ),
		),

		/* ---------- 5. Empresas ---------- */
		'empresas'   => array(
			'etiqueta' => 'Confianza',
			'titulo'   => 'Centros y empresas de formación con los que he trabajado',
		),

		/* ---------- 6. Llamada a la acción ---------- */
		'cta'        => array(
			'titulo' => '¿Diseñamos un curso a medida para tu empresa?',
			'texto'  => 'Cuéntame qué necesita tu equipo y te propondré un programa con su material didáctico incluido.',
		),
	);
}
