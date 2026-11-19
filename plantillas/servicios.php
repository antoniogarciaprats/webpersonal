<?php
/**
 * Template Name: Servicios
 * Template Post Type: page
 *
 * Secciones:
 *  1. Presentación + índice de servicios
 *  2. Diseño web (tipos de web, qué incluye y guía rápida)
 *  3. Apps Android · Aplicaciones a medida · Cursos PDF · Contenidos (zigzag)
 *  4. Formación (autónomo / cuenta ajena)
 *  5. Por qué trabajar conmigo
 *  6. Antes de empezar · Después de la entrega
 *  7. Llamada a la acción
 *
 * Textos en inc/servicios.php → ag_servicios_datos().
 *
 * @package antoniogarciaprats
 */

get_header();

$ag       = ag_servicios_datos();
$ag_tags  = array( 'strong' => array() );
$ag_email = get_theme_mod( 'ag_email', 'info@antoniogarciaprats.es' );
?>

<main id="primary" class="site-main ag-inicio ag-servicios-pag">

	<!-- =====================================================================
	     1. PRESENTACIÓN + ÍNDICE
	     ===================================================================== -->
	<section class="ag-seccion ag-serv-intro">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag['intro']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['intro']['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag['intro']['texto'] ); ?></p>
				<div class="ag-serv-intro__portfolio"><?php ag_servicios_portfolio(); ?></div>
			</header>

			<nav class="ag-serv-indice" aria-label="<?php esc_attr_e( 'Mis servicios', 'antoniogarciaprats' ); ?>">
				<?php foreach ( $ag['indice'] as $ag_i => $ag_item ) : ?>
					<a href="#<?php echo esc_attr( $ag_item[0] ); ?>" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.08 ); ?>s; --color: <?php echo esc_attr( $ag_item[2] ); ?>;">
						<span class="ag-serv-indice__icono"><?php echo ag_icono_inicio( $ag_item[1] ); // phpcs:ignore ?></span>
						<span class="ag-serv-indice__texto"><?php echo esc_html( $ag_item[3] ); ?></span>
						<span class="ag-serv-indice__flecha" aria-hidden="true">↓</span>
					</a>
				<?php endforeach; ?>
			</nav>
		</div>
	</section>

	<!-- =====================================================================
	     2. DISEÑO WEB
	     ===================================================================== -->
	<?php $ag_w = $ag['web']; ?>
	<section id="diseno-web" class="ag-seccion ag-serv-web">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag_w['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag_w['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag_w['texto'] ); ?></p>
			</header>

			<div class="ag-tipos-web">
				<?php foreach ( $ag_w['tipos'] as $ag_i => $ag_tipo ) : ?>
					<article class="ag-tipo-web" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.1 ); ?>s;">
						<span class="ag-tipo-web__icono"><?php echo ag_icono_inicio( $ag_tipo[0] ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $ag_tipo[1] ); ?></h3>
						<p><?php echo esc_html( $ag_tipo[2] ); ?></p>
						<span class="ag-tipo-web__ideal"><?php esc_html_e( 'Ideal para:', 'antoniogarciaprats' ); ?> <strong><?php echo esc_html( $ag_tipo[3] ); ?></strong></span>
					</article>
				<?php endforeach; ?>
			</div>

			<div class="ag-serv-web__extra">
				<div class="ag-incluye" data-ag-revelar="izquierda">
					<h3><?php esc_html_e( 'Todas mis webs incluyen', 'antoniogarciaprats' ); ?></h3>
					<ul>
						<?php foreach ( $ag_w['incluye'] as $ag_item ) : ?>
							<li><?php echo ag_icono_inicio( 'check' ); // phpcs:ignore ?><?php echo esc_html( $ag_item ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="ag-guia" data-ag-revelar="derecha">
					<h3><?php esc_html_e( 'Guía rápida: ¿qué web necesitas?', 'antoniogarciaprats' ); ?></h3>
					<dl>
						<?php foreach ( $ag['guia'] as $ag_fila ) : ?>
							<div class="ag-guia__fila">
								<dt><?php echo esc_html( $ag_fila[0] ); ?></dt>
								<dd><?php echo esc_html( $ag_fila[1] ); ?></dd>
							</div>
						<?php endforeach; ?>
					</dl>
				</div>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     3. APPS · CURSOS PDF · CONTENIDOS
	     ===================================================================== -->
	<?php foreach ( $ag['servicios'] as $ag_i => $ag_s ) : ?>
		<section id="<?php echo esc_attr( $ag_s['id'] ); ?>" class="ag-seccion ag-serv-bloque<?php echo $ag_i % 2 ? '' : ' ag-serv-bloque--invertido'; ?>" style="--color: <?php echo esc_attr( $ag_s['color'] ); ?>;">
			<div class="ag-container ag-serv-bloque__rejilla">

				<div class="ag-serv-bloque__visual" data-ag-revelar aria-hidden="true">
					<div class="ag-serv-tarjeta">
						<span class="ag-serv-tarjeta__icono"><?php echo ag_icono_inicio( $ag_s['icono'] ); // phpcs:ignore ?></span>
						<span class="ag-serv-tarjeta__nombre"><?php echo esc_html( $ag_s['nombre'] ); ?></span>
						<?php foreach ( $ag_s['chips'] as $ag_k => $ag_chip ) : ?>
							<span class="ag-serv-tarjeta__chip ag-serv-tarjeta__chip--<?php echo (int) $ag_k + 1; ?>"><?php echo esc_html( $ag_chip ); ?></span>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="ag-serv-bloque__texto" data-ag-revelar style="--d: 0.12s;">
					<span class="ag-serv-bloque__etiqueta">
						<span><?php echo ag_icono_inicio( $ag_s['icono'] ); // phpcs:ignore ?></span>
						<?php echo esc_html( $ag_s['nombre'] ); ?>
					</span>
					<h2 class="ag-titulo"><?php echo wp_kses( $ag_s['titulo'], $ag_tags ); ?></h2>
					<p><?php echo esc_html( $ag_s['texto'] ); ?></p>
					<ul class="ag-serv-bloque__puntos">
						<?php foreach ( $ag_s['puntos'] as $ag_punto ) : ?>
							<li><?php echo ag_icono_inicio( 'check' ); // phpcs:ignore ?><span><?php echo esc_html( $ag_punto ); ?></span></li>
						<?php endforeach; ?>
					</ul>
					<?php if ( array( 'portfolio' ) === $ag_s['enlace'] ) : ?>
						<?php ag_servicios_portfolio( 'ag-portfolio--bloque' ); ?>
					<?php elseif ( $ag_s['enlace'] ) : ?>
						<a class="ag-serv-bloque__enlace" href="<?php echo esc_url( home_url( $ag_s['enlace'][1] ) ); ?>">
							<?php echo esc_html( $ag_s['enlace'][0] ); ?> <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endforeach; ?>

	<!-- =====================================================================
	     4. FORMACIÓN
	     ===================================================================== -->
	<?php $ag_f = $ag['formacion']; ?>
	<section id="formacion-empresas" class="ag-seccion ag-serv-formacion">
		<div class="ag-container">
			<header class="ag-cabecera-seccion ag-cabecera-seccion--clara" data-ag-revelar>
				<span class="ag-etiqueta"><?php echo esc_html( $ag_f['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag_f['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag_f['texto'] ); ?></p>
			</header>

			<div class="ag-modos">
				<?php foreach ( $ag_f['opciones'] as $ag_i => $ag_op ) : ?>
					<article class="ag-modo" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.15 ); ?>s;">
						<span class="ag-modo__icono"><?php echo ag_icono_inicio( $ag_op[0] ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $ag_op[1] ); ?></h3>
						<span class="ag-modo__sub"><?php echo esc_html( $ag_op[2] ); ?></span>
						<p><?php echo esc_html( $ag_op[3] ); ?></p>
						<ul>
							<?php foreach ( $ag_op[4] as $ag_punto ) : ?>
								<li><?php echo ag_icono_inicio( 'check' ); // phpcs:ignore ?><?php echo esc_html( $ag_punto ); ?></li>
							<?php endforeach; ?>
						</ul>
					</article>
				<?php endforeach; ?>
			</div>

			<p class="ag-serv-formacion__enlace" data-ag-revelar>
				<a class="ag-boton ag-boton--blanco" href="<?php echo esc_url( home_url( $ag_f['enlace'][1] ) ); ?>"><?php echo esc_html( $ag_f['enlace'][0] ); ?> <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?></a>
			</p>
		</div>
	</section>

	<!-- =====================================================================
	     5. POR QUÉ TRABAJAR CONMIGO
	     ===================================================================== -->
	<section class="ag-seccion ag-porque">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php esc_html_e( 'Ventajas', 'antoniogarciaprats' ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( __( '¿Por qué trabajar <strong>conmigo</strong>?', 'antoniogarciaprats' ), $ag_tags ); ?></h2>
			</header>
			<div class="ag-porque__rejilla">
				<?php foreach ( $ag['porque'] as $ag_i => $ag_p ) : ?>
					<div class="ag-porque__item" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.1 ); ?>s;">
						<span class="ag-porque__icono"><?php echo ag_icono_inicio( $ag_p[0] ); // phpcs:ignore ?></span>
						<h3><?php echo esc_html( $ag_p[1] ); ?></h3>
						<p><?php echo esc_html( $ag_p[2] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     6. ANTES DE EMPEZAR · DESPUÉS DE LA ENTREGA
	     ===================================================================== -->
	<section class="ag-seccion ag-consejos">
		<div class="ag-container ag-consejos__rejilla">

			<div class="ag-preparar" data-ag-revelar="izquierda">
				<span class="ag-etiqueta"><?php esc_html_e( 'Consejo', 'antoniogarciaprats' ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( __( 'Antes de empezar, <strong>prepara esto</strong>', 'antoniogarciaprats' ), $ag_tags ); ?></h2>
				<p><?php esc_html_e( 'Con estas cinco ideas claras, la primera conversación será mucho más productiva y la propuesta, más ajustada a lo que necesitas.', 'antoniogarciaprats' ); ?></p>
				<ol class="ag-preparar__lista">
					<?php foreach ( $ag['preparar'] as $ag_i => $ag_p ) : ?>
						<li>
							<span class="ag-preparar__num"><?php echo (int) $ag_i + 1; ?></span>
							<span><strong><?php echo esc_html( $ag_p[0] ); ?></strong><?php echo esc_html( $ag_p[1] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ol>
			</div>

			<div class="ag-despues" data-ag-revelar="derecha">
				<h3><?php esc_html_e( 'Y después de la entrega…', 'antoniogarciaprats' ); ?></h3>
				<p><?php esc_html_e( 'Un proyecto digital no termina el día que se publica. Puedo seguir a tu lado con:', 'antoniogarciaprats' ); ?></p>
				<ul>
					<?php foreach ( $ag['despues'] as $ag_d ) : ?>
						<li>
							<span class="ag-despues__icono"><?php echo ag_icono_inicio( $ag_d[0] ); // phpcs:ignore ?></span>
							<span><strong><?php echo esc_html( $ag_d[1] ); ?></strong><?php echo esc_html( $ag_d[2] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     7. LLAMADA A LA ACCIÓN
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
							? ag_contacto_mailto( $ag_email, 'Quiero información sobre un servicio' )
							: 'mailto:' . antispambot( $ag_email );
						?>
						<a class="ag-boton ag-boton--blanco" href="<?php echo esc_attr( $ag_enlace ); ?>"><?php echo ag_icono( 'email' ); // phpcs:ignore ?> <?php esc_html_e( 'Pedir presupuesto', 'antoniogarciaprats' ); ?></a>
					<?php endif; ?>
					<a class="ag-boton ag-boton--borde" href="<?php echo esc_url( home_url( '/contacto/' ) ); ?>"><?php esc_html_e( 'Ver formas de contacto', 'antoniogarciaprats' ); ?> <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?></a>
				</div>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
