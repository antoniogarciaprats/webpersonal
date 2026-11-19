<?php
/**
 * Plantilla de la página de inicio.
 *
 * WordPress la usa automáticamente para la portada.
 * Secciones:
 *  1. Sobre mí + cifras
 *  2. Servicios (tarjetas animadas)
 *  3. Tecnologías
 *  4. IA en la empresa (parallax) + logos de empresas en bucle infinito
 *  5. Últimas publicaciones del blog
 *  6. Contacto
 *
 * Los textos se editan en inc/inicio.php → ag_inicio_datos().
 *
 * @package antoniogarciaprats
 */

get_header();

$ag      = ag_inicio_datos();
$ag_tags = array(
	'strong' => array(),
	'em'     => array(),
	'br'     => array(),
);
?>

<main id="primary" class="site-main ag-inicio">

	<!-- =====================================================================
	     1. SOBRE MÍ
	     ===================================================================== -->
	<section id="sobre-mi" class="ag-seccion ag-sobre">
		<div class="ag-container ag-sobre__rejilla">

			<div class="ag-sobre__media" data-ag-revelar="izquierda">
				<div class="ag-sobre__decoracion" aria-hidden="true"></div>
				<?php
				$ag_foto = ag_foto_sobre_mi();
				if ( $ag_foto ) :
					?>
					<div class="ag-sobre__marco">
						<img src="<?php echo esc_url( $ag_foto ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="880" height="1100" loading="lazy">
					</div>
				<?php else : ?>
					<div class="ag-sobre__marco ag-sobre__marco--vacio">
						<?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-sobre', ag_icono( 'logo' ) ); // phpcs:ignore ?>
						<span>Añade tu foto en Personalizar › Portada</span>
					</div>
				<?php endif; ?>

				<?php foreach ( $ag['sobre_mi']['chips'] as $ag_i => $ag_chip ) : ?>
					<span class="ag-chip-flotante ag-chip-flotante--<?php echo (int) $ag_i + 1; ?>"><?php echo esc_html( $ag_chip ); ?></span>
				<?php endforeach; ?>
			</div>

			<div class="ag-sobre__texto" data-ag-revelar="derecha">
				<span class="ag-etiqueta"><?php echo esc_html( $ag['sobre_mi']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['sobre_mi']['titulo'], $ag_tags ); ?></h2>

				<?php foreach ( $ag['sobre_mi']['parrafos'] as $ag_parrafo ) : ?>
					<p><?php echo wp_kses( $ag_parrafo, $ag_tags ); ?></p>
				<?php endforeach; ?>

				<ul class="ag-lista-check">
					<?php foreach ( $ag['sobre_mi']['destacados'] as $ag_destacado ) : ?>
						<li><?php echo ag_icono_inicio( 'check' ); // phpcs:ignore ?><?php echo esc_html( $ag_destacado ); ?></li>
					<?php endforeach; ?>
				</ul>

				<a class="ag-boton" href="<?php echo esc_url( $ag['sobre_mi']['boton'][1] ); ?>">
					<?php echo esc_html( $ag['sobre_mi']['boton'][0] ); ?>
					<?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?>
				</a>
			</div>
		</div>

		<div class="ag-container">
			<ul class="ag-cifras">
				<?php foreach ( $ag['cifras'] as $ag_i => $ag_cifra ) : ?>
					<li data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.12 ); ?>s;">
						<span class="ag-cifras__numero"><span data-ag-contador="<?php echo (int) $ag_cifra[0]; ?>"><?php echo esc_html( number_format_i18n( $ag_cifra[0] ) ); ?></span><?php echo esc_html( $ag_cifra[1] ); ?></span>
						<span class="ag-cifras__texto"><?php echo esc_html( $ag_cifra[2] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- =====================================================================
	     2. SERVICIOS
	     ===================================================================== -->
	<section id="servicios" class="ag-seccion ag-servicios">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta">Qué hago</span>
				<h2 class="ag-titulo">Servicios <strong>profesionales</strong></h2>
				<p class="ag-entradilla">Desde la idea hasta el resultado: desarrollo, formación y comunicación tecnológica con un enfoque cercano y práctico.</p>
			</header>

			<div class="ag-servicios__rejilla">
				<?php foreach ( $ag['servicios'] as $ag_i => $ag_servicio ) : ?>
					<article class="ag-servicio" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.15 ); ?>s; --color: <?php echo esc_attr( $ag_servicio['color'] ); ?>;">
						<div class="ag-servicio__marco">
							<div class="ag-servicio__interior">
								<span class="ag-servicio__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $ag_i + 1 ) ); ?></span>
								<div class="ag-servicio__icono"><?php echo ag_icono_inicio( $ag_servicio['icono'] ); // phpcs:ignore ?></div>
								<h3 class="ag-servicio__titulo"><?php echo esc_html( $ag_servicio['titulo'] ); ?></h3>
								<p class="ag-servicio__texto"><?php echo esc_html( $ag_servicio['texto'] ); ?></p>
								<ul class="ag-servicio__etiquetas">
									<?php foreach ( $ag_servicio['etiquetas'] as $ag_etiqueta ) : ?>
										<li><?php echo esc_html( $ag_etiqueta ); ?></li>
									<?php endforeach; ?>
								</ul>
								<a class="ag-servicio__enlace" href="#contacto">
									Pedir información <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?>
								</a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     3. TECNOLOGÍAS
	     ===================================================================== -->
	<section class="ag-seccion ag-stack">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta">Mi caja de herramientas</span>
				<h2 class="ag-titulo">Tecnologías con las que <strong>trabajo</strong></h2>
			</header>

			<div class="ag-stack__rejilla">
				<?php $ag_i = 0; ?>
				<?php foreach ( $ag['stack'] as $ag_grupo => $ag_items ) : ?>
					<div class="ag-stack__grupo" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i++ * 0.1 ); ?>s;">
						<h3><?php echo esc_html( $ag_grupo ); ?></h3>
						<ul>
							<?php foreach ( $ag_items as $ag_item ) : ?>
								<li><?php echo esc_html( $ag_item ); ?></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     4. IA EN LA EMPRESA — PARALLAX + LOGOS EN BUCLE
	     ===================================================================== -->
	<section id="ia" class="ag-ia">
		<div class="ag-ia__fondo" data-ag-parallax="0.35" style="background-image: url('<?php echo esc_url( get_template_directory_uri() . '/images/ia-fondo.jpg' ); ?>');" aria-hidden="true"></div>
		<div class="ag-ia__velo" aria-hidden="true"></div>
		<span class="ag-ia__orbe ag-ia__orbe--1" data-ag-parallax="-0.25" aria-hidden="true"></span>
		<span class="ag-ia__orbe ag-ia__orbe--2" data-ag-parallax="0.18" aria-hidden="true"></span>
		<span class="ag-ia__orbe ag-ia__orbe--3" data-ag-parallax="-0.12" aria-hidden="true"></span>

		<div class="ag-container ag-ia__contenido">
			<header class="ag-cabecera-seccion ag-cabecera-seccion--clara" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag['ia']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['ia']['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag['ia']['texto'] ); ?></p>
			</header>

			<div class="ag-beneficios">
				<?php foreach ( $ag['beneficios'] as $ag_i => $ag_beneficio ) : ?>
					<div class="ag-beneficio" data-ag-revelar style="--d: <?php echo esc_attr( ( $ag_i % 3 ) * 0.12 ); ?>s;">
						<div class="ag-beneficio__icono"><?php echo ag_icono_inicio( $ag_beneficio[0] ); // phpcs:ignore ?></div>
						<h3><?php echo esc_html( $ag_beneficio[1] ); ?></h3>
						<p><?php echo esc_html( $ag_beneficio[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>

			<p class="ag-ia__frase" data-ag-revelar data-ag-parallax="0.15" data-ag-parallax-limite="40"><?php echo wp_kses( $ag['ia']['frase'], $ag_tags ); ?></p>
		</div>

		<?php
		$ag_logos = ag_logos_empresas();
		$ag_lista = $ag_logos ? $ag_logos : array_map(
			function ( $nombre ) {
				return array(
					'url' => '',
					'alt' => $nombre,
				);
			},
			$ag['empresas']['ejemplos']
		);
		// Repetimos hasta tener al menos 10 para que la cinta nunca deje huecos.
		$ag_base = $ag_lista;
		while ( count( $ag_lista ) < 10 ) {
			$ag_lista = array_merge( $ag_lista, $ag_base );
		}
		?>
		<div class="ag-ia__empresas" data-ag-revelar>
			<h3 class="ag-ia__empresas-titulo"><?php echo esc_html( $ag['empresas']['titulo'] ); ?></h3>
			<div class="ag-logos" style="--duracion: <?php echo (int) max( 25, count( $ag_lista ) * 4 ); ?>s;">
				<div class="ag-logos__pista">
					<?php for ( $ag_copia = 0; $ag_copia < 2; $ag_copia++ ) : ?>
						<ul class="ag-logos__lista"<?php echo $ag_copia ? ' aria-hidden="true"' : ''; ?>>
							<?php foreach ( $ag_lista as $ag_logo ) : ?>
								<li class="ag-logos__item">
									<?php if ( $ag_logo['url'] ) : ?>
										<img src="<?php echo esc_url( $ag_logo['url'] ); ?>" alt="<?php echo $ag_copia ? '' : esc_attr( $ag_logo['alt'] ); ?>" loading="lazy">
									<?php else : ?>
										<span class="ag-logos__ejemplo"><?php echo esc_html( $ag_logo['alt'] ); ?></span>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     5. ÚLTIMAS PUBLICACIONES
	     ===================================================================== -->
	<?php
	$ag_entradas = new WP_Query(
		array(
			'posts_per_page'      => 3,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	if ( $ag_entradas->have_posts() ) :
		?>
		<section class="ag-seccion ag-blog">
			<div class="ag-container">
				<header class="ag-cabecera-seccion" data-ag-revelar>
					<span class="ag-etiqueta">Blog</span>
					<h2 class="ag-titulo">Últimas <strong>publicaciones</strong></h2>
					<p class="ag-entradilla">Tutoriales, novedades y reflexiones sobre programación, desarrollo web e inteligencia artificial.</p>
				</header>

				<div class="ag-blog__rejilla">
					<?php
					$ag_i = 0;
					while ( $ag_entradas->have_posts() ) :
						$ag_entradas->the_post();
						?>
						<article class="ag-entrada" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i++ * 0.12 ); ?>s;">
							<a class="ag-entrada__imagen" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( 'medium_large' ); ?>
								<?php else : ?>
									<span class="ag-entrada__sin-imagen"><?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-' . get_the_ID(), ag_icono( 'logo' ) ); // phpcs:ignore ?></span>
								<?php endif; ?>
							</a>
							<div class="ag-entrada__cuerpo">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
								<a class="ag-entrada__leer" href="<?php the_permalink(); ?>">Leer artículo <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?></a>
							</div>
						</article>
					<?php endwhile; ?>
				</div>
			</div>
		</section>
		<?php
	endif;
	wp_reset_postdata();
	?>

	<!-- =====================================================================
	     6. CONTACTO
	     ===================================================================== -->
	<?php
	$ag_email = get_theme_mod( 'ag_email', 'info@antoniogarciaprats.es' );
	$ag_tel   = get_theme_mod( 'ag_telefono', '+34 600 000 000' );
	?>
	<section id="contacto" class="ag-seccion ag-cta">
		<div class="ag-container">
			<div class="ag-cta__caja" data-ag-revelar>
				<span class="ag-cta__burbuja ag-cta__burbuja--1" aria-hidden="true"></span>
				<span class="ag-cta__burbuja ag-cta__burbuja--2" aria-hidden="true"></span>

				<h2 class="ag-cta__titulo"><?php echo esc_html( $ag['cta']['titulo'] ); ?></h2>
				<p class="ag-cta__texto"><?php echo esc_html( $ag['cta']['texto'] ); ?></p>

				<div class="ag-cta__botones">
					<?php if ( $ag_email ) : ?>
						<a class="ag-boton ag-boton--blanco" href="mailto:<?php echo esc_attr( antispambot( $ag_email ) ); ?>">
							<?php echo ag_icono( 'email' ); // phpcs:ignore ?> Escríbeme
						</a>
					<?php endif; ?>
					<?php if ( $ag_tel ) : ?>
						<a class="ag-boton ag-boton--borde" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $ag_tel ) ); ?>">
							<?php echo ag_icono( 'telefono' ); // phpcs:ignore ?> <?php echo esc_html( $ag_tel ); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
