<?php
/**
 * Página "Quién soy": contenidos, recursos y maquetas visuales.
 *
 * ► Los textos se editan en ag_quien_soy_datos().
 * ► La plantilla está en plantillas/quien-soy.php. Se aplica sola a las páginas
 *   con dirección /sobre-mi/ o /quien-soy/, o eligiéndola en el editor:
 *   Plantilla → "Quién soy".
 *
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/quien-soy.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 0. ¿Estamos en la página "Quién soy"?
 *    Sí si la página tiene elegida la plantilla "Quién soy" o si su
 *    dirección (slug) es "sobre-mi" o "quien-soy".
 *
 * @return bool
 */
function ag_es_quien_soy() {
	return is_page_template( 'plantillas/quien-soy.php' ) || is_page( array( 'sobre-mi', 'quien-soy' ) );
}

/**
 * Las páginas /sobre-mi/ y /quien-soy/ usan este diseño automáticamente,
 * aunque no se haya elegido la plantilla en el editor (salvo que se elija otra).
 *
 * @param string $plantilla Ruta de la plantilla que WordPress iba a usar.
 * @return string
 */
function ag_quien_soy_plantilla( $plantilla ) {
	if ( is_page( array( 'sobre-mi', 'quien-soy' ) ) && ! is_page_template() ) {
		$propia = locate_template( 'plantillas/quien-soy.php' );
		if ( $propia ) {
			return $propia;
		}
	}
	return $plantilla;
}
add_filter( 'template_include', 'ag_quien_soy_plantilla' );

/**
 * 1. CSS y JS solo en la página "Quién soy".
 *    Reutiliza los estilos y animaciones de la portada.
 */
function ag_quien_soy_assets() {
	if ( ! ag_es_quien_soy() ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'ag-inicio', $uri . '/css/inicio.css', array( 'ag-cabecera' ), filemtime( $dir . '/css/inicio.css' ) );
	wp_enqueue_style( 'ag-quien-soy', $uri . '/css/quien-soy.css', array( 'ag-inicio' ), filemtime( $dir . '/css/quien-soy.css' ) );
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
add_action( 'wp_enqueue_scripts', 'ag_quien_soy_assets', 20 );

/**
 * 2. CONTENIDOS DE "QUIÉN SOY" — edita aquí tus textos.
 *
 * @return array
 */
function ag_quien_soy_datos() {
	return array(

		/* ---------- Presentación ---------- */
		'intro'      => array(
			'etiqueta' => 'Quién soy',
			'titulo'   => 'Emprendedor, desarrollador, formador y programador. <strong>Una misma pasión: la tecnología.</strong>',
			'lead'     => 'Soy Antonio García Prats y mi trabajo gira en torno a una idea sencilla: la tecnología es más útil cuando se entiende y se comparte.',
			'parrafos' => array(
				'Combino cuatro facetas que se alimentan entre sí: emprendo con mi propia marca, desarrollo webs y aplicaciones, formo a futuros profesionales como <strong>formador FPE</strong> y programo cada día en Java, Python y tecnologías web.',
				'Esa mezcla me permite ver cada proyecto desde todos los ángulos: el del negocio, el del usuario, el del alumno y el del código.',
			),
			'firma'    => 'Formador FPE · Desarrollador · Emprendedor',
		),

		/* ---------- Las cuatro facetas ---------- */
		'facetas'    => array(
			array(
				'id'      => 'emprendedor',
				'icono'   => 'cohete',
				'color'   => '#f29b38',
				'nombre'  => 'Emprendedor',
				'titulo'  => 'Construyo mi <strong>propio camino</strong>',
				'texto'   => 'Decidí convertir mi pasión por la tecnología en un proyecto propio. Bajo la marca AG ofrezco desarrollo, formación y divulgación con un objetivo claro: transformar tu visión en innovación digital.',
				'puntos'  => array(
					'Marca personal propia y en crecimiento',
					'Visión de negocio orientada a resultados',
					'Trato directo y cercano con cada cliente',
				),
				'tags'    => array( 'Marca personal', 'Estrategia digital', 'Redes sociales' ),
				'visual'  => 'emprendedor',
			),
			array(
				'id'      => 'desarrollador-web',
				'icono'   => 'web',
				'color'   => '#437eb6',
				'nombre'  => 'Desarrollador web',
				'titulo'  => 'Webs que <strong>trabajan por ti</strong>',
				'texto'   => 'Diseño y desarrollo sitios web a medida con WordPress y tecnologías web estándar, pensados para cargar rápido, verse bien en cualquier dispositivo y posicionar en buscadores.',
				'puntos'  => array(
					'Temas de WordPress a medida',
					'Diseño responsive y accesible',
					'Optimización de velocidad y SEO',
				),
				'tags'    => array( 'WordPress', 'HTML5', 'CSS3', 'JavaScript', 'PHP' ),
				'visual'  => 'web',
			),
			array(
				'id'      => 'formador',
				'icono'   => 'formacion',
				'color'   => '#7a5cd6',
				'nombre'  => 'Formador',
				'titulo'  => 'Enseñar es <strong>aprender dos veces</strong>',
				'texto'   => 'Soy formador de Formación Profesional para el Empleo a tiempo completo. Preparo mis propios materiales didácticos y acompaño a cada alumno para que adquiera competencias reales y aplicables en el mercado laboral.',
				'puntos'  => array(
					'Formador FPE a tiempo completo',
					'Certificados de profesionalidad, como IFCT0510 · Gestión de Sistemas Informáticos',
					'Formación en IA generativa para empresas',
				),
				'tags'    => array( 'FPE', 'Certificados de profesionalidad', 'IA generativa' ),
				'visual'  => 'formador',
			),
			array(
				'id'      => 'programador',
				'icono'   => 'codigo',
				'color'   => '#2bb3a0',
				'nombre'  => 'Programador',
				'titulo'  => 'El código es <strong>mi lenguaje</strong>',
				'texto'   => 'Programo en Java, Python, C, C++ y JavaScript, y desarrollo aplicaciones para Android. Me gusta resolver problemas con código limpio, bien estructurado y fácil de mantener.',
				'puntos'  => array(
					'Aplicaciones en Java y Python',
					'Apps nativas para Android',
					'Automatización e integración de IA',
				),
				'tags'    => array( 'Java', 'Python', 'C / C++', 'JavaScript', 'Android' ),
				'visual'  => 'programador',
			),
		),

		/* ---------- Trayectoria ---------- */
		'trayectoria' => array(
			array(
				'El descubrimiento',
				'Mi primer ordenador: un Amstrad PC1640',
				'Siendo adolescente, mi padre me regaló un Amstrad PC1640. Con él di mis primeros pasos en la informática y nació una curiosidad que todavía hoy me acompaña.',
			),
			array(
				'La universidad',
				'Estudios en la Universidad de Jaén',
				'Aunque no llegué a terminarlos, mis estudios en la Universidad de Jaén me abrieron las puertas al mundo de la tecnología y me dieron una base para seguir aprendiendo por mi cuenta.',
			),
			array(
				'La vida profesional',
				'Autónomo, proyectos y blogs',
				'Empecé a trabajar como autónomo y descubrí la vida profesional. Más adelante mi carrera tomó otro camino, pero nunca abandoné la informática: seguí con proyectos puntuales y creando y desarrollando mis propios blogs.',
			),
			array(
				'La IA generativa',
				'Especialización en inteligencia artificial',
				'Me especialicé en IA generativa y en cómo aplicarla en la empresa para ganar productividad.',
			),
			array(
				'La docencia',
				'Formador para el empleo',
				'Encontré en las aulas mi verdadera vocación. Como formador de Formación Profesional para el Empleo acompaño a personas que quieren crecer profesionalmente, con materiales propios y clases prácticas que conectan la tecnología con el mercado laboral.',
			),
			array(
				'Hoy',
				'Mi propia marca: AG',
				'Uno desarrollo, formación y divulgación tecnológica en redes sociales bajo una misma marca.',
			),
		),

		/* ---------- Proyecto destacado ---------- */
		'proyecto'     => array(
			'nombre'      => 'Explora Andalucía',
			'url'         => 'https://exploraandalucia.es',
			'dominio'     => 'exploraandalucia.es',
			'lema'        => 'Tu ventana al alma del sur',
			'texto'       => 'Es el proyecto del que más orgulloso me siento: una web de viajes y patrimonio que reúne a una comunidad de fotógrafos y embajadores para dar a conocer rincones, paisajes y lugares menos conocidos de Andalucía. La he diseñado y desarrollado con WordPress, y la hago crecer imagen a imagen junto a sus colaboradores.',
			'claves'      => array( '8 provincias', 'Rutas temáticas', 'Rincones y paisajes', 'Exploraciones urbex', 'Patrimonio ferroviario', 'Comunidad de embajadores' ),
			'tecnologia'  => 'Diseñada y desarrollada con WordPress',
			'provincias'  => array( 'Almería', 'Cádiz', 'Córdoba', 'Granada', 'Huelva', 'Jaén', 'Málaga', 'Sevilla' ),
		),

		/* ---------- Titulaciones (EJEMPLO: pon las tuyas) ----------
		   Cada una: tipo, nombre, entidad · año y una línea explicativa.
		   Puedes añadir o quitar las que quieras. */
		'titulaciones' => array(
			array( 'Docencia', 'Nombre de tu titulación', 'Entidad que la expide · Año', 'Una línea que explique qué te acredita o en qué te especializa.' ),
			array( 'Informática', 'Nombre de tu titulación', 'Entidad que la expide · Año', 'Una línea que explique qué te acredita o en qué te especializa.' ),
			array( 'Inteligencia artificial', 'Nombre de tu titulación', 'Entidad que la expide · Año', 'Una línea que explique qué te acredita o en qué te especializa.' ),
		),

		/* ---------- Valores ---------- */
		'valores'    => array(
			array( 'equipo', 'Cercanía', 'Hablo claro, sin tecnicismos innecesarios, y estoy disponible cuando me necesitas.' ),
			array( 'libro', 'Aprendizaje continuo', 'La tecnología cambia cada día y yo con ella: me formo de manera constante.' ),
			array( 'medalla', 'Calidad', 'Cuido cada detalle: código limpio, diseño cuidado y materiales rigurosos.' ),
			array( 'idea', 'Innovación', 'Aplico nuevas tecnologías, como la IA, solo cuando aportan valor real.' ),
		),

		/* ---------- Llamada a la acción ---------- */
		'cta'        => array(
			'titulo' => '¿Trabajamos juntos?',
			'texto'  => 'Tanto si necesitas una web, una aplicación o formación para tu equipo, estaré encantado de escucharte.',
		),
	);
}

/**
 * 1b. Foto de la presentación de "Quién soy" (distinta de la de la portada):
 *     1) La elegida en Personalizar › Página "Quién soy".
 *     2) Un archivo images/quien-soy.(jpg|jpeg|png|webp) del tema.
 *     3) Si no hay ninguna, la foto de la portada.
 *
 * @return string URL de la foto o cadena vacía.
 */
function ag_foto_quien_soy() {
	$foto = get_theme_mod( 'ag_foto_quien_soy', '' );
	if ( $foto ) {
		return $foto;
	}

	foreach ( (array) glob( get_template_directory() . '/images/*' ) as $archivo ) {
		if ( preg_match( '/^quien-soy\.(jpe?g|png|webp)$/i', basename( $archivo ) ) ) {
			return get_template_directory_uri() . '/images/' . rawurlencode( basename( $archivo ) );
		}
	}

	return ag_foto_sobre_mi();
}

/**
 * 1c. Sección "Página Quién soy" en el Personalizador para elegir esa foto.
 *
 * @param WP_Customize_Manager $wp_customize Gestor del Personalizador.
 */
function ag_quien_soy_customizer( $wp_customize ) {
	$wp_customize->add_section(
		'ag_quien_soy',
		array(
			'title'    => esc_html__( 'Página "Quién soy"', 'antoniogarciaprats' ),
			'priority' => 33,
		)
	);

	$wp_customize->add_setting(
		'ag_foto_quien_soy',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'ag_foto_quien_soy',
			array(
				'label'       => esc_html__( 'Foto de la presentación', 'antoniogarciaprats' ),
				'description' => esc_html__( 'Vertical, proporción 4:5. Recomendado: 880 × 1100 px. Si no eliges ninguna, se usa la foto de la portada.', 'antoniogarciaprats' ),
				'section'     => 'ag_quien_soy',
			)
		)
	);
}
add_action( 'customize_register', 'ag_quien_soy_customizer' );

/**
 * 2a. Captura opcional del proyecto destacado:
 *     images/proyecto-destacado.(jpg|jpeg|png|webp). Si no existe, se dibuja
 *     una maqueta con HTML y CSS.
 *
 * @return string URL de la captura o cadena vacía.
 */
function ag_captura_proyecto() {
	foreach ( (array) glob( get_template_directory() . '/images/*' ) as $archivo ) {
		if ( preg_match( '/^proyecto-destacado\.(jpe?g|png|webp)$/i', basename( $archivo ) ) ) {
			return get_template_directory_uri() . '/images/' . rawurlencode( basename( $archivo ) );
		}
	}
	return '';
}

/**
 * 2b. Trazado SVG de un tramo de la carretera de la trayectoria.
 *     Cada tramo pasa por tres hitos (x = 200, 600, 1000 de un ancho de 1200)
 *     y ondula entre ellos. Los tramos de vuelta van de derecha a izquierda.
 *
 * @param bool $vuelta  true si el tramo va de derecha a izquierda.
 * @param bool $primero true si es el primer tramo (empieza con un remate).
 * @param bool $ultimo  true si es el último tramo (termina con un remate).
 * @return string Atributo "d" del path.
 */
function ag_carretera_trazado( $vuelta, $primero, $ultimo ) {
	$xs = array( $primero ? 40 : 0, 200, 600, 1000, $ultimo ? 1160 : 1200 );
	if ( $vuelta ) {
		$xs = array_map(
			function ( $x ) {
				return 1200 - $x;
			},
			$xs
		);
		if ( $primero ) {
			$xs[0] = 1160;
		}
	}

	$d = 'M' . $xs[0] . ' 40';
	for ( $i = 1; $i < count( $xs ); $i++ ) {
		$a  = $xs[ $i - 1 ];
		$b  = $xs[ $i ];
		$t  = ( $b - $a ) / 3;
		$dy = ( $i % 2 ? -18 : 18 );
		$d .= sprintf( ' C%s %s %s %s %s 40', round( $a + $t, 1 ), 40 + $dy, round( $b - $t, 1 ), 40 + $dy, $b );
	}

	return $d;
}

/**
 * 3. Maquetas visuales de cada faceta (hechas con HTML y CSS, sin imágenes).
 *
 * @param string $tipo emprendedor | web | formador | programador.
 */
function ag_quien_visual( $tipo ) {
	$logo = str_replace( 'ag-logo-hueco', 'ag-logo-hueco-' . $tipo, ag_icono( 'logo' ) );

	switch ( $tipo ) {

		case 'emprendedor':
			?>
			<div class="ag-mock">
				<div class="ag-mock__barra"><span></span><span></span><span></span><em>Mi proyecto</em></div>
				<div class="ag-mock__cuerpo ag-mock-panel">
					<div class="ag-mock-panel__marca">
						<span class="ag-mock-panel__logo"><?php echo $logo; // phpcs:ignore ?></span>
						<span><strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong><small>Transformamos tu visión en innovación digital</small></span>
					</div>
					<div class="ag-mock-panel__grafico" aria-hidden="true">
						<?php foreach ( array( 30, 42, 38, 55, 62, 74, 90 ) as $ag_i => $ag_h ) : ?>
							<span style="--h: <?php echo (int) $ag_h; ?>%; --i: <?php echo (int) $ag_i; ?>;"></span>
						<?php endforeach; ?>
					</div>
					<div class="ag-mock-panel__areas">
						<span>Desarrollo</span><span>Formación</span><span>Contenidos</span>
					</div>
				</div>
			</div>
			<?php
			break;

		case 'web':
			?>
			<div class="ag-mock">
				<div class="ag-mock__barra"><span></span><span></span><span></span><em>antoniogarciaprats.es</em></div>
				<div class="ag-mock__cuerpo ag-mock-web">
					<div class="ag-mock-web__nav"><i></i><i></i><b></b><i></i><i></i></div>
					<div class="ag-mock-web__hero"><i></i><i></i><b></b></div>
					<div class="ag-mock-web__tarjetas"><span></span><span></span><span></span></div>
				</div>
				<div class="ag-mock-web__movil" aria-hidden="true"><i></i><b></b><span></span><span></span></div>
			</div>
			<?php
			break;

		case 'formador':
			?>
			<div class="ag-mock">
				<div class="ag-mock__barra"><span></span><span></span><span></span><em>Aula virtual</em></div>
				<div class="ag-mock__cuerpo ag-mock-aula">
					<div class="ag-mock-aula__diapositiva">
						<small>Módulo 3</small>
						<strong>IA generativa en la empresa</strong>
						<ul><li></li><li></li><li></li></ul>
					</div>
					<div class="ag-mock-aula__progreso"><span></span></div>
					<div class="ag-mock-aula__alumnos">
						<i></i><i></i><i></i><i></i><i></i><em>Alumnos conectados</em>
					</div>
				</div>
			</div>
			<?php
			break;

		case 'programador':
			?>
			<div class="ag-mock ag-mock--oscuro">
				<div class="ag-mock__barra"><span></span><span></span><span></span><em>Antonio.java</em></div>
				<pre class="ag-mock__cuerpo ag-mock-codigo"><code><span class="c-k">public class</span> <span class="c-t">Antonio</span> {

  <span class="c-t">String</span>[] lenguajes = {
    <span class="c-s">"Java"</span>, <span class="c-s">"Python"</span>, <span class="c-s">"C++"</span>, <span class="c-s">"JavaScript"</span>
  };

  <span class="c-k">void</span> <span class="c-f">programar</span>() {
    <span class="c-k">while</span> (aprendiendo) {
      <span class="c-f">crear</span>();
      <span class="c-f">compartir</span>();
    }
  }
}<span class="ag-mock-codigo__cursor"></span></code></pre>
			</div>
			<?php
			break;
	}
}
