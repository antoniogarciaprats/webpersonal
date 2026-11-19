<?php
/**
 * Cabecera del tema (sustituye al header.php de Underscores).
 *
 * Estructura:
 *  1. Barra superior con email y teléfono.
 *  2. Hero con imagen de fondo + capa azul semitransparente.
 *  3. Navegación partida: menú izquierdo · logo centrado · menú derecho.
 *  4. Rótulo con eslogan y subtítulo.
 *  5. Olas de mar animadas en la parte inferior.
 *
 * @package antoniogarciaprats
 */

$ag_email      = get_theme_mod( 'ag_email', 'info@antoniogarciaprats.es' );
$ag_telefono   = get_theme_mod( 'ag_telefono', '+34 600 000 000' );
$ag_imagen     = get_header_image() ? get_header_image() : get_template_directory_uri() . '/images/cabecera-hero.jpg';
$ag_redes      = array(
	'linkedin' => get_theme_mod( 'ag_linkedin', '' ),
	'github'   => get_theme_mod( 'ag_github', '' ),
	'facebook' => get_theme_mod( 'ag_facebook', '' ),
);
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Saltar al contenido', 'antoniogarciaprats' ); ?></a>

	<header id="masthead" class="site-header ag-header">

		<!-- 1. BARRA SUPERIOR ============================================== -->
		<div class="ag-topbar">
			<div class="ag-container">
				<ul class="ag-topbar__contacto">
					<?php if ( $ag_email ) : ?>
						<li>
							<a href="mailto:<?php echo esc_attr( antispambot( $ag_email ) ); ?>" aria-label="<?php esc_attr_e( 'Enviar un correo electrónico', 'antoniogarciaprats' ); ?>">
								<span class="ag-icono" aria-hidden="true"><?php echo ag_icono( 'email' ); // phpcs:ignore ?></span>
								<span class="ag-topbar__texto"><?php echo esc_html( antispambot( $ag_email ) ); ?></span>
							</a>
						</li>
					<?php endif; ?>

					<?php if ( $ag_telefono ) : ?>
						<li>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $ag_telefono ) ); ?>" aria-label="<?php esc_attr_e( 'Llamar por teléfono', 'antoniogarciaprats' ); ?>">
								<span class="ag-icono" aria-hidden="true"><?php echo ag_icono( 'telefono' ); // phpcs:ignore ?></span>
								<span class="ag-topbar__texto"><?php echo esc_html( $ag_telefono ); ?></span>
							</a>
						</li>
					<?php endif; ?>
				</ul>

				<?php if ( array_filter( $ag_redes ) ) : ?>
					<div class="ag-topbar__redes">
						<?php foreach ( $ag_redes as $red => $url ) : ?>
							<?php if ( $url ) : ?>
								<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( ucfirst( $red ) ); ?>">
									<?php echo ag_icono( $red ); // phpcs:ignore ?>
								</a>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<!-- 2. HERO ========================================================= -->
		<div class="ag-hero<?php echo is_front_page() ? '' : ' ag-hero--interior'; ?>" style="background-image: url('<?php echo esc_url( is_front_page() ? $ag_imagen : ag_imagen_seccion() ); ?>');">

			<!-- 3. NAVEGACIÓN: menú | logo | menú -->
			<nav id="ag-navegacion" class="ag-nav" aria-label="<?php esc_attr_e( 'Menú principal', 'antoniogarciaprats' ); ?>">
				<div class="ag-container">

					<div class="ag-nav__izquierda">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-izquierda',
								'menu_id'        => 'ag-menu-izquierda',
								'menu_class'     => 'ag-nav__menu',
								'container'      => false,
								'fallback_cb'    => false,
								'depth'          => 2,
							)
						);
						?>
					</div>

					<div class="ag-branding">
						<?php if ( has_custom_logo() ) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<a class="ag-monograma" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
								<span class="ag-monograma__circulo"><?php echo ag_icono( 'logo' ); // phpcs:ignore ?></span>
								<span class="ag-monograma__nombre"><?php bloginfo( 'name' ); ?></span>
							</a>
						<?php endif; ?>
					</div>

					<div class="ag-nav__derecha">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-derecha',
								'menu_id'        => 'ag-menu-derecha',
								'menu_class'     => 'ag-nav__menu',
								'container'      => false,
								'fallback_cb'    => false,
								'depth'          => 2,
							)
						);
						?>
					</div>

					<button class="ag-menu-toggle" aria-controls="ag-menu-izquierda ag-menu-derecha" aria-expanded="false">
						<span></span>
						<span class="screen-reader-text"><?php esc_html_e( 'Abrir menú', 'antoniogarciaprats' ); ?></span>
					</button>

				</div>
			</nav>

			<!-- 4. RÓTULO -->
			<div class="ag-hero__contenido">
				<div class="ag-container">
					<?php if ( is_front_page() ) : ?>

						<?php $ag_etiqueta = get_theme_mod( 'ag_etiqueta', 'Desarrollador · Formador · Creador digital' ); ?>
						<?php if ( $ag_etiqueta ) : ?>
							<span class="ag-hero__etiqueta"><?php echo esc_html( $ag_etiqueta ); ?></span>
						<?php endif; ?>

						<h1 class="ag-hero__eslogan">
							<?php echo wp_kses( get_theme_mod( 'ag_eslogan', 'Transformamos tu visión en <strong>innovación digital</strong>' ), array( 'strong' => array(), 'em' => array(), 'br' => array() ) ); ?>
						</h1>

						<div class="ag-hero__separador" aria-hidden="true"></div>

						<p class="ag-hero__subtitulo">
							<?php echo esc_html( get_theme_mod( 'ag_subtitulo', 'Desarrollo web a medida, programación de aplicaciones y formación tecnológica para profesionales y empresas.' ) ); ?>
						</p>

						<div class="ag-hero__botones">
							<?php
							$ag_btn1_txt = get_theme_mod( 'ag_btn1_texto', 'Ver servicios' );
							$ag_btn1_url = get_theme_mod( 'ag_btn1_url', '#servicios' );
							$ag_btn2_txt = get_theme_mod( 'ag_btn2_texto', 'Contactar' );
							$ag_btn2_url = get_theme_mod( 'ag_btn2_url', '#contacto' );
							?>
							<?php if ( $ag_btn1_txt ) : ?>
								<a class="ag-btn ag-btn--primario" href="<?php echo esc_url( $ag_btn1_url ); ?>"><?php echo esc_html( $ag_btn1_txt ); ?></a>
							<?php endif; ?>
							<?php if ( $ag_btn2_txt ) : ?>
								<a class="ag-btn ag-btn--secundario" href="<?php echo esc_url( $ag_btn2_url ); ?>"><?php echo esc_html( $ag_btn2_txt ); ?></a>
							<?php endif; ?>
						</div>

					<?php else : ?>

						<?php ag_migas_de_pan(); ?>

						<h1 class="ag-hero__eslogan"><?php echo esc_html( ag_titulo_seccion() ); ?></h1>
						<div class="ag-hero__separador" aria-hidden="true"></div>

						<?php $ag_subtitulo = ag_subtitulo_seccion(); ?>
						<?php if ( $ag_subtitulo ) : ?>
							<p class="ag-hero__subtitulo"><?php echo esc_html( $ag_subtitulo ); ?></p>
						<?php endif; ?>

					<?php endif; ?>
				</div>
			</div>

			<!-- 5. OLAS DE MAR (en todas las páginas; más bajas en las interiores) -->
			<div class="ag-olas" aria-hidden="true">
				<svg viewBox="0 24 150 28" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
					<defs>
						<linearGradient id="ag-ola-grad-1" x1="0" y1="0" x2="0" y2="1">
							<stop offset="0" stop-color="#9cc6ee" stop-opacity="0.15" />
							<stop offset="1" stop-color="#7fb2e0" stop-opacity="0.55" />
						</linearGradient>
						<linearGradient id="ag-ola-grad-2" x1="0" y1="0" x2="0" y2="1">
							<stop offset="0" stop-color="#5a95cc" stop-opacity="0.25" />
							<stop offset="1" stop-color="#437eb6" stop-opacity="0.75" />
						</linearGradient>
						<linearGradient id="ag-ola-grad-3" x1="0" y1="0" x2="0" y2="1">
							<stop offset="0" stop-color="#437eb6" stop-opacity="0.7" />
							<stop offset="0.6" stop-color="#437eb6" stop-opacity="1" />
						</linearGradient>
					</defs>
					<path class="ag-ola ag-ola--1" d="M-240 38c20.4 0 39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10s39.6-10 60-10s39.6 10 60 10V60H-240z" />
					<path class="ag-ola ag-ola--2" d="M-220 42c16.15 0 31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9s31.35-9 47.5-9s31.35 9 47.5 9V60H-220z" />
					<path class="ag-ola ag-ola--3" d="M-215 46c13.6 0 26.4-8 40-8s26.4 8 40 8s26.4-8 40-8s26.4 8 40 8s26.4-8 40-8s26.4 8 40 8s26.4-8 40-8s26.4 8 40 8s26.4-8 40-8s26.4 8 40 8s26.4-8 40-8s26.4 8 40 8s26.4-8 40-8s26.4 8 40 8V60H-215z" />
					<path class="ag-ola ag-ola--4" d="M-220 50c17 0 33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7s33-7 50-7s33 7 50 7V60H-220z" />
				</svg>
			</div>

		</div><!-- .ag-hero -->
	</header><!-- #masthead -->
