/**
 * Farway hero interactions: barcode generation, traveler stepper,
 * split-flap stat count-up, mobile nav, and inquiry form.
 */
( function () {
	'use strict';

	document.addEventListener( 'DOMContentLoaded', function () {

		// Scroll to search results when a search is active.
		var results = document.getElementById( 'search-results' );
		if ( results ) {
			results.scrollIntoView( { behavior: 'smooth', block: 'start' } );
		}

		// Barcode generation.
		var barcode = document.getElementById( 'barcode' );
		if ( barcode ) {
			for ( var i = 0; i < 34; i++ ) {
				var bar = document.createElement( 'span' );
				var w = Math.random() > 0.75 ? 3 : 1.5;
				var h = 12 + Math.random() * 14;
				bar.style.width = w + 'px';
				bar.style.height = h + 'px';
				barcode.appendChild( bar );
			}
		}

		// Traveler stepper.
		var labelEl = document.getElementById( 'travelerLabel' );
		var inputEl = document.getElementById( 'travelersInput' );
		var plusBtn = document.getElementById( 'plus' );
		var minusBtn = document.getElementById( 'minus' );
		var count = inputEl ? parseInt( inputEl.value, 10 ) : 2;

		function updateLabel() {
			if ( labelEl ) {
				labelEl.textContent = count + ( count === 1 ? ' adult' : ' adults' );
			}
			if ( inputEl ) {
				inputEl.value = count;
			}
		}

		updateLabel();

		if ( plusBtn ) {
			plusBtn.addEventListener( 'click', function () {
				if ( count < 9 ) {
					count++;
					updateLabel();
				}
			} );
		}
		if ( minusBtn ) {
			minusBtn.addEventListener( 'click', function () {
				if ( count > 1 ) {
					count--;
					updateLabel();
				}
			} );
		}

		// Split-flap style stat count-up on load.
		var flips = document.querySelectorAll( '.flip' );
		flips.forEach( function ( el ) {
			var target = parseInt( el.getAttribute( 'data-target' ), 10 );
			var duration = 900;
			var start = performance.now();

			function tick( now ) {
				var p = Math.min( 1, ( now - start ) / duration );
				var eased = 1 - Math.pow( 1 - p, 3 );
				el.textContent = Math.round( eased * target );
				if ( p < 1 ) {
					requestAnimationFrame( tick );
				}
			}
			requestAnimationFrame( tick );
		} );

		// Mobile nav toggle.
		var toggle = document.querySelector( '.nav-toggle' );
		var menuWrap = document.querySelector( '.nav-menu-wrap' );
		if ( toggle && menuWrap ) {
			toggle.addEventListener( 'click', function () {
				var open = menuWrap.classList.toggle( 'open' );
				toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			} );
		}

		// Custom route pickers.
		function initRoutePicker( triggerId, optionsId, codeId, cityId, inputId ) {
			var trigger = document.getElementById( triggerId );
			var options = document.getElementById( optionsId );
			var codeEl = document.getElementById( codeId );
			var cityEl = document.getElementById( cityId );
			var input = document.getElementById( inputId );

			if ( ! trigger || ! options || ! codeEl || ! cityEl || ! input ) {
				return;
			}

			var optionButtons = options.querySelectorAll( '.route-option' );

			function open() {
				closeAllPickers();
				options.hidden = false;
				trigger.setAttribute( 'aria-expanded', 'true' );
			}

			function close() {
				options.hidden = true;
				trigger.setAttribute( 'aria-expanded', 'false' );
			}

			function select( option ) {
				optionButtons.forEach( function ( btn ) {
					btn.classList.remove( 'selected' );
					btn.setAttribute( 'aria-selected', 'false' );
				} );
				option.classList.add( 'selected' );
				option.setAttribute( 'aria-selected', 'true' );

				codeEl.textContent = option.getAttribute( 'data-code' );
				cityEl.textContent = option.getAttribute( 'data-city' );
				input.value = option.getAttribute( 'data-value' );
				close();
			}

			trigger.addEventListener( 'click', function () {
				if ( options.hidden ) {
					open();
				} else {
					close();
				}
			} );

			optionButtons.forEach( function ( option ) {
				option.addEventListener( 'click', function () {
					select( option );
				} );
			} );

			return { open: open, close: close };
		}

		var fromPicker = initRoutePicker( 'farway-from', 'from-options', 'from-code', 'farway-from-city', 'farway-from-input' );
		var toPicker = initRoutePicker( 'farway-destination', 'to-options', 'to-code', 'farway-to-city', 'farway-destination-input' );
		var lengthPicker = null;

		// Trip length custom picker.
		var lengthTrigger = document.getElementById( 'farway-length' );
		var lengthOptions = document.getElementById( 'length-options' );
		var lengthValue = document.getElementById( 'length-value' );
		var lengthInput = document.getElementById( 'farway-length-input' );

		if ( lengthTrigger && lengthOptions && lengthValue && lengthInput ) {
			var lengthButtons = lengthOptions.querySelectorAll( '.field-option' );

			lengthPicker = {
				open: function () {
					closeAllPickers();
					lengthOptions.hidden = false;
					lengthTrigger.setAttribute( 'aria-expanded', 'true' );
				},
				close: function () {
					lengthOptions.hidden = true;
					lengthTrigger.setAttribute( 'aria-expanded', 'false' );
				}
			};

			lengthTrigger.addEventListener( 'click', function () {
				if ( lengthOptions.hidden ) {
					lengthPicker.open();
				} else {
					lengthPicker.close();
				}
			} );

			lengthButtons.forEach( function ( option ) {
				option.addEventListener( 'click', function () {
					lengthButtons.forEach( function ( btn ) {
						btn.classList.remove( 'selected' );
						btn.setAttribute( 'aria-selected', 'false' );
					} );
					option.classList.add( 'selected' );
					option.setAttribute( 'aria-selected', 'true' );
					lengthValue.textContent = option.getAttribute( 'data-label' );
					lengthInput.value = option.getAttribute( 'data-value' );
					lengthPicker.close();
				} );
			} );
		}

		function closeAllPickers() {
			[ fromPicker, toPicker, lengthPicker ].forEach( function ( picker ) {
				if ( picker ) {
					picker.close();
				}
			} );
		}

		document.addEventListener( 'click', function ( e ) {
			if ( ! e.target.closest( '.code-field' ) && ! e.target.closest( '.field' ) ) {
				closeAllPickers();
			}
		} );

		// Custom date picker.
		var datePicker = document.getElementById( 'date-picker' );
		var calendar = document.getElementById( 'calendar' );
		var hiddenDate = document.getElementById( 'farway-depart' );
		var dayEl = document.getElementById( 'date-day' );
		var monthEl = document.getElementById( 'date-month' );
		var yearEl = document.getElementById( 'date-year' );
		var grid = document.getElementById( 'calendar-grid' );
		var title = document.getElementById( 'cal-title' );
		var prevBtn = document.getElementById( 'cal-prev' );
		var nextBtn = document.getElementById( 'cal-next' );

		if ( datePicker && calendar && hiddenDate && grid ) {
			var viewYear;
			var viewMonth;

			if ( hiddenDate.value ) {
				var parts = hiddenDate.value.split( '-' );
				viewYear = parseInt( parts[ 0 ], 10 );
				viewMonth = parseInt( parts[ 1 ], 10 ) - 1;
				renderDateLabel( hiddenDate.value );
			} else {
				var now = new Date();
				viewYear = now.getFullYear();
				viewMonth = now.getMonth();
			}

			var monthNames = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ];

			function renderCalendar() {
				var first = new Date( viewYear, viewMonth, 1 );
				var startOffset = ( first.getDay() + 6 ) % 7; // Monday-first.
				var daysInMonth = new Date( viewYear, viewMonth + 1, 0 ).getDate();
				var today = new Date();

				title.textContent = monthNames[ viewMonth ] + ' ' + viewYear;
				grid.innerHTML = '';

				for ( var i = 0; i < startOffset; i++ ) {
					var empty = document.createElement( 'span' );
					empty.className = 'calendar-day empty';
					grid.appendChild( empty );
				}

				for ( var d = 1; d <= daysInMonth; d++ ) {
					var btn = document.createElement( 'button' );
					btn.type = 'button';
					btn.className = 'calendar-day';
					btn.textContent = d;

					var isPast = new Date( viewYear, viewMonth, d ) < new Date( today.getFullYear(), today.getMonth(), today.getDate() );
					if ( isPast ) {
						btn.disabled = true;
					}
					if ( viewYear === today.getFullYear() && viewMonth === today.getMonth() && d === today.getDate() ) {
						btn.classList.add( 'today' );
					}
					if ( hiddenDate.value === formatDate( viewYear, viewMonth, d ) ) {
						btn.classList.add( 'selected' );
					}

					btn.addEventListener( 'click', function ( day ) {
						return function () {
							hiddenDate.value = formatDate( viewYear, viewMonth, day );
							renderDateLabel( hiddenDate.value );
							renderCalendar();
							closeCalendar();
						};
					}( d ) );

					grid.appendChild( btn );
				}
			}

			function renderDateLabel( iso ) {
				var date = new Date( iso + 'T00:00:00' );
				dayEl.textContent = date.getDate();
				monthEl.textContent = monthNames[ date.getMonth() ].slice( 0, 3 );
				yearEl.textContent = date.getFullYear();
			}

			function formatDate( y, m, d ) {
				return y + '-' + String( m + 1 ).padStart( 2, '0' ) + '-' + String( d ).padStart( 2, '0' );
			}

			function openCalendar() {
				calendar.hidden = false;
				datePicker.setAttribute( 'aria-expanded', 'true' );
				renderCalendar();
			}

			function closeCalendar() {
				calendar.hidden = true;
				datePicker.setAttribute( 'aria-expanded', 'false' );
			}

			datePicker.addEventListener( 'click', function () {
				if ( calendar.hidden ) {
					openCalendar();
				} else {
					closeCalendar();
				}
			} );

			prevBtn.addEventListener( 'click', function () {
				viewMonth--;
				if ( viewMonth < 0 ) {
					viewMonth = 11;
					viewYear--;
				}
				renderCalendar();
			} );

			nextBtn.addEventListener( 'click', function () {
				viewMonth++;
				if ( viewMonth > 11 ) {
					viewMonth = 0;
					viewYear++;
				}
				renderCalendar();
			} );

			document.addEventListener( 'click', function ( e ) {
				if ( ! datePicker.contains( e.target ) && ! calendar.contains( e.target ) ) {
					closeCalendar();
				}
			} );
		}

		// Inquiry form.
		var form = document.getElementById( 'inquiry-form' );
		if ( form && window.farwayConfig ) {
			form.addEventListener( 'submit', function ( e ) {
				e.preventDefault();

				var status = form.querySelector( '.form-status' );
				var submit = form.querySelector( 'button[type="submit"]' );
				var original = submit.textContent;

				status.className = 'form-status';
				status.textContent = '';
				submit.textContent = 'Sending…';

				var data = new FormData( form );
				data.append( 'action', 'farway_inquiry' );
				data.append( 'nonce', window.farwayConfig.nonce );

				fetch( window.farwayConfig.ajaxUrl, {
					method: 'POST',
					credentials: 'same-origin',
					body: data
				} )
					.then( function ( res ) { return res.json(); } )
					.then( function ( json ) {
						submit.textContent = original;
						status.className = 'form-status ' + ( json.success ? 'ok' : 'err' );
						status.textContent = json.data ? json.data.message : '';
						if ( json.success ) {
							form.reset();
						}
					} )
					.catch( function () {
						submit.textContent = original;
						status.className = 'form-status err';
						status.textContent = 'Something went wrong. Please try again.';
					} );
			} );
		}

	} );
} )();
