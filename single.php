<?php
/**
 * Artículo individual del blog.
 *
 * La cabecera (título, fecha e imagen destacada de fondo) la genera header.php.
 * Aquí: datos del artículo, contenido, compartir, autor, navegación,
 * artículos relacionados, comentarios y barra lateral.
 *
 * @package antoniogarciaprats
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<div class="ag-progreso" aria-hidden="true"><span></span></div>

	<main id="primary" class="site-main ag-inicio ag-blog-vista ag-blog-vista--articulo">
		<div class="ag-container ag-blog-vista__rejilla">

			<article id="post-<?php the_ID(); ?>" <?php post_class( 'ag-articulo' ); ?>>

				<!-- Datos del artículo -->
				<div class="ag-articulo__meta">
					<span class="ag-articulo__autor">
						<span class="ag-articulo__avatar"><?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-meta', ag_icono( 'logo' ) ); // phpcs:ignore ?></span>
						<span>
							<strong><?php the_author(); ?></strong>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						</span>
					</span>
					<span class="ag-articulo__datos">
						<?php ag_blog_categoria(); ?>
						<span class="ag-articulo__lectura"><?php echo esc_html( ag_tiempo_lectura() ); ?></span>
					</span>
				</div>

				<!-- Contenido -->
				<div class="ag-articulo__contenido entry-content">
					<?php
					the_content();
					wp_link_pages(
						array(
							'before' => '<div class="page-links">' . esc_html__( 'Páginas:', 'antoniogarciaprats' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<!-- Etiquetas -->
				<?php $ag_etiquetas = get_the_tags(); ?>
				<?php if ( $ag_etiquetas ) : ?>
					<ul class="ag-articulo__etiquetas">
						<?php foreach ( $ag_etiquetas as $ag_etiqueta ) : ?>
							<li><a href="<?php echo esc_url( get_tag_link( $ag_etiqueta->term_id ) ); ?>">#<?php echo esc_html( $ag_etiqueta->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<!-- Compartir -->
				<?php ag_blog_compartir(); ?>

				<!-- Autor -->
				<div class="ag-autor">
					<?php $ag_foto = function_exists( 'ag_foto_quien_soy' ) ? ag_foto_quien_soy() : ''; ?>
					<span class="ag-autor__foto">
						<?php if ( $ag_foto ) : ?>
							<img src="<?php echo esc_url( $ag_foto ); ?>" alt="" width="96" height="96" loading="lazy">
						<?php else : ?>
							<?php echo str_replace( 'ag-logo-hueco', 'ag-logo-hueco-autor', ag_icono( 'logo' ) ); // phpcs:ignore ?>
						<?php endif; ?>
					</span>
					<div>
						<span class="ag-autor__etiqueta"><?php esc_html_e( 'Escrito por', 'antoniogarciaprats' ); ?></span>
						<strong class="ag-autor__nombre"><?php the_author(); ?></strong>
						<p>
							<?php
							$ag_bio = get_the_author_meta( 'description' );
							echo esc_html( $ag_bio ? $ag_bio : __( 'Formador FPE, desarrollador web y programador. Me apasiona la tecnología y comparto lo que aprendo sobre programación, desarrollo web e inteligencia artificial.', 'antoniogarciaprats' ) );
							?>
						</p>
						<a class="ag-autor__enlace" href="<?php echo esc_url( home_url( '/sobre-mi/' ) ); ?>"><?php esc_html_e( 'Más sobre mí', 'antoniogarciaprats' ); ?> <?php echo ag_icono_inicio( 'flecha' ); // phpcs:ignore ?></a>
					</div>
				</div>

				<!-- Anterior / siguiente -->
				<?php
				$ag_anterior  = get_previous_post();
				$ag_siguiente = get_next_post();
				?>
				<?php if ( $ag_anterior || $ag_siguiente ) : ?>
					<nav class="ag-articulo__nav" aria-label="<?php esc_attr_e( 'Más artículos', 'antoniogarciaprats' ); ?>">
						<?php if ( $ag_anterior ) : ?>
							<a class="ag-articulo__nav-enlace ag-articulo__nav-enlace--anterior" href="<?php echo esc_url( get_permalink( $ag_anterior ) ); ?>">
								<small>← <?php esc_html_e( 'Artículo anterior', 'antoniogarciaprats' ); ?></small>
								<strong><?php echo esc_html( get_the_title( $ag_anterior ) ); ?></strong>
							</a>
						<?php endif; ?>
						<?php if ( $ag_siguiente ) : ?>
							<a class="ag-articulo__nav-enlace ag-articulo__nav-enlace--siguiente" href="<?php echo esc_url( get_permalink( $ag_siguiente ) ); ?>">
								<small><?php esc_html_e( 'Artículo siguiente', 'antoniogarciaprats' ); ?> →</small>
								<strong><?php echo esc_html( get_the_title( $ag_siguiente ) ); ?></strong>
							</a>
						<?php endif; ?>
					</nav>
				<?php endif; ?>

				<!-- Relacionados (misma categoría) -->
				<?php
				$ag_cats         = wp_get_post_categories( get_the_ID() );
				$ag_relacionados = new WP_Query(
					array(
						'category__in'        => $ag_cats,
						'post__not_in'        => array( get_the_ID() ),
						'posts_per_page'      => 2,
						'ignore_sticky_posts' => true,
						'no_found_rows'       => true,
					)
				);
				?>
				<?php if ( $ag_relacionados->have_posts() ) : ?>
					<section class="ag-relacionados">
						<h2 class="ag-relacionados__titulo"><?php esc_html_e( 'Te puede interesar', 'antoniogarciaprats' ); ?></h2>
						<div class="ag-relacionados__rejilla">
							<?php
							$ag_orden = 0;
							while ( $ag_relacionados->have_posts() ) :
								$ag_relacionados->the_post();
								ag_blog_tarjeta( false, $ag_orden++ );
							endwhile;
							?>
						</div>
					</section>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>

				<!-- Comentarios -->
				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</article>

			<?php ag_blog_sidebar(); ?>

		</div>
	</main><!-- #primary -->

	<?php
endwhile;

get_footer();
