<?php
/**
 * Listado de artículos del blog con barra lateral.
 * Lo usan home.php (página Blog), archive.php (categorías, etiquetas…) y search.php.
 *
 * @package antoniogarciaprats
 */

?>
<main id="primary" class="site-main ag-inicio ag-blog-vista">
	<div class="ag-container ag-blog-vista__rejilla">

		<div class="ag-blog-vista__principal">

			<?php ag_blog_filtro_categorias(); ?>

			<?php if ( have_posts() ) : ?>

				<div class="ag-blog-vista__lista">
					<?php
					// En la primera página del blog, el último artículo se destaca en grande.
					$ag_destacar = is_home() && ! is_paged();
					$ag_orden    = 0;

					while ( have_posts() ) :
						the_post();
						ag_blog_tarjeta( $ag_destacar && 0 === $ag_orden, $ag_orden );
						$ag_orden++;
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination(
					array(
						'mid_size'           => 1,
						'prev_text'          => '← ' . __( 'Anteriores', 'antoniogarciaprats' ),
						'next_text'          => __( 'Siguientes', 'antoniogarciaprats' ) . ' →',
						'screen_reader_text' => __( 'Navegación de artículos', 'antoniogarciaprats' ),
					)
				);
				?>

			<?php else : ?>

				<div class="ag-blog-vacio">
					<h2><?php esc_html_e( 'No hay artículos que mostrar', 'antoniogarciaprats' ); ?></h2>
					<p>
						<?php
						if ( is_search() ) {
							esc_html_e( 'No he encontrado nada con esa búsqueda. Prueba con otras palabras.', 'antoniogarciaprats' );
						} else {
							esc_html_e( 'Todavía no hay publicaciones aquí. ¡Vuelve pronto!', 'antoniogarciaprats' );
						}
						?>
					</p>
					<?php ag_blog_buscador( 'ag-buscar-vacio' ); ?>
				</div>

			<?php endif; ?>
		</div>

		<?php ag_blog_sidebar(); ?>

	</div>
</main><!-- #primary -->
