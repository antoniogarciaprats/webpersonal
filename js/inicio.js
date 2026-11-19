/**
 * Página de inicio – animaciones.
 *  1. Aparición de elementos al hacer scroll   [data-ag-revelar]
 *  2. Contadores animados                      [data-ag-contador]
 *  3. Parallax                                 [data-ag-parallax="velocidad"]
 *  4. Inclinación 3D de las tarjetas de servicios
 * Respeta la preferencia "reducir movimiento" del sistema.
 */
( function () {
	'use strict';

	const raiz = document.documentElement;
	if ( raiz.dataset.agInicio ) {
		return; // Evita doble inicialización si el script se carga dos veces.
	}
	raiz.dataset.agInicio = 'true';

	const sinMovimiento = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	const soportaObserver = 'IntersectionObserver' in window;

	/* ------------------------------------------------------------------
	 * 1. Aparición al hacer scroll
	 * ------------------------------------------------------------------ */
	const revelables = document.querySelectorAll( '[data-ag-revelar]' );

	if ( ! sinMovimiento && soportaObserver && revelables.length ) {
		raiz.classList.add( 'ag-js' );

		const revelar = new IntersectionObserver(
			function ( entradas ) {
				entradas.forEach( function ( entrada ) {
					if ( ! entrada.isIntersecting ) {
						return;
					}
					const el = entrada.target;
					el.classList.add( 'is-visible' );
					revelar.unobserve( el );

					// Al terminar, se quitan los estilos de aparición para que
					// los efectos :hover de cada tarjeta funcionen sin retrasos.
					const retraso = parseFloat( getComputedStyle( el ).getPropertyValue( '--d' ) ) || 0;
					window.setTimeout( function () {
						el.removeAttribute( 'data-ag-revelar' );
						el.classList.remove( 'is-visible' );
					}, ( retraso + 1.8 ) * 1000 );
				} );
			},
			{ threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
		);

		revelables.forEach( function ( el ) {
			revelar.observe( el );
		} );
	}

	/* ------------------------------------------------------------------
	 * 2. Contadores
	 * ------------------------------------------------------------------ */
	const contadores = document.querySelectorAll( '[data-ag-contador]' );
	const formato = new Intl.NumberFormat( 'es-ES' );

	function animarContador( el ) {
		const final = parseInt( el.dataset.agContador, 10 ) || 0;
		const duracion = 1800;
		const inicio = performance.now();

		function paso( ahora ) {
			const t = Math.min( ( ahora - inicio ) / duracion, 1 );
			const suavizado = 1 - Math.pow( 1 - t, 3 );
			el.textContent = formato.format( Math.round( final * suavizado ) );
			if ( t < 1 ) {
				window.requestAnimationFrame( paso );
			}
		}
		window.requestAnimationFrame( paso );
	}

	if ( ! sinMovimiento && soportaObserver && contadores.length ) {
		const observarContador = new IntersectionObserver(
			function ( entradas ) {
				entradas.forEach( function ( entrada ) {
					if ( entrada.isIntersecting ) {
						animarContador( entrada.target );
						observarContador.unobserve( entrada.target );
					}
				} );
			},
			{ threshold: 0.6 }
		);

		contadores.forEach( function ( el ) {
			el.textContent = '0';
			observarContador.observe( el );
		} );
	}

	/* ------------------------------------------------------------------
	 * 3. Parallax
	 * ------------------------------------------------------------------ */
	const capas = Array.prototype.slice.call( document.querySelectorAll( '[data-ag-parallax]' ) );

	if ( ! sinMovimiento && capas.length ) {
		let pendiente = false;

		function actualizarParallax() {
			const alto = window.innerHeight;

			capas.forEach( function ( capa ) {
				// Los fondos se mueven según su sección; los elementos de contenido
				// (con data-ag-parallax-limite) según su propia posición y con tope.
				const limite = parseFloat( capa.dataset.agParallaxLimite ) || 0;
				const referencia = limite ? capa : ( capa.closest( 'section' ) || capa.parentElement );
				const caja = referencia.getBoundingClientRect();

				if ( caja.bottom < -300 || caja.top > alto + 300 ) {
					return; // Fuera de pantalla: no se calcula.
				}

				const velocidad = parseFloat( capa.dataset.agParallax ) || 0;
				let desplazamiento = ( caja.top + caja.height / 2 - alto / 2 ) * -velocidad;
				if ( limite ) {
					desplazamiento = Math.max( -limite, Math.min( limite, desplazamiento ) );
				}
				capa.style.setProperty( '--ag-py', desplazamiento.toFixed( 1 ) + 'px' );
			} );

			pendiente = false;
		}

		function alDesplazar() {
			if ( ! pendiente ) {
				pendiente = true;
				window.requestAnimationFrame( actualizarParallax );
			}
		}

		window.addEventListener( 'scroll', alDesplazar, { passive: true } );
		window.addEventListener( 'resize', alDesplazar );
		actualizarParallax();
	}

	/* ------------------------------------------------------------------
	 * 4. Inclinación 3D de las tarjetas (solo con ratón)
	 * ------------------------------------------------------------------ */
	const conRaton = window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches;

	if ( ! sinMovimiento && conRaton ) {
		document.querySelectorAll( '.ag-servicio' ).forEach( function ( tarjeta ) {
			const marco = tarjeta.querySelector( '.ag-servicio__marco' );
			if ( ! marco ) {
				return;
			}

			tarjeta.addEventListener( 'mousemove', function ( e ) {
				const caja = tarjeta.getBoundingClientRect();
				const x = ( e.clientX - caja.left ) / caja.width - 0.5;
				const y = ( e.clientY - caja.top ) / caja.height - 0.5;
				marco.style.setProperty( '--ry', ( x * 12 ).toFixed( 2 ) + 'deg' );
				marco.style.setProperty( '--rx', ( y * -12 ).toFixed( 2 ) + 'deg' );
			} );

			tarjeta.addEventListener( 'mouseleave', function () {
				marco.style.setProperty( '--rx', '0deg' );
				marco.style.setProperty( '--ry', '0deg' );
			} );
		} );
	}
} )();
