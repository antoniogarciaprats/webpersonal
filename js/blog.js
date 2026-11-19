/**
 * Blog – barra de progreso de lectura y botón "copiar enlace".
 */
( function () {
	'use strict';

	if ( document.documentElement.dataset.agBlog ) {
		return; // Evita la doble inicialización.
	}
	document.documentElement.dataset.agBlog = 'true';

	/* 1. Progreso de lectura (solo en artículos) */
	const barra = document.querySelector( '.ag-progreso' );
	const articulo = document.querySelector( '.ag-articulo__contenido' );

	if ( barra && articulo ) {
		let pendiente = false;

		const actualizar = function () {
			const caja = articulo.getBoundingClientRect();
			const recorrido = caja.height - window.innerHeight * 0.5;
			const leido = Math.min( Math.max( ( window.innerHeight * 0.5 - caja.top ) / recorrido, 0 ), 1 );
			barra.style.setProperty( '--ag-progreso', leido.toFixed( 4 ) );
			pendiente = false;
		};

		window.addEventListener( 'scroll', function () {
			if ( ! pendiente ) {
				pendiente = true;
				window.requestAnimationFrame( actualizar );
			}
		}, { passive: true } );
		window.addEventListener( 'resize', actualizar );
		actualizar();
	}

	/* 2. Copiar enlace */
	document.querySelectorAll( '[data-ag-copiar]' ).forEach( function ( boton ) {
		const aviso = boton.querySelector( '.ag-compartir__aviso' );

		boton.addEventListener( 'click', function () {
			const enlace = boton.dataset.agCopiar;
			const mostrar = function ( texto ) {
				if ( aviso ) {
					aviso.textContent = texto;
					window.setTimeout( function () {
						aviso.textContent = '';
					}, 2000 );
				}
			};

			if ( navigator.clipboard && window.isSecureContext ) {
				navigator.clipboard.writeText( enlace ).then(
					function () { mostrar( '¡Enlace copiado!' ); },
					function () { mostrar( 'No se pudo copiar' ); }
				);
			} else {
				// Alternativa para http:// (por ejemplo, en localhost sin certificado).
				const campo = document.createElement( 'textarea' );
				campo.value = enlace;
				campo.setAttribute( 'readonly', '' );
				campo.style.position = 'absolute';
				campo.style.left = '-9999px';
				document.body.appendChild( campo );
				campo.select();
				try {
					document.execCommand( 'copy' );
					mostrar( '¡Enlace copiado!' );
				} catch ( e ) {
					mostrar( 'No se pudo copiar' );
				}
				document.body.removeChild( campo );
			}
		} );
	} );
} )();
