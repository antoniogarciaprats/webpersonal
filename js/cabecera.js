/**
 * Cabecera profesional – menú móvil accesible.
 * Sustituye al navigation.js de Underscores.
 */
( function () {
	'use strict';

	const nav = document.getElementById( 'ag-navegacion' );
	if ( ! nav ) {
		return;
	}

	// Evita que el menú se abra y se cierre a la vez si el script se carga dos veces.
	if ( nav.dataset.agIniciado ) {
		return;
	}
	nav.dataset.agIniciado = 'true';

	const boton = nav.querySelector( '.ag-menu-toggle' );
	const menus = nav.querySelectorAll( '.ag-nav__menu' );

	// Si no hay menús asignados, ocultamos el botón.
	if ( ! boton || ! menus.length ) {
		if ( boton ) {
			boton.style.display = 'none';
		}
		if ( window.console ) {
			console.warn( 'Cabecera: no hay menús asignados. Ve a Apariencia › Menús › Gestionar ubicaciones.' );
		}
		return;
	}

	const etiqueta = boton.querySelector( '.screen-reader-text' );

	function setAbierto( abierto ) {
		nav.classList.toggle( 'is-open', abierto );
		boton.setAttribute( 'aria-expanded', abierto ? 'true' : 'false' );
		if ( etiqueta ) {
			etiqueta.textContent = abierto ? 'Cerrar menú' : 'Abrir menú';
		}
	}

	boton.addEventListener( 'click', function () {
		setAbierto( ! nav.classList.contains( 'is-open' ) );
	} );

	// Cerrar con la tecla Escape.
	document.addEventListener( 'keydown', function ( e ) {
		if ( 'Escape' === e.key && nav.classList.contains( 'is-open' ) ) {
			setAbierto( false );
			boton.focus();
		}
	} );

	// Cerrar al pulsar fuera del menú.
	document.addEventListener( 'click', function ( e ) {
		if ( nav.classList.contains( 'is-open' ) && ! nav.contains( e.target ) ) {
			setAbierto( false );
		}
	} );

	// Cerrar al pasar a escritorio.
	window.matchMedia( '(min-width: 992px)' ).addEventListener( 'change', function ( mq ) {
		if ( mq.matches ) {
			setAbierto( false );
		}
	} );
} )();
