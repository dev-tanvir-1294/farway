<?php
/**
 * Customizer settings for the Farway agency front.
 *
 * @package Farway
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register all content controls.
 */
function farway_customize_register( $wp_customize ) {

	/* ---------- Hero copy ---------- */
	$wp_customize->add_section( 'farway_hero', array(
		'title' => __( 'Farway — Hero', 'farway' ),
	) );

	$hero_fields = array(
		'farway_eyebrow'            => array( __( 'Eyebrow', 'farway' ), __( 'Departures open', 'farway' ) ),
		'farway_headline'           => array( __( 'Headline', 'farway' ), __( 'Wander further,', 'farway' ) ),
		'farway_headline_accent'    => array( __( 'Headline middle', 'farway' ), __( 'book with', 'farway' ) ),
		'farway_headline_em'        => array( __( 'Headline accent', 'farway' ), __( 'certainty.', 'farway' ) ),
		'farway_subcopy'            => array( __( 'Subcopy', 'farway' ), __( 'One search across 4,200 verified trip operators worldwide — real availability, transparent pricing, no surprise fees at checkout.', 'farway' ) ),
		'farway_from_code'          => array( __( 'From airport code', 'farway' ), 'DAC' ),
		'farway_from_city'          => array( __( 'From city', 'farway' ), __( 'Dhaka, BD', 'farway' ) ),
	);

	foreach ( $hero_fields as $key => $field ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $field[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $field[0],
			'section' => 'farway_hero',
			'type'    => 'text',
		) );
	}

	/* ---------- Stats ---------- */
	$wp_customize->add_section( 'farway_stats', array(
		'title' => __( 'Farway — Stats', 'farway' ),
	) );

	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting( "farway_stat{$i}_value", array(
			'default'           => $i === 1 ? '4200' : ( $i === 2 ? '18' : '342' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "farway_stat{$i}_value", array(
			'label'   => sprintf( __( 'Stat %d value', 'farway' ), $i ),
			'section' => 'farway_stats',
			'type'    => 'text',
		) );

		$wp_customize->add_setting( "farway_stat{$i}_label", array(
			'default'           => $i === 1 ? __( 'Operators listed', 'farway' ) : ( $i === 2 ? __( 'Avg. saved vs. retail', 'farway' ) : __( 'Trips booked today', 'farway' ) ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( "farway_stat{$i}_label", array(
			'label'   => sprintf( __( 'Stat %d label', 'farway' ), $i ),
			'section' => 'farway_stats',
			'type'    => 'text',
		) );
	}

	/* ---------- Sections ---------- */
	$wp_customize->add_section( 'farway_sections', array(
		'title' => __( 'Farway — Sections', 'farway' ),
	) );

	$sections = array(
		'farway_section_trips'        => array( __( 'Show trips section', 'farway' ), '1' ),
		'farway_section_destinations' => array( __( 'Show destinations section', 'farway' ), '1' ),
		'farway_section_stories'      => array( __( 'Show stories section', 'farway' ), '1' ),
		'farway_section_testimonials' => array( __( 'Show testimonials section', 'farway' ), '1' ),
		'farway_section_faq'          => array( __( 'Show FAQ section', 'farway' ), '1' ),
		'farway_section_contact'      => array( __( 'Show contact section', 'farway' ), '1' ),
	);

	foreach ( $sections as $key => $field ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $field[1],
			'sanitize_callback' => 'absint',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $field[0],
			'section' => 'farway_sections',
			'type'    => 'checkbox',
		) );
	}

	/* ---------- Section headings ---------- */
	$heading_fields = array(
		'farway_trips_title'        => array( __( 'Trips heading', 'farway' ), __( 'Trips people are booking now', 'farway' ) ),
		'farway_destinations_title' => array( __( 'Destinations heading', 'farway' ), __( 'Destinations', 'farway' ) ),
		'farway_stories_title'      => array( __( 'Stories heading', 'farway' ), __( 'Stories from the road', 'farway' ) ),
		'farway_testimonials_title' => array( __( 'Testimonials heading', 'farway' ), __( 'Travelers love Farway', 'farway' ) ),
		'farway_faq_title'          => array( __( 'FAQ heading', 'farway' ), __( 'Before you book', 'farway' ) ),
		'farway_contact_title'      => array( __( 'Contact heading', 'farway' ), __( 'Talk to a travel expert', 'farway' ) ),
	);

	foreach ( $heading_fields as $key => $field ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $field[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $field[0],
			'section' => 'farway_sections',
			'type'    => 'text',
		) );
	}

	/* ---------- Contact info ---------- */
	$wp_customize->add_section( 'farway_contact', array(
		'title' => __( 'Farway — Contact', 'farway' ),
	) );

	$contact_fields = array(
		'farway_contact_phone'   => array( __( 'Phone', 'farway' ), '+1 (555) 010-2030' ),
		'farway_contact_email'   => array( __( 'Email', 'farway' ), 'hello@example.com' ),
		'farway_contact_address' => array( __( 'Address', 'farway' ), '12 Harbor Street, Suite 40' ),
		'farway_contact_hours'   => array( __( 'Hours', 'farway' ), 'Mon–Sat, 9:00–18:00' ),
	);

	foreach ( $contact_fields as $key => $field ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $field[1],
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $field[0],
			'section' => 'farway_contact',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'farway_customize_register' );
