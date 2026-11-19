/**
 * Pie de página – animación de entrada al hacer scroll.
 * Si el navegador no lo soporta o el usuario prefiere menos movimiento,
 * el pie se muestra directamente sin animación.
 */
( function () {
	'use strict';

	const pie = document.querySelector( '.ag-pie' );
	if ( ! pie || pie.dataset.agIniciado ) {
		return;
	}
	pie.dataset.agIniciado = 'true';

	const sinMovimiento = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	if ( sinMovimiento || ! ( 'IntersectionObserver' in window ) ) {
		return;
	}

	pie.classList.add( 'ag-pie--animar' );

	const objetivo = pie.querySelector( '.ag-redes' ) || pie;
	const observador = new IntersectionObserver(
		function ( entradas ) {
			entradas.forEach( function ( entrada ) {
				if ( entrada.isIntersecting ) {
					pie.classList.add( 'is-visible' );
					observador.disconnect();
				}
			} );
		},
		{ threshold: 0.2 }
	);

	observador.observe( objetivo );
} )();
