/**
 * Contacto – botones "copiar" (correo y teléfono).
 */
( function () {
	'use strict';

	if ( document.documentElement.dataset.agContacto ) {
		return;
	}
	document.documentElement.dataset.agContacto = 'true';

	function copiar( texto ) {
		if ( navigator.clipboard && window.isSecureContext ) {
			return navigator.clipboard.writeText( texto );
		}
		// Alternativa para http:// (por ejemplo, localhost).
		return new Promise( function ( resolver, rechazar ) {
			const campo = document.createElement( 'textarea' );
			campo.value = texto;
			campo.setAttribute( 'readonly', '' );
			campo.style.position = 'absolute';
			campo.style.left = '-9999px';
			document.body.appendChild( campo );
			campo.select();
			try {
				document.execCommand( 'copy' ) ? resolver() : rechazar();
			} catch ( e ) {
				rechazar( e );
			}
			document.body.removeChild( campo );
		} );
	}

	document.querySelectorAll( '[data-ag-copiar-texto]' ).forEach( function ( boton ) {
		const aviso = boton.querySelector( '.ag-canal__aviso' );

		boton.addEventListener( 'click', function () {
			copiar( boton.dataset.agCopiarTexto ).then(
				function () { mostrar( '¡Copiado!' ); },
				function () { mostrar( 'No se pudo copiar' ); }
			);
		} );

		function mostrar( texto ) {
			if ( ! aviso ) {
				return;
			}
			aviso.textContent = texto;
			window.setTimeout( function () {
				aviso.textContent = '';
			}, 2000 );
		}
	} );
} )();
