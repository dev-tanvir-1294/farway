/**
 * Adds the `js` class to the root element as early as possible.
 *
 * The class is used by the theme's CSS and JS to progressively enhance
 * the typewriter headline without showing unanimated text.
 */
( function () {
	'use strict';
	document.documentElement.classList.add( 'js' );
} )();
