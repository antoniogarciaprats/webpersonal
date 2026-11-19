<?php
/**
 * Template Name: Formación
 * Template Post Type: page
 *
 * Secciones:
 *  1. Presentación + destacados
 *  2. Formación para centros y empresas (áreas formativas)
 *  3. Material didáctico a medida (maqueta de manual, entregables y proceso)
 *  4. Modalidades
 *  5. Empresas con las que he trabajado (cinta de logos infinita)
 *  6. Llamada a la acción
 *
 * Textos en inc/formacion.php → ag_formacion_datos().
 *
 * @package antoniogarciaprats
 */

get_header();

$ag       = ag_formacion_datos();
$ag_tags  = array( 'strong' => array() );
$ag_email = get_theme_mod( 'ag_email', 'info@antoniogarciaprats.es' );
?>

<main id="primary" class="site-main ag-inicio ag-formacion">

	<!-- =====================================================================
	     1. PRESENTACIÓN
	     ===================================================================== -->
	<section class="ag-seccion ag-form-intro">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag['intro']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['intro']['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag['intro']['texto'] ); ?></p>
			</header>

			<ul class="ag-form-destacados">
				<?php foreach ( $ag['intro']['destacados'] as $ag_i => $ag_d ) : ?>
					<li data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.12 ); ?>s;">
						<span class="ag-form-destacados__icono"><?php echo ag_icono_inicio( $ag_d[0] ); // phpcs:ignore ?></span>
						<span><strong><?php echo esc_html( $ag_d[1] ); ?></strong><small><?php echo esc_html( $ag_d[2] ); ?></small></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>

	<!-- =====================================================================
	     2. FORMACIÓN PARA CENTROS Y EMPRESAS
	     ===================================================================== -->
	<section class="ag-seccion ag-form-areas">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag['cuenta_ajena']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['cuenta_ajena']['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag['cuenta_ajena']['texto'] ); ?></p>
			</header>

			<div class="ag-form-areas__rejilla">
				<?php foreach ( $ag['areas'] as $ag_i => $ag_area ) : ?>
					<article class="ag-area" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.12 ); ?>s; --color: <?php echo esc_attr( $ag_area[1] ); ?>;">
						<span class="ag-area__icono"><?php echo ag_icono_inicio( $ag_area[0] ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $ag_area[2] ); ?></h3>
						<p><?php echo esc_html( $ag_area[3] ); ?></p>
						<ul class="ag-area__tags">
							<?php foreach ( $ag_area[4] as $ag_tag ) : ?>
								<li><?php echo esc_html( $ag_tag ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     3. MATERIAL DIDÁCTICO A MEDIDA
	     ===================================================================== -->
	<?php $ag_m = $ag['material']; ?>
	<section id="material" class="ag-seccion ag-material">
		<div class="ag-container ag-material__rejilla">

			<!-- Maqueta: manual del curso -->
			<div class="ag-manual" data-ag-revelar="izquierda" aria-hidden="true">
				<div class="ag-manual__hoja ag-manual__hoja--3"></div>
				<div class="ag-manual__hoja ag-manual__hoja--2">
					<span class="ag-manual__linea ag-manual__linea--titulo"></span>
					<span class="ag-manual__linea"></span><span class="ag-manual__linea"></span><span class="ag-manual__linea ag-manual__linea--corta"></span>
					<span class="ag-manual__caja"></span>
					<span class="ag-manual__linea"></span><span class="ag-manual__linea ag-manual__linea--corta"></span>
				</div>
				<div class="ag-manual__portada">
					<div class="ag-manual__cabecera">
						<span class="ag-manual__logo"><?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-manual', ag_icono( 'logo' ) ); // phpcs:ignore ?></span>
						<small><?php echo esc_html( $ag_m['portada'][0] ); ?></small>
						<strong><?php echo esc_html( $ag_m['portada'][1] ); ?></strong>
					</div>
					<ol class="ag-manual__indice">
						<?php foreach ( $ag_m['portada'][2] as $ag_k => $ag_cap ) : ?>
							<li><span><?php echo esc_html( sprintf( '%02d', $ag_k + 1 ) ); ?></span><?php echo esc_html( $ag_cap ); ?></li>
						<?php endforeach; ?>
					</ol>
					<span class="ag-manual__pie"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				</div>
				<span class="ag-manual__chip ag-manual__chip--1">PDF maquetado</span>
				<span class="ag-manual__chip ag-manual__chip--2">Casos prácticos</span>
				<span class="ag-manual__chip ag-manual__chip--3">Actualizado <?php echo esc_html( date_i18n( 'Y' ) ); ?></span>
			</div>

			<div class="ag-material__texto" data-ag-revelar="derecha">
				<span class="ag-etiqueta"><?php echo esc_html( $ag_m['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag_m['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag_m['texto'] ); ?></p>

				<ul class="ag-entregables">
					<?php foreach ( $ag['entregables'] as $ag_e ) : ?>
						<li>
							<span class="ag-entregables__icono"><?php echo ag_icono_inicio( $ag_e[0] ); // phpcs:ignore ?></span>
							<span><strong><?php echo esc_html( $ag_e[1] ); ?></strong><?php echo esc_html( $ag_e[2] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<!-- Proceso de creación de un curso a medida -->
		<div class="ag-container">
			<h3 class="ag-proceso__titulo" data-ag-revelar><?php esc_html_e( 'Así creo un curso a medida', 'antoniogarciaprats' ); ?></h3>
			<ol class="ag-proceso">
				<?php foreach ( $ag['proceso'] as $ag_i => $ag_paso ) : ?>
					<li class="ag-proceso__paso" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.12 ); ?>s;">
						<span class="ag-proceso__num"><?php echo (int) $ag_i + 1; ?></span>
						<strong><?php echo esc_html( $ag_paso[0] ); ?></strong>
						<p><?php echo esc_html( $ag_paso[1] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- =====================================================================
	     4. MODALIDADES
	     ===================================================================== -->
	<section class="ag-seccion ag-modalidades">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php esc_html_e( 'Como mejor te encaje', 'antoniogarciaprats' ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( __( 'Modalidades de <strong>formación</strong>', 'antoniogarciaprats' ), $ag_tags ); ?></h2>
			</header>
			<div class="ag-modalidades__rejilla">
				<?php foreach ( $ag['modalidades'] as $ag_i => $ag_mod ) : ?>
					<div class="ag-modalidad" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.12 ); ?>s;">
						<span class="ag-modalidad__icono"><?php echo ag_icono_inicio( $ag_mod[0] ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $ag_mod[1] ); ?></h3>
						<p><?php echo esc_html( $ag_mod[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     5. EMPRESAS (misma cinta de logos que la portada)
	     ===================================================================== -->
	<?php
	$ag_logos   = ag_logos_empresas();
	$ag_inicio  = ag_inicio_datos();
	$ag_lista   = $ag_logos ? $ag_logos : array_map(
		function ( $nombre ) {
			return array(
				'url' => '',
				'alt' => $nombre,
			);
		},
		$ag_inicio['empresas']['ejemplos']
	);
	$ag_base    = $ag_lista;
	while ( count( $ag_lista ) < 10 ) {
		$ag_lista = array_merge( $ag_lista, $ag_base );
	}
	?>
	<section class="ag-form-empresas">
		<div class="ag-container">
			<header class="ag-cabecera-seccion ag-cabecera-seccion--clara" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag['empresas']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo esc_html( $ag['empresas']['titulo'] ); ?></h2>
			</header>
		</div>
		<div class="ag-logos" data-ag-revelar style="--duracion: <?php echo (int) max( 25, count( $ag_lista ) * 4 ); ?>s;">
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
	</section>

	<!-- =====================================================================
	     6. LLAMADA A LA ACCIÓN
	     ===================================================================== -->
	<section class="ag-seccion ag-cta">
		<div class="ag-container">
			<div class="ag-cta__caja" data-ag-revelar>
				<span class="ag-cta__burbuja ag-cta__burbuja--1" aria-hidden="true"></span>
				<span class="ag-cta__burbuja ag-cta__burbuja--2" aria-hidden="true"></span>
				<h2 class="ag-cta__titulo"><?php echo esc_html( $ag['cta']['titulo'] ); ?></h2>
				<p class="ag-cta__texto"><?php echo esc_html( $ag['cta']['texto'] ); ?></p>
				<div class="ag-cta__botones">
					<?php if ( $ag_email ) : ?>
						<?php
						$ag_enlace = function_exists( 'ag_contacto_mailto' )
							? ag_contacto_mailto( $ag_email, 'Curso a medida para mi empresa' )
							: 'mailto:' . antispambot( $ag_email ) . '?subject=' . rawurlencode( 'Curso a medida para mi empresa' );
						?>
						<a class="ag-boton ag-boton--blanco" href="<?php echo esc_attr( $ag_enlace ); ?>">
							<?php echo ag_icono( 'email' ); // phpcs:ignore ?> <?php esc_html_e( 'Pedir propuesta', 'antoniogarciaprats' ); ?>
						</a>
					<?php endif; ?>
					<a class="ag-boton ag-boton--borde" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>">
						<?php esc_html_e( 'Otras formas de contacto', 'antoniogarciaprats' ); ?> <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?>
					</a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
