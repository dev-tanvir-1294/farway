=== Farway ===
Contributors: mdtanvirahmed
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: e-commerce, custom-menu, one-column, two-columns, custom-colors, featured-images, custom-logo, travel, blog

A boarding-pass styled travel agency theme with trips, destinations, testimonials, FAQs, and a booking inquiry flow.

== Description ==

Farway is a travel agency and trip-booking theme built around a bold,
single-view (100vh/100vw) boarding-pass hero. It is designed to work with the
Farway Content Types companion plugin, which registers the custom post types a
travel business needs:

* **Trips** — destination, pricing, sale pricing, duration, trip type, difficulty, group size, and inclusions.
* **Destinations** — country, region, best season, currency, and language.
* **Testimonials** — star rating, role/location, related trip, and a verified badge.
* **FAQs** — topic tags with a searchable archive and single view.
* **Bookings** — inquiry submissions are saved as a private post type and emailed to the admin.

The home page search form filters trips by departure, destination, trip length,
and travelers, and site search is wired to return trips, destinations, FAQs,
posts, and pages.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the "Add New" button.
2. Click "Upload Theme" and choose the farway.zip file.
3. Click "Install Now" and then "Activate".
4. Install and activate the Farway Content Types plugin to enable the Trips, Destinations, Testimonials, FAQ, and Booking content types.
5. Create Trips, Destinations, Testimonials, and FAQs under their dashboard menus.
6. Go to Settings > Permalinks and click "Save Changes" once to register the trip, destination, and FAQ permalinks.
7. Assign a menu under Appearance > Menus > Primary Menu (optional — a fallback menu is included).

== Frequently Asked Questions ==

= Does this theme require a plugin? =

Core content types (Trips, Destinations, Testimonials, FAQs, and Bookings) are
provided by the Farway Content Types companion plugin. This keeps content data
portable when the theme is switched and follows the WordPress.org guidance that
content-type registration belongs in a plugin rather than a theme.

= Does this theme require WooCommerce? =

No. Farway declares WooCommerce support for compatibility and works without it.
When WooCommerce is active, store and account pages render through the theme's
WooCommerce template.

= How do I add a destination to a trip? =

Edit the trip and choose a destination from the "Trip details" meta box.
Destinations must be published first.

= Why are my FAQ or trip links returning 404? =

Visit Settings > Permalinks and click "Save Changes". WordPress needs a permalink
flush when a new post type is registered.

== Changelog ==

= 1.2.0 =
* Added the booking inquiry AJAX handler with nonce verification.
* Removed the GSAP CDN dependency in favor of native IntersectionObserver animations.
* Added WooCommerce template and product gallery support.
* Added a skip link, translation template, and consolidated inline styles.

= 1.1.0 =
* Added destination, trip, testimonial, and FAQ metadata.
* Added FAQ archive and single templates.
* Extended search to include trips, destinations, and FAQs.
* Replaced the GSAP CDN dependency with native IntersectionObserver animations.

= 1.0.0 =
* Initial release.

== Credits ==

* Google Fonts: Fraunces, IBM Plex Mono, and Work Sans — SIL Open Font License, https://fonts.google.com/
* No other third-party libraries are bundled or required by the theme.
