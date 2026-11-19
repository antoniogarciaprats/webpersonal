<?php
/**
 * Template Name: Quién soy
 * Template Post Type: page
 *
 * Página de presentación personal dividida en secciones:
 *  1. Presentación + accesos a las cuatro facetas
 *  2. Facetas: emprendedor, desarrollador web, formador y programador
 *  3. Proyecto destacado: Explora Andalucía
 *  4. Trayectoria (carretera con curvas)
 *  5. Titulaciones
 *  6. Valores: cómo trabajo
 *  7. Llamada a la acción
 *
 * Los textos se editan en inc/quien-soy.php → ag_quien_soy_datos().
 * La cabecera (imagen, título y subtítulo) sale de la propia página:
 * imagen destacada, título y extracto.
 *
 * @package antoniogarciaprats
 */

get_header();

$ag      = ag_quien_soy_datos();
$ag_tags = array(
	'strong' => array(),
	'em'     => array(),
	'br'     => array(),
);
?>

<main id="primary" class="site-main ag-inicio ag-quien">

	<!-- =====================================================================
	     1. PRESENTACIÓN
	     ===================================================================== -->
	<section class="ag-seccion ag-quien-intro">
		<div class="ag-container ag-quien-intro__rejilla">

			<div class="ag-quien-intro__texto" data-ag-revelar="izquierda">
				<span class="ag-etiqueta"><?php echo esc_html( $ag['intro']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['intro']['titulo'], $ag_tags ); ?></h2>
				<p class="ag-quien-intro__lead"><?php echo wp_kses( $ag['intro']['lead'], $ag_tags ); ?></p>
				<?php foreach ( $ag['intro']['parrafos'] as $ag_parrafo ) : ?>
					<p><?php echo wp_kses( $ag_parrafo, $ag_tags ); ?></p>
				<?php endforeach; ?>

				<div class="ag-quien-firma">
					<span class="ag-quien-firma__logo"><?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-firma', ag_icono( 'logo' ) ); // phpcs:ignore ?></span>
					<span>
						<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
						<small><?php echo esc_html( $ag['intro']['firma'] ); ?></small>
					</span>
				</div>
			</div>

			<div class="ag-quien-intro__media" data-ag-revelar="derecha">
				<div class="ag-sobre__decoracion" aria-hidden="true"></div>
				<?php $ag_foto = ag_foto_quien_soy(); ?>
				<?php if ( $ag_foto ) : ?>
					<div class="ag-sobre__marco">
						<img src="<?php echo esc_url( $ag_foto ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="880" height="1100" loading="lazy">
					</div>
				<?php else : ?>
					<div class="ag-sobre__marco ag-sobre__marco--vacio">
						<?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-quien', ag_icono( 'logo' ) ); // phpcs:ignore ?>
						<span>Añade tu foto en Personalizar › Página "Quién soy"</span>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- Accesos rápidos a cada faceta -->
		<div class="ag-container">
			<nav class="ag-facetas-nav" aria-label="<?php esc_attr_e( 'Mis facetas', 'antoniogarciaprats' ); ?>">
				<?php foreach ( $ag['facetas'] as $ag_i => $ag_faceta ) : ?>
					<a href="#<?php echo esc_attr( $ag_faceta['id'] ); ?>" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.1 ); ?>s; --color: <?php echo esc_attr( $ag_faceta['color'] ); ?>;">
						<span class="ag-facetas-nav__icono"><?php echo ag_icono_inicio( $ag_faceta['icono'] ); // phpcs:ignore ?></span>
						<span class="ag-facetas-nav__texto">
							<small><?php echo esc_html( sprintf( '%02d', $ag_i + 1 ) ); ?></small>
							<?php echo esc_html( $ag_faceta['nombre'] ); ?>
						</span>
					</a>
				<?php endforeach; ?>
			</nav>
		</div>
	</section>

	<!-- =====================================================================
	     2. LAS CUATRO FACETAS
	     ===================================================================== -->
	<?php foreach ( $ag['facetas'] as $ag_i => $ag_faceta ) : ?>
		<section id="<?php echo esc_attr( $ag_faceta['id'] ); ?>" class="ag-seccion ag-faceta<?php echo $ag_i % 2 ? ' ag-faceta--invertida' : ''; ?>" style="--color: <?php echo esc_attr( $ag_faceta['color'] ); ?>;">
			<div class="ag-container ag-faceta__rejilla">

				<div class="ag-faceta__texto" data-ag-revelar>
					<span class="ag-faceta__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', $ag_i + 1 ) ); ?></span>
					<span class="ag-faceta__etiqueta">
						<span class="ag-faceta__icono"><?php echo ag_icono_inicio( $ag_faceta['icono'] ); // phpcs:ignore ?></span>
						<?php echo esc_html( $ag_faceta['nombre'] ); ?>
					</span>
					<h2 class="ag-titulo"><?php echo wp_kses( $ag_faceta['titulo'], $ag_tags ); ?></h2>
					<p><?php echo esc_html( $ag_faceta['texto'] ); ?></p>

					<ul class="ag-faceta__puntos">
						<?php foreach ( $ag_faceta['puntos'] as $ag_punto ) : ?>
							<li><?php echo ag_icono_inicio( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $ag_punto ); ?></span></li>
						<?php endforeach; ?>
					</ul>

					<ul class="ag-faceta__tags">
						<?php foreach ( $ag_faceta['tags'] as $ag_tag ) : ?>
							<li><?php echo esc_html( $ag_tag ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="ag-faceta__visual" data-ag-revelar style="--d: 0.15s;">
					<?php ag_quien_visual( $ag_faceta['visual'] ); ?>
				</div>
			</div>
		</section>
	<?php endforeach; ?>

	<!-- =====================================================================
	     3. PROYECTO DESTACADO
	     ===================================================================== -->
	<?php $ag_p = $ag['proyecto']; ?>
	<section id="proyecto-destacado" class="ag-seccion ag-proyecto">
		<div class="ag-container ag-proyecto__rejilla">

			<div class="ag-proyecto__texto" data-ag-revelar="izquierda">
				<span class="ag-etiqueta">Proyecto destacado</span>
				<h2 class="ag-titulo"><?php echo esc_html( $ag_p['nombre'] ); ?></h2>
				<p class="ag-proyecto__lema">«<?php echo esc_html( $ag_p['lema'] ); ?>»</p>
				<p><?php echo esc_html( $ag_p['texto'] ); ?></p>

				<ul class="ag-proyecto__claves">
					<?php foreach ( $ag_p['claves'] as $ag_clave ) : ?>
						<li><?php echo esc_html( $ag_clave ); ?></li>
					<?php endforeach; ?>
				</ul>

				<div class="ag-proyecto__acciones">
					<a class="ag-boton ag-boton--blanco" href="<?php echo esc_url( $ag_p['url'] ); ?>" target="_blank" rel="noopener">
						Visitar <?php echo esc_html( $ag_p['dominio'] ); ?>
						<svg class="ag-icono-externo" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
						<span class="screen-reader-text">(se abre en una pestaña nueva)</span>
					</a>
					<span class="ag-proyecto__tecnologia"><?php echo esc_html( $ag_p['tecnologia'] ); ?></span>
				</div>
			</div>

			<a class="ag-proyecto__visual" href="<?php echo esc_url( $ag_p['url'] ); ?>" target="_blank" rel="noopener" data-ag-revelar="derecha" aria-label="<?php echo esc_attr( sprintf( 'Ver %s (se abre en una pestaña nueva)', $ag_p['nombre'] ) ); ?>">
				<div class="ag-mock ag-mock--proyecto">
					<div class="ag-mock__barra"><span></span><span></span><span></span><em><?php echo esc_html( $ag_p['dominio'] ); ?></em></div>
					<?php $ag_captura = ag_captura_proyecto(); ?>
					<?php if ( $ag_captura ) : ?>
						<img class="ag-mock-explora__captura" src="<?php echo esc_url( $ag_captura ); ?>" alt="" loading="lazy">
					<?php else : ?>
						<div class="ag-mock-explora">
							<div class="ag-mock-explora__hero">
								<span class="ag-mock-explora__sol" aria-hidden="true"></span>
								<small>Rutas · Rincones · Patrimonio</small>
								<strong><?php echo esc_html( $ag_p['nombre'] ); ?></strong>
								<span><?php echo esc_html( $ag_p['lema'] ); ?></span>
							</div>
							<ul class="ag-mock-explora__provincias">
								<?php foreach ( $ag_p['provincias'] as $ag_provincia ) : ?>
									<li><?php echo esc_html( $ag_provincia ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					<?php endif; ?>
				</div>
				<span class="ag-proyecto__sello" aria-hidden="true">Ver web ↗</span>
			</a>
		</div>
	</section>

	<!-- =====================================================================
	     4. TRAYECTORIA
	     ===================================================================== -->
	<section class="ag-seccion ag-trayectoria">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta">Mi recorrido</span>
				<h2 class="ag-titulo">Una trayectoria <strong>en constante evolución</strong></h2>
			</header>

			<?php
			$ag_filas   = array_chunk( $ag['trayectoria'], 3 );
			$ag_total   = count( $ag['trayectoria'] );
			$ag_colores = array( '#f29b38', '#e8566c', '#7a5cd6', '#437eb6', '#2bb3a0', '#1b3a5c' );
			$ag_n       = 0;
			?>
			<div class="ag-carretera">
				<?php foreach ( $ag_filas as $ag_f => $ag_fila ) : ?>
					<?php
					$ag_vuelta = ( 1 === $ag_f % 2 );
					$ag_ultima = ( count( $ag_filas ) - 1 === $ag_f );
					$ag_trazo  = ag_carretera_trazado( $ag_vuelta, 0 === $ag_f, $ag_ultima );
					$ag_clases = 'ag-carretera__tramo' . ( $ag_vuelta ? ' ag-carretera__tramo--vuelta' : '' ) . ( $ag_ultima ? ' ag-carretera__tramo--final' : '' );
					?>
					<div class="<?php echo esc_attr( $ag_clases ); ?>">

						<div class="ag-carretera__via" data-ag-revelar aria-hidden="true">
							<svg viewBox="0 0 1200 80" preserveAspectRatio="none">
								<path class="ag-carretera__arcen" d="<?php echo esc_attr( $ag_trazo ); ?>" vector-effect="non-scaling-stroke" />
								<path class="ag-carretera__asfalto" d="<?php echo esc_attr( $ag_trazo ); ?>" vector-effect="non-scaling-stroke" />
								<path class="ag-carretera__linea" d="<?php echo esc_attr( $ag_trazo ); ?>" vector-effect="non-scaling-stroke" />
							</svg>
						</div>

						<ol class="ag-carretera__hitos" start="<?php echo (int) $ag_n + 1; ?>">
							<?php foreach ( $ag_fila as $ag_k => $ag_hito ) : ?>
								<?php
								$ag_col   = $ag_vuelta ? 3 - $ag_k : $ag_k + 1;
								$ag_color = $ag_colores[ $ag_n % count( $ag_colores ) ];
								$ag_n++;
								?>
								<li class="ag-carretera__hito<?php echo $ag_n === $ag_total ? ' ag-carretera__hito--hoy' : ''; ?>" data-ag-revelar style="--col: <?php echo (int) $ag_col; ?>; --color: <?php echo esc_attr( $ag_color ); ?>; --d: <?php echo esc_attr( 0.2 + $ag_k * 0.15 ); ?>s;">
									<span class="ag-carretera__pin"><?php echo (int) $ag_n; ?></span>
									<div class="ag-carretera__tarjeta">
										<span class="ag-carretera__etapa"><?php echo esc_html( $ag_hito[0] ); ?></span>
										<h3><?php echo esc_html( $ag_hito[1] ); ?></h3>
										<p><?php echo esc_html( $ag_hito[2] ); ?></p>
									</div>
								</li>
							<?php endforeach; ?>
						</ol>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     5. TITULACIONES
	     ===================================================================== -->
	<section class="ag-seccion ag-titulaciones">
		<div class="ag-container">
			<header class="ag-cabecera-seccion ag-cabecera-seccion--compacta" data-ag-revelar>
				<span class="ag-etiqueta">Formación académica</span>
				<h2 class="ag-titulo">Mis <strong>titulaciones</strong></h2>
			</header>

			<?php
			// Carrusel infinito: se repite la lista hasta tener al menos 6 tarjetas
			// para que nunca queden huecos, y se duplica para el bucle continuo.
			$ag_tits  = $ag['titulaciones'];
			$ag_lista = $ag_tits;
			while ( count( $ag_lista ) < 6 ) {
				$ag_lista = array_merge( $ag_lista, $ag_tits );
			}
			?>
			<div class="ag-carrusel" data-ag-revelar style="--duracion: <?php echo (int) max( 30, count( $ag_lista ) * 7 ); ?>s;">
				<div class="ag-carrusel__pista">
					<?php for ( $ag_copia = 0; $ag_copia < 2; $ag_copia++ ) : ?>
						<ul class="ag-carrusel__lista"<?php echo $ag_copia ? ' aria-hidden="true"' : ''; ?>>
							<?php foreach ( $ag_lista as $ag_k => $ag_titulo ) : ?>
								<?php
								// La lista repetida no se lee dos veces con lector de pantalla.
								$ag_repetida = $ag_copia || $ag_k >= count( $ag_tits );
								?>
								<li class="ag-titulacion"<?php echo ( $ag_repetida && ! $ag_copia ) ? ' aria-hidden="true"' : ''; ?>>
									<span class="ag-titulacion__num" aria-hidden="true"><?php echo esc_html( sprintf( '%02d', ( $ag_k % count( $ag_tits ) ) + 1 ) ); ?></span>
									<span class="ag-titulacion__tipo"><?php echo esc_html( $ag_titulo[0] ); ?></span>
									<h3><?php echo esc_html( $ag_titulo[1] ); ?></h3>
									<span class="ag-titulacion__entidad"><?php echo esc_html( $ag_titulo[2] ); ?></span>
									<p><?php echo esc_html( $ag_titulo[3] ); ?></p>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endfor; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     6. VALORES
	     ===================================================================== -->
	<section class="ag-seccion ag-valores">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta">Cómo trabajo</span>
				<h2 class="ag-titulo">Los valores que <strong>me definen</strong></h2>
			</header>

			<div class="ag-valores__rejilla">
				<?php foreach ( $ag['valores'] as $ag_i => $ag_valor ) : ?>
					<div class="ag-valor" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.12 ); ?>s;">
						<span class="ag-valor__icono"><?php echo ag_icono_inicio( $ag_valor[0] ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $ag_valor[1] ); ?></h3>
						<p><?php echo esc_html( $ag_valor[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     7. LLAMADA A LA ACCIÓN
	     ===================================================================== -->
	<?php $ag_email = get_theme_mod( 'ag_email', 'info@antoniogarciaprats.es' ); ?>
	<section class="ag-seccion ag-cta">
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
					<a class="ag-boton ag-boton--borde" href="<?php echo esc_url( home_url( '/#servicios' ) ); ?>">
						Ver mis servicios <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
