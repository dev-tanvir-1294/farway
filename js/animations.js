/**
 * Farway animations: hero typewriter and scroll reveals.
 *
 * Uses native IntersectionObserver and CSS transitions so the theme does not
 * need a third-party animation library. All motion is disabled when the user
 * prefers reduced motion.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {
		var prefersReduced = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		// Ensure headline characters are visible when motion is disabled or JS
		// enhancements fail to run for any reason.
		if ( prefersReduced ) {
			document.querySelectorAll( '.headline .tw-char' ).forEach( function ( el ) {
				el.style.opacity = '1';
			} );
			revealStatic();
			return;
		}

		// ----- Hero: typewriter headline -----
		var headline = document.querySelector( '.headline' );
		if ( headline ) {
			var chars = headline.querySelectorAll( '.tw-char' );
			var lines = headline.querySelectorAll( '.tw-line' );
			var lastLine = lines.length ? lines[ lines.length - 1 ] : headline;

			chars.forEach( function ( el ) {
				el.style.opacity = '0';
			} );

			var cursor = document.createElement( 'span' );
			cursor.className = 'tw-cursor';
			cursor.setAttribute( 'aria-hidden', 'true' );
			lastLine.appendChild( cursor );

			window.setTimeout( function () {
				chars.forEach( function ( el, i ) {
					el.style.transition = 'opacity 0.2s ease, transform 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
					el.style.transform = 'translateY(0.35em)';
					window.setTimeout( function () {
						el.style.opacity = '1';
						el.style.transform = 'translateY(0)';
					}, 220 + i * 18 );
				} );
			}, 200 );
		}

		// ----- Hero intro (non-headline elements) -----
		var heroItems = document.querySelectorAll( '.stage .eyebrow, .stage .subcopy, .stage .stat, .stage .pass-wrap' );
		heroItems.forEach( function ( el, i ) {
			el.style.opacity = '0';
			el.style.transform = 'translateY(24px)';
			el.style.transition = 'opacity 0.9s cubic-bezier(0.4, 0, 0.2, 1), transform 0.9s cubic-bezier(0.4, 0, 0.2, 1)';
			window.setTimeout( function () {
				el.style.opacity = '1';
				el.style.transform = 'translateY(0)';
			}, 350 + i * 120 );
		} );

		// ----- Scroll reveals -----
		var revealTargets = document.querySelectorAll(
			'.section:not(.search-results) .section-head, ' +
			'.section:not(.search-results) .section-inner .card-grid > *, ' +
			'.faq-list .faq-item, ' +
			'.contact-grid > *, ' +
			'.content-inner > h1, .content-inner > p, .breadcrumb, .trip-hero-media, .trip-detail-grid > *, ' +
			'.farway-content .card-grid > *, ' +
			'.footer-inner'
		);

		if ( 'IntersectionObserver' in window && revealTargets.length ) {
			var observer = new IntersectionObserver( function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-revealed' );
						observer.unobserve( entry.target );
					}
				} );
			}, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' } );

			revealTargets.forEach( function ( el ) {
				el.classList.add( 'reveal-item' );
				observer.observe( el );
			} );
		} else {
			revealStatic();
		}
	} );

	function revealStatic() {
		document.querySelectorAll( '.headline .tw-char, .reveal-item' ).forEach( function ( el ) {
			el.style.opacity = '1';
			el.style.transform = 'none';
		} );
	}
} )();
