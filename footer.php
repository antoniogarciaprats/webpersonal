<?php
/**
 * Pie de página del tema (sustituye al footer.php de Underscores).
 *
 * Estructura:
 *  1. Olas de transición entre el contenido y el pie.
 *  2. Redes sociales con efecto de "líquido" al pasar el ratón.
 *  3. Logo en blanco rodeado por un anillo punteado que gira.
 *  4. Barra inferior negra con el copyright, el nombre y el menú legal.
 *
 * @package antoniogarciaprats
 */

$ag_redes  = ag_redes_sociales();
$ag_titulo = get_theme_mod( 'ag_pie_titulo', 'Conecta conmigo' );
$ag_texto  = get_theme_mod( 'ag_pie_texto', 'Comparto recursos de programación, desarrollo web y formación tecnológica. ¡Sígueme en redes!' );
?>

	<footer id="colophon" class="site-footer ag-pie">

		<!-- 1. OLAS DE TRANSICIÓN ========================================== -->
		<div class="ag-pie__olas" aria-hidden="true">
			<svg viewBox="0 24 150 28" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
				<path class="ag-pie-ola ag-pie-ola--1" d="M-250 40c20.4 0 39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10V60H-250z" />
				<path class="ag-pie-ola ag-pie-ola--2" d="M-235 44c16.15 0 31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9V60H-235z" />
				<path class="ag-pie-ola ag-pie-ola--3" d="M-230 48c17 0 33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7V60H-230z" />
			</svg>
		</div>

		<div class="ag-pie__cuerpo">
			<div class="ag-container">

				<!-- 2. REDES SOCIALES ========================================= -->
				<?php if ( $ag_titulo ) : ?>
					<h2 class="ag-pie__titulo"><?php echo esc_html( $ag_titulo ); ?></h2>
				<?php endif; ?>

				<?php if ( $ag_texto ) : ?>
					<p class="ag-pie__texto"><?php echo esc_html( $ag_texto ); ?></p>
				<?php endif; ?>

				<?php if ( $ag_redes ) : ?>
					<ul class="ag-redes">
						<?php $ag_i = 0; ?>
						<?php foreach ( $ag_redes as $ag_red => $ag_datos ) : ?>
							<li style="--i: <?php echo (int) $ag_i++; ?>;">
								<a class="ag-red ag-red--<?php echo esc_attr( $ag_red ); ?>" href="<?php echo esc_url( $ag_datos[1] ); ?>" target="_blank" rel="noopener me">
									<span class="ag-red__icono" aria-hidden="true"><?php echo ag_icono_red( $ag_red ); // phpcs:ignore ?></span>
									<span class="ag-red__nombre"><?php echo esc_html( $ag_datos[0] ); ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<!-- 3. LOGO ================================================== -->
				<div class="ag-sello">
					<a class="ag-sello__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						<?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-pie', ag_icono( 'logo' ) ); // phpcs:ignore ?>
					</a>
				</div>

			</div>
		</div>

		<!-- 4. BARRA INFERIOR: COPYRIGHT + MENÚ LEGAL ======================= -->
		<div class="ag-pie__barra">
			<div class="ag-container">
				<p class="ag-pie__copyright">
					&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?>
					<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
					<span class="ag-pie__sep" aria-hidden="true">·</span>
					<span class="ag-pie__reservados"><?php echo esc_html( get_theme_mod( 'ag_pie_copyright', 'Todos los derechos reservados' ) ); ?></span>
				</p>

				<?php
				wp_nav_menu(
					array(
						'theme_location'       => 'menu-legal',
						'menu_class'           => 'ag-pie__legal',
						'container'            => 'nav',
						'container_aria_label' => esc_attr__( 'Información legal', 'antoniogarciaprats' ),
						'depth'                => 1,
						'fallback_cb'          => false,
					)
				);
				?>
			</div>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
