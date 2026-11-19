<?php
/**
 * Template Name: Contacto
 * Template Post Type: page
 *
 * Página de contacto sin formularios ni mapas:
 *  1. Presentación + tarjeta de disponibilidad
 *  2. Canales: correo, teléfono, WhatsApp y redes (con botones de copiar)
 *  3. ¿En qué puedo ayudarte? (botones que abren el correo ya redactado)
 *  4. Cómo trabajamos (3 pasos)
 *  5. Preguntas frecuentes
 *
 * Textos en inc/contacto.php → ag_contacto_datos().
 *
 * @package antoniogarciaprats
 */

get_header();

$ag       = ag_contacto_datos();
$ag_tags  = array( 'strong' => array() );
$ag_email = get_theme_mod( 'ag_email', 'info@antoniogarciaprats.es' );
$ag_tel   = get_theme_mod( 'ag_telefono', '+34 600 000 000' );
$ag_wa    = get_theme_mod( 'ag_whatsapp', '' );
$ag_wa    = $ag_wa ? $ag_wa : $ag_tel;
$ag_redes = ag_redes_sociales();
?>

<main id="primary" class="site-main ag-inicio ag-contacto">

	<!-- =====================================================================
	     1. PRESENTACIÓN + DISPONIBILIDAD
	     ===================================================================== -->
	<section class="ag-seccion ag-contacto-intro">
		<div class="ag-container ag-contacto-intro__rejilla">

			<div class="ag-contacto-intro__texto" data-ag-revelar="izquierda">
				<span class="ag-etiqueta"><?php echo esc_html( $ag['intro']['etiqueta'] ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( $ag['intro']['titulo'], $ag_tags ); ?></h2>
				<p class="ag-entradilla"><?php echo esc_html( $ag['intro']['texto'] ); ?></p>
				<ul class="ag-lista-check ag-contacto-intro__puntos">
					<?php foreach ( $ag['intro']['puntos'] as $ag_punto ) : ?>
						<li><?php echo ag_icono_inicio( 'check' ); // phpcs:ignore ?><?php echo esc_html( $ag_punto ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>

			<aside class="ag-disponibilidad" data-ag-revelar="derecha">
				<?php if ( get_theme_mod( 'ag_disponible', true ) ) : ?>
					<span class="ag-disponibilidad__estado"><?php esc_html_e( 'Disponible para nuevos proyectos', 'antoniogarciaprats' ); ?></span>
				<?php endif; ?>

				<div class="ag-disponibilidad__persona">
					<span class="ag-disponibilidad__foto">
						<?php $ag_foto = function_exists( 'ag_foto_quien_soy' ) ? ag_foto_quien_soy() : ''; ?>
						<?php if ( $ag_foto ) : ?>
							<img src="<?php echo esc_url( $ag_foto ); ?>" alt="" width="72" height="72" loading="lazy">
						<?php else : ?>
							<?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-contacto', ag_icono( 'logo' ) ); // phpcs:ignore ?>
						<?php endif; ?>
					</span>
					<span>
						<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
						<small><?php esc_html_e( 'Formador · Desarrollador · Emprendedor', 'antoniogarciaprats' ); ?></small>
					</span>
				</div>

				<ul class="ag-disponibilidad__datos">
					<?php
					$ag_datos = array(
						'reloj' => get_theme_mod( 'ag_horario', 'Lunes a viernes · 9:00 – 18:00' ),
						'rayo'  => get_theme_mod( 'ag_respuesta', 'Respondo en menos de 24 h laborables' ),
						'lugar' => get_theme_mod( 'ag_ubicacion', 'España · Online y presencial' ),
					);
					foreach ( $ag_datos as $ag_icono => $ag_texto ) :
						if ( ! $ag_texto ) {
							continue;
						}
						?>
						<li><span><?php echo ag_icono_contacto( $ag_icono ); // phpcs:ignore ?></span><?php echo esc_html( $ag_texto ); ?></li>
					<?php endforeach; ?>
				</ul>
			</aside>
		</div>

		<!-- =================================================================
		     2. CANALES DE CONTACTO
		     ================================================================= -->
		<div class="ag-container">
			<div class="ag-canales">

				<?php if ( $ag_email ) : ?>
					<article class="ag-canal" data-ag-revelar style="--d: 0s; --color: #437eb6;">
						<span class="ag-canal__icono"><?php echo ag_icono( 'email' ); // phpcs:ignore ?></span>
						<span class="ag-canal__etiqueta"><?php esc_html_e( 'Correo electrónico', 'antoniogarciaprats' ); ?></span>
						<strong class="ag-canal__valor ag-canal__valor--email"><?php echo str_replace( '@', '@<wbr>', esc_html( $ag_email ) ); // phpcs:ignore ?></strong>
						<p><?php esc_html_e( 'Ideal para propuestas, presupuestos y consultas detalladas.', 'antoniogarciaprats' ); ?></p>
						<div class="ag-canal__acciones">
							<a class="ag-canal__boton" href="<?php echo esc_attr( ag_contacto_mailto( $ag_email, 'Consulta desde la web' ) ); ?>"><?php esc_html_e( 'Escribir', 'antoniogarciaprats' ); ?></a>
							<button type="button" class="ag-canal__copiar" data-ag-copiar-texto="<?php echo esc_attr( antispambot( $ag_email ) ); ?>" aria-label="<?php esc_attr_e( 'Copiar correo', 'antoniogarciaprats' ); ?>">
								<?php echo ag_icono_contacto( 'copiar' ); // phpcs:ignore ?><span class="ag-canal__aviso" role="status"></span>
							</button>
						</div>
					</article>
				<?php endif; ?>

				<?php if ( $ag_tel ) : ?>
					<article class="ag-canal" data-ag-revelar style="--d: 0.1s; --color: #7a5cd6;">
						<span class="ag-canal__icono"><?php echo ag_icono( 'telefono' ); // phpcs:ignore ?></span>
						<span class="ag-canal__etiqueta"><?php esc_html_e( 'Teléfono', 'antoniogarciaprats' ); ?></span>
						<strong class="ag-canal__valor"><?php echo esc_html( $ag_tel ); ?></strong>
						<p><?php esc_html_e( 'Para hablar directamente y resolver dudas rápidas.', 'antoniogarciaprats' ); ?></p>
						<div class="ag-canal__acciones">
							<a class="ag-canal__boton" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $ag_tel ) ); ?>"><?php esc_html_e( 'Llamar', 'antoniogarciaprats' ); ?></a>
							<button type="button" class="ag-canal__copiar" data-ag-copiar-texto="<?php echo esc_attr( $ag_tel ); ?>" aria-label="<?php esc_attr_e( 'Copiar teléfono', 'antoniogarciaprats' ); ?>">
								<?php echo ag_icono_contacto( 'copiar' ); // phpcs:ignore ?><span class="ag-canal__aviso" role="status"></span>
							</button>
						</div>
					</article>
				<?php endif; ?>

				<?php if ( $ag_wa ) : ?>
					<article class="ag-canal" data-ag-revelar style="--d: 0.2s; --color: #25b562;">
						<span class="ag-canal__icono"><?php echo ag_icono_contacto( 'whatsapp' ); // phpcs:ignore ?></span>
						<span class="ag-canal__etiqueta">WhatsApp</span>
						<strong class="ag-canal__valor"><?php esc_html_e( 'Chatea conmigo', 'antoniogarciaprats' ); ?></strong>
						<p><?php esc_html_e( 'La forma más rápida de contactar desde el móvil.', 'antoniogarciaprats' ); ?></p>
						<div class="ag-canal__acciones">
							<a class="ag-canal__boton" href="<?php echo esc_url( 'https://wa.me/' . preg_replace( '/[^0-9]/', '', $ag_wa ) . '?text=' . rawurlencode( 'Hola Antonio, te escribo desde tu web.' ) ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Abrir chat', 'antoniogarciaprats' ); ?></a>
						</div>
					</article>
				<?php endif; ?>

				<article class="ag-canal ag-canal--redes" data-ag-revelar style="--d: 0.3s; --color: #e8566c;">
					<span class="ag-canal__icono"><?php echo ag_icono_contacto( 'redes' ); // phpcs:ignore ?></span>
					<span class="ag-canal__etiqueta"><?php esc_html_e( 'Redes sociales', 'antoniogarciaprats' ); ?></span>
					<strong class="ag-canal__valor"><?php esc_html_e( 'Sígueme', 'antoniogarciaprats' ); ?></strong>
					<p><?php esc_html_e( 'Contenido sobre tecnología, programación e IA.', 'antoniogarciaprats' ); ?></p>
					<?php if ( $ag_redes ) : ?>
						<ul class="ag-canal__redes">
							<?php foreach ( $ag_redes as $ag_red => $ag_dato ) : ?>
								<li>
									<a class="ag-canal__red ag-canal__red--<?php echo esc_attr( $ag_red ); ?>" href="<?php echo esc_url( $ag_dato[1] ); ?>" target="_blank" rel="noopener me" aria-label="<?php echo esc_attr( $ag_dato[0] ); ?>">
										<?php echo ag_icono_red( $ag_red ); // phpcs:ignore ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php else : ?>
						<p class="ag-canal__aviso-config"><?php esc_html_e( 'Añade tus redes en Personalizar › Cabecera profesional y Pie de página.', 'antoniogarciaprats' ); ?></p>
					<?php endif; ?>
				</article>
			</div>
		</div>
	</section>

	<!-- =====================================================================
	     3. ¿EN QUÉ PUEDO AYUDARTE?
	     ===================================================================== -->
	<?php if ( $ag_email ) : ?>
		<section class="ag-seccion ag-temas">
			<div class="ag-container">
				<header class="ag-cabecera-seccion" data-ag-revelar>
					<span class="ag-etiqueta"><?php esc_html_e( 'Ve al grano', 'antoniogarciaprats' ); ?></span>
					<h2 class="ag-titulo"><?php echo wp_kses( __( '¿En qué puedo <strong>ayudarte</strong>?', 'antoniogarciaprats' ), $ag_tags ); ?></h2>
					<p class="ag-entradilla"><?php esc_html_e( 'Elige un tema y se abrirá tu correo con el mensaje ya preparado. Solo tienes que completarlo y enviarlo.', 'antoniogarciaprats' ); ?></p>
				</header>

				<div class="ag-temas__rejilla">
					<?php foreach ( $ag['temas'] as $ag_i => $ag_tema ) : ?>
						<a class="ag-tema" href="<?php echo esc_attr( ag_contacto_mailto( $ag_email, $ag_tema[2] ) ); ?>" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.06 ); ?>s;">
							<span class="ag-tema__icono"><?php echo ag_icono_inicio( $ag_tema[0] ); // phpcs:ignore ?></span>
							<span class="ag-tema__texto"><?php echo esc_html( $ag_tema[1] ); ?></span>
							<span class="ag-tema__flecha" aria-hidden="true"><?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?></span>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<!-- =====================================================================
	     4. CÓMO TRABAJAMOS
	     ===================================================================== -->
	<section class="ag-seccion ag-pasos">
		<div class="ag-container">
			<header class="ag-cabecera-seccion" data-ag-revelar>
				<span class="ag-etiqueta"><?php esc_html_e( 'Así de sencillo', 'antoniogarciaprats' ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( __( 'Cómo <strong>trabajamos</strong>', 'antoniogarciaprats' ), $ag_tags ); ?></h2>
			</header>

			<ol class="ag-pasos__lista">
				<?php foreach ( $ag['pasos'] as $ag_i => $ag_paso ) : ?>
					<li class="ag-paso" data-ag-revelar style="--d: <?php echo esc_attr( $ag_i * 0.15 ); ?>s;">
						<span class="ag-paso__numero"><?php echo (int) $ag_i + 1; ?></span>
						<h3><?php echo esc_html( $ag_paso[0] ); ?></h3>
						<p><?php echo esc_html( $ag_paso[1] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</section>

	<!-- =====================================================================
	     5. PREGUNTAS FRECUENTES
	     ===================================================================== -->
	<section class="ag-seccion ag-faq">
		<div class="ag-container ag-faq__rejilla">
			<header class="ag-faq__cabecera" data-ag-revelar>
				<span class="ag-etiqueta"><?php esc_html_e( 'Dudas habituales', 'antoniogarciaprats' ); ?></span>
				<h2 class="ag-titulo"><?php echo wp_kses( __( 'Preguntas <strong>frecuentes</strong>', 'antoniogarciaprats' ), $ag_tags ); ?></h2>
				<p><?php esc_html_e( '¿No encuentras la respuesta? Escríbeme y te la doy personalmente.', 'antoniogarciaprats' ); ?></p>
				<?php if ( $ag_email ) : ?>
					<a class="ag-boton" href="<?php echo esc_attr( ag_contacto_mailto( $ag_email, 'Tengo una pregunta' ) ); ?>"><?php esc_html_e( 'Hacer una pregunta', 'antoniogarciaprats' ); ?> <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?></a>
				<?php endif; ?>
			</header>

			<div class="ag-faq__lista" data-ag-revelar style="--d: 0.15s;">
				<?php foreach ( $ag['faq'] as $ag_i => $ag_pregunta ) : ?>
					<details class="ag-pregunta"<?php echo 0 === $ag_i ? ' open' : ''; ?>>
						<summary><?php echo esc_html( $ag_pregunta[0] ); ?><span class="ag-pregunta__mas" aria-hidden="true"></span></summary>
						<div class="ag-pregunta__respuesta"><p><?php echo esc_html( $ag_pregunta[1] ); ?></p></div>
					</details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

</main><!-- #primary -->

<?php
get_footer();
