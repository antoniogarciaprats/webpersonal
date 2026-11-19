<?php
/**
 * Blog: recursos, tarjetas de artículo, barra lateral y utilidades.
 *
 * Plantillas que lo usan:
 *  - home.php        → página de entradas (Ajustes › Lectura › Página de entradas)
 *  - archive.php     → categorías, etiquetas, fechas y autores
 *  - search.php      → resultados de búsqueda
 *  - single.php      → artículo individual
 *  - template-parts/blog/listado.php → listado común a las tres primeras
 *
 * Inclúyelo desde functions.php:  require get_template_directory() . '/inc/blog.php';
 *
 * @package antoniogarciaprats
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ¿Estamos en alguna vista del blog?
 *
 * @return bool
 */
function ag_es_blog() {
	return ( is_home() && ! is_front_page() ) || is_archive() || is_search() || is_singular( 'post' );
}

/**
 * Clase en <body> para dar a las vistas del blog su fondo propio.
 *
 * @param array $clases Clases del body.
 * @return array
 */
function ag_blog_body_class( $clases ) {
	if ( ag_es_blog() ) {
		$clases[] = 'ag-vista-blog';
	}
	return $clases;
}
add_filter( 'body_class', 'ag_blog_body_class' );

/**
 * 1. CSS y JS del blog (reutiliza los componentes y animaciones de la portada).
 */
function ag_blog_assets() {
	if ( ! ag_es_blog() ) {
		return;
	}

	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'ag-inicio', $uri . '/css/inicio.css', array( 'ag-cabecera' ), filemtime( $dir . '/css/inicio.css' ) );
	wp_enqueue_style( 'ag-blog', $uri . '/css/blog.css', array( 'ag-inicio' ), filemtime( $dir . '/css/blog.css' ) );

	$opciones = array(
		'in_footer' => true,
		'strategy'  => 'defer',
	);
	wp_enqueue_script( 'ag-inicio', $uri . '/js/inicio.js', array(), filemtime( $dir . '/js/inicio.js' ), $opciones );
	wp_enqueue_script( 'ag-blog', $uri . '/js/blog.js', array(), filemtime( $dir . '/js/blog.js' ), $opciones );
}
add_action( 'wp_enqueue_scripts', 'ag_blog_assets', 20 );

/**
 * 2. Utilidades
 * ------------------------------------------------------------------------
 */

/**
 * Tiempo de lectura aproximado (200 palabras por minuto).
 *
 * @param int|null $id ID de la entrada (por defecto, la actual).
 * @return string
 */
function ag_tiempo_lectura( $id = null ) {
	$texto    = wp_strip_all_tags( (string) get_post_field( 'post_content', $id ? $id : get_the_ID() ) );
	$palabras = $texto ? count( preg_split( '/\s+/u', trim( $texto ) ) ) : 0;
	$minutos  = max( 1, (int) ceil( $palabras / 200 ) );

	/* translators: %d: minutos de lectura */
	return sprintf( __( '%d min de lectura', 'antoniogarciaprats' ), $minutos );
}

/**
 * Imagen de la entrada o, si no tiene, un fondo con el logo.
 *
 * @param string $tamano Tamaño de imagen de WordPress.
 */
function ag_blog_miniatura( $tamano = 'medium_large' ) {
	if ( has_post_thumbnail() ) {
		the_post_thumbnail(
			$tamano,
			array(
				'loading' => 'lazy',
				'alt'     => '',
			)
		);
		return;
	}

	echo '<span class="ag-blog-sin-imagen">' . str_replace( 'ag-logo-hueco', 'ag-logo-hueco-' . get_the_ID() . '-' . wp_rand( 1, 99999 ), ag_icono( 'logo' ) ) . '</span>'; // phpcs:ignore
}

/**
 * Enlace a la primera categoría de la entrada.
 */
function ag_blog_categoria() {
	$categorias = get_the_category();
	if ( empty( $categorias ) ) {
		return;
	}
	printf(
		'<a class="ag-blog-categoria" href="%1$s">%2$s</a>',
		esc_url( get_category_link( $categorias[0]->term_id ) ),
		esc_html( $categorias[0]->name )
	);
}

/**
 * Formulario de búsqueda del blog.
 *
 * @param string $id Identificador único del campo.
 */
function ag_blog_buscador( $id = 'ag-buscar' ) {
	?>
	<form class="ag-buscador" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Buscar en el blog', 'antoniogarciaprats' ); ?></label>
		<input type="search" id="<?php echo esc_attr( $id ); ?>" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Buscar en el blog…', 'antoniogarciaprats' ); ?>">
		<button type="submit" aria-label="<?php esc_attr_e( 'Buscar', 'antoniogarciaprats' ); ?>">
			<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="2.2"/><path d="M20 20l-4-4" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
		</button>
	</form>
	<?php
}

/**
 * 3. Tarjeta de artículo (dentro del bucle).
 *
 * @param bool $destacada true para la tarjeta grande del último artículo.
 * @param int  $orden     Posición, para escalonar la animación.
 */
function ag_blog_tarjeta( $destacada = false, $orden = 0 ) {
	$clases = 'ag-tarjeta-blog' . ( $destacada ? ' ag-tarjeta-blog--destacada' : '' );
	?>
	<article id="post-<?php the_ID(); ?>" class="<?php echo esc_attr( $clases ); ?>" data-ag-revelar style="--d: <?php echo esc_attr( min( $orden, 5 ) * 0.08 ); ?>s;">
		<a class="ag-tarjeta-blog__imagen" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
			<?php ag_blog_miniatura( $destacada ? 'large' : 'medium_large' ); ?>
			<?php if ( $destacada ) : ?>
				<span class="ag-tarjeta-blog__insignia"><?php esc_html_e( 'Último artículo', 'antoniogarciaprats' ); ?></span>
			<?php endif; ?>
		</a>

		<div class="ag-tarjeta-blog__cuerpo">
			<div class="ag-tarjeta-blog__meta">
				<?php ag_blog_categoria(); ?>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<span><?php echo esc_html( ag_tiempo_lectura() ); ?></span>
			</div>

			<h2 class="ag-tarjeta-blog__titulo"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
			<p class="ag-tarjeta-blog__resumen"><?php echo esc_html( wp_trim_words( get_the_excerpt(), $destacada ? 38 : 22 ) ); ?></p>

			<a class="ag-tarjeta-blog__leer" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Leer artículo', 'antoniogarciaprats' ); ?>
				<?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?>
			</a>
		</div>
	</article>
	<?php
}

/**
 * Filtro de categorías (chips) sobre el listado.
 */
function ag_blog_filtro_categorias() {
	$categorias = get_categories(
		array(
			'hide_empty' => true,
			'orderby'    => 'count',
			'order'      => 'DESC',
			'number'     => 8,
		)
	);
	if ( count( $categorias ) < 2 ) {
		return; // Con una sola categoría el filtro no aporta nada.
	}

	$pagina_blog = (int) get_option( 'page_for_posts' );
	$url_todas   = $pagina_blog ? get_permalink( $pagina_blog ) : home_url( '/' );
	?>
	<nav class="ag-blog-filtro" aria-label="<?php esc_attr_e( 'Categorías del blog', 'antoniogarciaprats' ); ?>">
		<a href="<?php echo esc_url( $url_todas ); ?>"<?php echo is_home() ? ' class="is-activa" aria-current="page"' : ''; ?>><?php esc_html_e( 'Todas', 'antoniogarciaprats' ); ?></a>
		<?php foreach ( $categorias as $categoria ) : ?>
			<?php $activa = is_category( $categoria->term_id ); ?>
			<a href="<?php echo esc_url( get_category_link( $categoria->term_id ) ); ?>"<?php echo $activa ? ' class="is-activa" aria-current="page"' : ''; ?>><?php echo esc_html( $categoria->name ); ?></a>
		<?php endforeach; ?>
	</nav>
	<?php
}

/**
 * 4. BARRA LATERAL DEL BLOG
 *    Buscador · Últimos artículos · Categorías · Sobre mí
 */
function ag_blog_sidebar() {
	$actual  = is_singular( 'post' ) ? get_the_ID() : 0;
	$ultimos = new WP_Query(
		array(
			'posts_per_page'      => 5,
			'post__not_in'        => $actual ? array( $actual ) : array(),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	?>
	<aside class="ag-blog-vista__lateral" aria-label="<?php esc_attr_e( 'Barra lateral del blog', 'antoniogarciaprats' ); ?>">
		<div class="ag-blog-vista__lateral-fijo">

			<section class="ag-widget ag-widget--buscar">
				<?php ag_blog_buscador( 'ag-buscar-lateral' ); ?>
			</section>

			<?php if ( $ultimos->have_posts() ) : ?>
				<section class="ag-widget">
					<h2 class="ag-widget__titulo"><?php esc_html_e( 'Últimos artículos', 'antoniogarciaprats' ); ?></h2>
					<ol class="ag-ultimos">
						<?php
						while ( $ultimos->have_posts() ) :
							$ultimos->the_post();
							?>
							<li>
								<a class="ag-ultimos__enlace" href="<?php the_permalink(); ?>">
									<span class="ag-ultimos__imagen"><?php ag_blog_miniatura( 'thumbnail' ); ?></span>
									<span class="ag-ultimos__texto">
										<strong><?php the_title(); ?></strong>
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									</span>
								</a>
							</li>
						<?php endwhile; ?>
					</ol>
				</section>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>

			<?php $ag_categorias = get_categories( array( 'hide_empty' => true ) ); ?>
			<?php if ( $ag_categorias ) : ?>
				<section class="ag-widget">
					<h2 class="ag-widget__titulo"><?php esc_html_e( 'Categorías', 'antoniogarciaprats' ); ?></h2>
					<ul class="ag-chips">
						<?php foreach ( $ag_categorias as $categoria ) : ?>
							<li>
								<a href="<?php echo esc_url( get_category_link( $categoria->term_id ) ); ?>">
									<?php echo esc_html( $categoria->name ); ?>
									<span><?php echo (int) $categoria->count; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</section>
			<?php endif; ?>

			<section class="ag-widget ag-widget--autor">
				<?php $ag_foto = function_exists( 'ag_foto_quien_soy' ) ? ag_foto_quien_soy() : ''; ?>
				<span class="ag-widget-autor__foto">
					<?php if ( $ag_foto ) : ?>
						<img src="<?php echo esc_url( $ag_foto ); ?>" alt="" width="88" height="88" loading="lazy">
					<?php else : ?>
						<?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-lateral', ag_icono( 'logo' ) ); // phpcs:ignore ?>
					<?php endif; ?>
				</span>
				<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
				<p><?php esc_html_e( 'Formador FPE, desarrollador web y programador. Escribo sobre programación, desarrollo web e inteligencia artificial.', 'antoniogarciaprats' ); ?></p>
				<a class="ag-boton" href="<?php echo esc_url( home_url( '/sobre-mi/' ) ); ?>"><?php esc_html_e( 'Conóceme', 'antoniogarciaprats' ); ?></a>
			</section>

		</div>
	</aside>
	<?php
}

/**
 * 5. Botones para compartir (sin scripts de terceros ni rastreo).
 */
function ag_blog_compartir() {
	$url    = rawurlencode( get_permalink() );
	$titulo = rawurlencode( wp_strip_all_tags( get_the_title() ) );
	$redes  = array(
		'linkedin' => array( 'LinkedIn', 'https://www.linkedin.com/sharing/share-offsite/?url=' . $url ),
		'x'        => array( 'X', 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $titulo ),
		'facebook' => array( 'Facebook', 'https://www.facebook.com/sharer/sharer.php?u=' . $url ),
		'whatsapp' => array( 'WhatsApp', 'https://wa.me/?text=' . $titulo . '%20' . $url ),
	);
	$iconos = array(
		'whatsapp' => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M12 2.2a9.8 9.8 0 0 0-8.4 14.9L2.3 21.7l4.7-1.2A9.8 9.8 0 1 0 12 2.2z" fill="none" stroke="currentColor" stroke-width="1.9"/><path d="M8.6 7.4c.3-.6.7-.6 1-.6h.6c.2 0 .5 0 .7.5l.8 1.9c.1.2.1.4 0 .6l-.5.7c-.1.2-.2.4 0 .6.5.9 1.4 1.8 2.4 2.3.2.1.4.1.6-.1l.7-.8c.2-.2.4-.2.6-.1l1.8.9c.3.1.4.3.4.5 0 .6-.3 1.4-.9 1.7-.7.4-1.6.5-3.4-.3a10.4 10.4 0 0 1-4.6-4.6c-.8-1.6-.5-2.6-.2-3.2z"/></svg>',
		'copiar'   => '<svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M10 14a5 5 0 0 0 7.1 0l3-3a5 5 0 0 0-7.1-7.1l-1.2 1.2M14 10a5 5 0 0 0-7.1 0l-3 3a5 5 0 0 0 7.1 7.1l1.2-1.2" fill="none" stroke="currentColor" stroke-width="2.1" stroke-linecap="round"/></svg>',
	);
	?>
	<div class="ag-compartir">
		<span class="ag-compartir__texto"><?php esc_html_e( '¿Te ha gustado? Compártelo', 'antoniogarciaprats' ); ?></span>
		<div class="ag-compartir__botones">
			<?php foreach ( $redes as $red => $datos ) : ?>
				<a class="ag-compartir__boton ag-compartir__boton--<?php echo esc_attr( $red ); ?>" href="<?php echo esc_url( $datos[1] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( sprintf( __( 'Compartir en %s', 'antoniogarciaprats' ), $datos[0] ) ); ?>">
					<?php echo isset( $iconos[ $red ] ) ? $iconos[ $red ] : ag_icono_red( $red ); // phpcs:ignore ?>
				</a>
			<?php endforeach; ?>
			<button type="button" class="ag-compartir__boton ag-compartir__boton--copiar" data-ag-copiar="<?php echo esc_url( get_permalink() ); ?>" aria-label="<?php esc_attr_e( 'Copiar enlace', 'antoniogarciaprats' ); ?>">
				<?php echo $iconos['copiar']; // phpcs:ignore ?>
				<span class="ag-compartir__aviso" role="status"></span>
			</button>
		</div>
	</div>
	<?php
}
